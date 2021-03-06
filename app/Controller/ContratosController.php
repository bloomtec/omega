<?php
App::uses('AppController', 'Controller');
/**
 * Contratos Controller
 *
 * @property Contrato $Contrato
 */
class ContratosController extends AppController {
	
	protected $exclusiveActions = array('admin_delete');

	public function cambiarEstado($contrato_id, $estado_id) {
		$success = true;
		$message = '';
		if($this->Auth->user('id')) {
			$this->Contrato->id = $contrato_id;
			if(!$this->Contrato->saveField('estado_id', $estado_id)) {
				$success = false;
				$message = 'Ha ocurrido un error al tratar de cambiar el estado del contrato';
			}
			/*
			 * A petición de Carlos se quita la verificación de ser administrador.
			if($this->Auth->user('rol_id') == 1) {
				$this->Contrato->id = $contrato_id;
				if(!$this->Contrato->saveField('estado_id', $estado_id)) {
					$success = false;
					$message = 'Ha ocurrido un error al tratar de cambiar el estado del contrato';
				}
			} else {
				$success = false;
				$message = 'Debe de ser administrador para cambiar el estado de manera arbitraria';
			}*/
		} else {
			$success = false;
			$message = 'Debe de haber iniciado sesión para intentar ejecutar esta acción';
		}

		echo json_encode(
			array(
				'success' => $success,
				'message' => $message
			)
		);

		exit(0);
	}

	public function index() {
		$this -> layout = "empresa";
		//$this -> Contrato -> recursive = 0;
		$this -> set('contratos', $this -> paginate());
	}

	public function view($id = null) {

		if($id) {
			$this -> Session -> write('Contrato.id', $id);
		} else {
			$id = $this -> Session -> read('Contrato.id');
		}

		$this -> layout = "empresa";
		$this -> Contrato -> id = $id;

		if (!$this -> Contrato -> exists()) {
			throw new NotFoundException(__('Contrato no válido'));
		}
		
		$this -> Contrato -> contain(
			'Estado',
			'Tipo',
			'Empresa',
			'Equipo.CategoriasEquipo'
		);
		
		$contrato = $this -> Contrato -> read(null, $id);
		
		$equiposContrato = $this -> Contrato -> ContratosEquipo -> find(
			'list',
			array(
				'conditions' => array(
					'contrato_id' => $contrato['Contrato']['id']
				),
				'fields' => array(
					'ContratosEquipo.equipo_id'
				)
			)
		);
		
		$conditions = array(
			'Equipo.id' => $equiposContrato
		);
		
		$limit = 10;
		
		if($this -> request -> is('post')) {
			if(isset($this -> request -> data['Contrato']['codigo']) && !empty($this -> request -> data['Contrato']['codigo'])) {
				$equipos = $this -> Contrato -> Equipo -> find(
					'list',
					array(
						'conditions' => array(
							'Equipo.id' => $equiposContrato,
							'Equipo.codigo LIKE' => '%' . $this -> request -> data['Contrato']['codigo'] . '%'
						),
						'fields' => array(
							'Equipo.id'
						)
					)
				);
				$conditions['Equipo.id'] = $equipos;
			}
			if(isset($this -> request -> data['Contrato']['categorias_equipo_id']) && !empty($this -> request -> data['Contrato']['categorias_equipo_id'])) {
				$equipos = $this -> Contrato -> Equipo -> find(
					'list',
					array(
						'conditions' => array(
							'Equipo.id' => $equiposContrato,
							'Equipo.categorias_equipo_id' => $this -> request -> data['Contrato']['categorias_equipo_id']
						),
						'fields' => array(
							'Equipo.id'
						)
					)
				);
				if(isset($conditions['equipo_id'])) {
					$equipos_tmp = $conditions['equipo_id'];
					$equipos = array_merge($equipos, $equipos_tmp);
				}
				$conditions['Equipo.id'] = $equipos;
			}

            $this -> Session -> write('Contratos.View.conditions', $conditions);

			$this->redirect(array('action' => 'view', $id));
		}
		$this -> Contrato -> bindModel(
			array(
				"hasAndBelongsToMany" => array(
					'Equipo' => array(
						'className' => 'Equipo',
						'joinTable' => 'contratos_equipos',
						'foreignKey' => 'contrato_id',
						'associationForeignKey' => 'equipo_id',
						'unique' => true,
						'conditions' => $conditions,
						'fields' => '',
						'order' => array(
							"ContratosEquipo.tiene_publicacion_omega" => "desc"
						),
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
					)
				)
			)
		);

        $filtrado = false;

        if(
            $this -> Session -> read('Contratos.View.conditions')
            && $this -> Session -> read('Contratos.View.conditions')
        ) {
            $conditions = $this -> Session -> read('Contratos.View.conditions');
            $filtrado = true;
        }

		$this -> paginate = array(
			'Equipo' => array(
				'conditions' => $conditions,
				'limit' => $limit
			)		
		);

		$equipos = $this -> paginate('Equipo');
		$equipos = $this->sortEquipos($equipos, 1);

        $this -> set('filtrado', $filtrado);
		$this -> set('equipos', $equipos);
		$categoriasEquipos = $this -> Contrato -> Equipo -> CategoriasEquipo -> find('list', array('conditions' => array('CategoriasEquipo.empresa_id' => $contrato['Empresa']['id'])));
		$this -> set(compact('contrato', 'categoriasEquipos'));
	}

	public function admin_index() {
		//$this -> Contrato -> recursive = 0;
		$this -> set('contratos', $this -> paginate());
	}

	public function tienePublicacionEmpresa($contrato_id) {
		$contratosEquipos = $this -> Contrato -> ContratosEquipo -> find("all", array("conditions" => array("contrato_id" => $contrato_id)));
		foreach ($contratosEquipos as $contratosEquipo) {
			if ($contratosEquipo["ContratosEquipo"]["tiene_publicacion_empresa"])
				return true;
		}
		return false;
	}

	public function tieneAlarmaEmpresa($contrato_id) {
		$alarmas = $this -> Contrato -> Alarma -> find("count", array("conditions" => array("Alarma.modelo" => "Contrato", "Alarma.llave_foranea" => $contrato_id, "para_empresa" => false)));
		if ($alarmas) {
			return true;
		} else {
			return false;
		}
	}

	public function admin_view($id = null) {
		
		if($id) {
			$this -> Session -> write('Contrato.id', $id);
		} else {
			$id = $this -> Session -> read('Contrato.id');
		}
		
		$this -> Contrato -> id = $id;
		
		if (!$this -> Contrato -> exists()) {
			throw new NotFoundException(__('Contrato no válido'));
		}
		
		$this -> Contrato -> contain(
			'Estado',
			'Tipo',
			'Empresa',
			'Equipo.CategoriasEquipo'
		);
		
		$contrato = $this -> Contrato -> read(null, $id);
		
		$equiposContrato = $this -> Contrato -> ContratosEquipo -> find(
			'list',
			array(
				'conditions' => array(
					'contrato_id' => $contrato['Contrato']['id']
				),
				'fields' => array(
					'ContratosEquipo.equipo_id'
				)
			)
		);
		
		$conditions = array(
			'Equipo.id' => $equiposContrato
		);
		
		$limit = 10;
		
		if($this -> request -> is('post')) {
			if(isset($this -> request -> data['Contrato']['codigo']) && !empty($this -> request -> data['Contrato']['codigo'])) {
				$equipos = $this -> Contrato -> Equipo -> find(
					'list',
					array(
						'conditions' => array(
							'Equipo.id' => $equiposContrato,
							'Equipo.codigo LIKE' => '%' . $this -> request -> data['Contrato']['codigo'] . '%'
						),
						'fields' => array(
							'Equipo.id'
						)
					)
				);
				$conditions['Equipo.id'] = $equipos;
			}
			if(isset($this -> request -> data['Contrato']['categorias_equipo_id']) && !empty($this -> request -> data['Contrato']['categorias_equipo_id'])) {
				$equipos = $this -> Contrato -> Equipo -> find(
					'list',
					array(
						'conditions' => array(
							'Equipo.id' => $equiposContrato,
							'Equipo.categorias_equipo_id' => $this -> request -> data['Contrato']['categorias_equipo_id']
						),
						'fields' => array(
							'Equipo.id'
						)
					)
				);
				if(isset($conditions['equipo_id'])) {
					$equipos_tmp = $conditions['equipo_id'];
					$equipos = array_merge($equipos, $equipos_tmp);
				}
				$conditions['Equipo.id'] = $equipos;
			}

            $this -> Session -> write('Contratos.View.conditions', $conditions);

			$this->redirect(array('action' => 'view', $id));

		}

		$this -> Contrato -> bindModel(
			array(
				"hasAndBelongsToMany" => array(
					'Equipo' => array(
						'className' => 'Equipo',
						'joinTable' => 'contratos_equipos',
						'foreignKey' => 'contrato_id',
						'associationForeignKey' => 'equipo_id',
						'unique' => true,
						'conditions' => $conditions,
						'fields' => '',
						'order' => array(
							"ContratosEquipo.tiene_publicacion_empresa" => "desc"
						),
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
					)
				)
			)
		);

        $filtrado = false;

        if(
            $this -> Session -> read('Contratos.View.conditions')
            && $this -> Session -> read('Contratos.View.conditions')
        ) {
            $conditions = $this -> Session -> read('Contratos.View.conditions');
            $filtrado = true;
        }

		$this -> paginate = array(
			'Equipo' => array(
				'conditions' => $conditions,
				'limit' => $limit
			)
		);
		$equipos = $this -> paginate('Equipo');
		$equipos = $this->sortEquipos($equipos);

        $this -> set('filtrado', $filtrado);
		$this -> set('equipos', $equipos);
		$contrato = $this -> Contrato -> read(null, $id);
		$categoriasEquipos = $this -> Contrato -> Equipo -> CategoriasEquipo -> find('list', array('conditions' => array('CategoriasEquipo.empresa_id' => $contrato['Empresa']['id'])));
		$this -> set(compact('contrato', 'categoriasEquipos'));
	}

	/**
	 * Ordenar los equipos para mostrar en el listado de primero
	 * aquellos con alarmas
	 *
	 * @param     $equipos
	 * @param int $for_empresa
	 *
	 * @return mixed
	 */
	private function sortEquipos($equipos, $for_empresa = 0) {
		for($i = 0; $i < count($equipos); $i+=1) {
			for($j = 0; $j < count($equipos); $j+=1) {
				if($j > $i) {
					if(empty($equipos[$i]['Alarma']) && !empty($equipos[$j]['Alarma'])) {
						$proceder = false;
						foreach($equipos[$j]['Alarma'] as $key => $alarma) {
							if($alarma['para_empresa'] == $for_empresa) {
								$proceder = true;
							}
						}
						if($proceder) {
							$tmp = $equipos[$j];
							$equipos[$j] = $equipos[$i];
							$equipos[$i] = $tmp;
							break;
						}
					}
				}
			}
		}
		return $equipos;
	}

    public function admin_quitarFiltro($id) {
        $this -> autoRender = false;
        $this -> Session -> delete('Contratos.View.conditions');
        $this -> redirect(array('action' => 'view', $id));
    }

    public function quitarFiltro($id) {
        $this -> autoRender = false;
        $this -> Session -> delete('Contratos.View.conditions');
        $this -> redirect(array('action' => 'view', $id));
    }

	public function admin_add($id = null) {
		$empresaId = $id;
		if ($this -> request -> is('post')) {
			$this -> Contrato -> create();
			if ($this -> Contrato -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('El contrato ha sido guardado'), 'crud/success');
				$this -> redirect(array('action' => 'view', "controller" => "empresas", $this -> request -> data["Contrato"]["empresa_id"], "mantenimientos"));
			} else {
				$empresaId = $this -> request -> data["Contrato"]["empresa_id"];
				$this -> Session -> setFlash(__('No se pudo guardar el Contrato. Porfavor, intente de nuevo.'));
			}
		}
		$empresasAll = $this -> Contrato -> Empresa -> find('all');
		$tipos = $this -> Contrato -> Tipo -> find('list');
		$estados = $this -> Contrato -> Estado -> find('list');
		$empresas = $this -> Contrato -> Empresa -> find('list');
		$equipos = $this -> Contrato -> Equipo -> find('list');
		$this -> set(compact('tipos', 'estados', 'equipos', 'empresas', 'empresasAll', 'empresaId'));
	}

	public function admin_delete($id = null) {
		$this -> autoRender = false;
		$this -> Contrato -> id = $id;
		if (!$this -> Contrato -> exists()) {
			throw new NotFoundException(__('Contrato no válido'));
			$this -> redirect(array('action' => 'index'));
		}
		$contratosEquipo = $this -> Contrato -> ContratosEquipo -> find("list", array('fields' => array('ContratosEquipo.id'), "Conditions" => array("ContratosEquipo.contrato_id" => $id)));
		$this -> loadModel('RevisionContratosEquipo');
		$this -> RevisionContratosEquipo -> deleteAll(array('RevisionContratosEquipo.contratos_equipo_id' => $contratosEquipo));
		/*foreach ($contratosEquipo as $contratoEquipo) {
			//$this -> Contrato -> ContratosEquipo -> Observacion -> deleteAll(array("Observacion.modelo" => 'ContratosEquipo', 'Observacion.llave_foranea' => $contratoEquipo["ContratosEquipo"]["id"]));
			//$this -> Contrato -> ContratosEquipo -> Evento -> deleteAll(array("Evento.contratos_equipo_id" => $contratoEquipo["ContratosEquipo"]["id"]));
			//$this -> Contrato -> ContratosEquipo -> RevisionContratosEquipo -> find('all');
			//$this -> Contrato -> ContratosEquipo -> RevisionContratosEquipo -> deleteAll(array('RevisionContratosEquipo.contratos_equipo_id' => $contratoEquipo["ContratosEquipo"]["id"]));
			//$this -> Contrato -> ContratosEquipo -> delete($contratoEquipo['ContratosEquipo']['id']);
		}*/
		/* Manejar con dependant en true
		$this -> Contrato -> ContratosEquipo -> deleteAll(array("ContratosEquipo.contrato_id" => $contrato["Contrato"]["id"]));
		$this -> Contrato -> Alarma -> deleteAll(array("Alarma.contrato_id" => $contrato["Contrato"]["id"]));
		 * 
		 */
		if ( $this -> Contrato -> delete($id) ) {
			$this -> Session -> setFlash(__('Contrato borrado'), 'crud/success');
			$contrato = $this -> Contrato -> read(null, $id);
			//$this -> redirect(array('action' => 'view', "controller" => "empresas", $contrato["Contrato"]["empresa_id"], "mantenimientos"));
		} else {
			$this -> Session -> setFlash(__('Contrato no fue borrado'), 'crud/error');	
		}
		$this -> redirect($this -> referer());
		//$this->redirect(array("controller"=>"empresas",'action' => 'view',$contrato["Contrato"]["empresa_id"],"mantenimientos"));
		//debug($this -> action);
	}

	public function admin_finalizar($id = null) {
		$this -> Contrato -> id = $id;
		if (!$this -> Contrato -> exists()) {
			throw new NotFoundException(__('Contrato no válido'));
			$this -> redirect(array('action' => 'index'));
		}
		$contrato = $this -> Contrato -> read(null, $id);
		$this -> Contrato -> set("estado_id", 5);

		if ($this -> Contrato -> save()) {
			$this -> Contrato -> ContratosEquipo -> contain();
			$contratosEquipos = $this -> Contrato -> ContratosEquipo -> find("all", array("conditions" => array("ContratosEquipo.contrato_id" => $id)));
			foreach ($contratosEquipos as $contratoEquipo) {
				$this -> Contrato -> ContratosEquipo -> read(null, $contratoEquipo["ContratosEquipo"]["id"]);
				$this -> Contrato -> ContratosEquipo -> set("fase_id", 3);
				$this -> Contrato -> ContratosEquipo -> save();
				$this -> Contrato -> ContratosEquipo -> id = 0;
				//$this -> enviarCorreo($contratoEquipo["ContratosEquipo"]["contrato_id"], $mail_body);

				$this -> Contrato -> crearAlarma($contratoEquipo["ContratosEquipo"]["contrato_id"], "contrato finalizado", true);
				$this -> Contrato -> eliminarAlarma($contratoEquipo["ContratosEquipo"]["contrato_id"], "contrato en desarrollo");

			}
			$this -> Session -> setFlash(__("Se ha actualizado el estado del contrato"), 'crud/success');
			$this -> redirect(array("controller" => "empresas", 'action' => 'view', $contrato["Contrato"]["empresa_id"], "mantenimientos"));
		} else {
			$this -> Session -> setFlash(__('No se pudo cambiar de esto del contrato. Por favor, intente de nuevo'), 'crud/error');
			$this -> redirect(array("controller" => "empresas", 'action' => 'view', $contrato["Contrato"]["empresa_id"], "mantenimientos"));
		}

	}

	public function AJAX_eliminarAlarma() {
		$alarmaId = $this -> data["alarmaId"];
		if ($alarmaId) {
			if ($this -> Contrato -> eliminarAlarmaSola($alarmaId)) {
				echo "SI";
			} else {
				echo "NO";
			}
		} else {
			echo "noparams";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function aprobarCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("contratoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function confirmarAprobacion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Contrato"]["id"];
		
		$this -> Contrato -> id = $id;
		$this -> Contrato -> saveField("comentarios", $this -> request -> data["Contrato"]["comentarios"]);
		$this -> Contrato -> saveField("estado_id", 3);
		//$this -> Contrato -> save();

		$this -> Contrato -> eliminarAlarma($id, "contrato en espera de aprobación");
		$this -> Contrato -> eliminarAlarma($id, "contrato nuevo");
		$this -> Contrato -> crearAlarma($id, "contrato en perfeccionamiento", false);
		$this -> Contrato -> crearAlarma($id, "debe ingresar el centro de costo", false);
		
		$contrato = $this -> Contrato -> read('nombre', $id);
		$mail_body =
			"Se ha aprobado la cotización del contrato de mantenimiento: "
			. $contrato["Contrato"]["nombre"]
			. "\n" . $this -> request -> data["Contrato"]["comentarios"];
		
		//$this -> enviarCorreo($id, $mail_body);

		// Enviar el correo al usuario

		// subject
		$subject = 'Notificación aprobación de cotización SICLOM';

		// message
		$message =
			'<html>
				<head>
					  <title>Notificación aprobación de cotización SICLOM</title>
				</head>
				<body>
					  <p>Se ha aprobado una cotización.</p>
					  <p>Nombre del contrato: ' . $contrato["Contrato"]["nombre"] . '</p>
					  <p>Comentarios: ' . $this -> request -> data["Contrato"]["comentarios"] . '</p>
				</body>
			</html>';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= "To: Carlos Sanchez <csanchez@omegaingenieros.com>" . "\r\n";
		$headers .= 'From: Aplicación SICLOM <no-reply@siclom.omegaingenieros.com>' . "\r\n";

		// Mail it
		mail('csanchez@omegaingenieros.com', $subject, $message, $headers);

		/** ----------------------------------------------------------------------------------------- */
		$this -> Session -> setFlash(__('Gracias por permitirnos hacer parte de su equipo de trabajo.'), 'crud/success');
	}

	//*********ANULAR
	public function admin_anularCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("contratoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function admin_confirmarAnulacion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Contrato"]["id"];
		//$this -> Contrato -> recursive = -1;
		$this -> Contrato -> id = $this -> request -> data["Contrato"]["id"];
		$this -> Contrato -> saveField("comentarios", $this -> request -> data["Contrato"]["comentarios"]);
		$this -> Contrato -> saveField("estado_id", 7);
		//$this -> Contrato -> save();
		$this -> Contrato -> eliminarAlarma($id, "contrato en espera de aprobación");
		$this -> Contrato -> eliminarAlarma($id, "contrato nuevo");
		$this -> Contrato -> eliminarAlarma($id, "debe subir la cotización");
		$this -> Contrato -> crearAlarma($id, "contrato Anulado", true);
		$contrato = $this -> Contrato -> read('nombre', $id);
		$mail_body =
			"Se ha anulado la cotizaciòn del contrato de mantenimiento: "
			. $contrato["Contrato"]["nombre"]
			. "\n" . $this -> request -> data["Contrato"]["comentarios"];
		//$this -> enviarCorreo($id, $mail_body);
		$this -> Session -> setFlash(__('Se ha anulado la cotizazción'), 'crud/success');
	}

	//***********

	//*********Reactivar
	public function admin_reactivarContrato($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("contratoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function admin_confirmarReactivacion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Contrato"]["id"];
		//$this -> Contrato -> recursive = -1;
		$contrato = $this -> Contrato -> read(null, $this -> request -> data["Contrato"]["id"]);
		$this -> Contrato -> set("comentarios", $this -> request -> data["Contrato"]["comentarios"]);
		$this -> Contrato -> set("estado_id", 3);
		$this -> Contrato -> save();
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "contrato en espera de aprobación");
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "contrato nuevo");
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "ebe subir la cotización");
		$this -> Contrato -> crearAlarma($id, "contrato Anulado", true);
		$mail_body = "Se ha reactivado el contrato de mantenimiento: " . $contrato["Contrato"]["nombre"];
		//$this -> enviarCorreo($contrato["Contrato"]["id"], $mail_body);
		$this -> Session -> setFlash(__('Se ha reactivado el contrato'), 'crud/success');
	}

	//***********

	//*********Suspender
	public function admin_suspenderContrato($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("contratoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function admin_confirmarSuspencion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Contrato"]["id"];
		//$this -> Contrato -> recursive = -1;
		$contrato = $this -> Contrato -> read(null, $this -> request -> data["Contrato"]["id"]);
		$this -> Contrato -> set("comentarios", $this -> request -> data["Contrato"]["comentarios"]);
		$this -> Contrato -> set("estado_id", 8);
		$this -> Contrato -> save();
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "contrato en espera de aprobación");
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "contrato nuevo");
		$this -> Contrato -> eliminarAlarma($contrato["Contrato"]["id"], "ebe subir la cotización");
		$this -> Contrato -> crearAlarma($id, "contrato Anulado", true);
		$mail_body = "Se ha suspendido el contrato de mantenimiento: " . $contrato["Contrato"]["nombre"];
		//$this -> enviarCorreo($contrato["Contrato"]["id"], $mail_body);
		$this -> Session -> setFlash(__('Se ha suspendido la cotización'), 'crud/success');
	}

	//***********
	//*---------------

	public function rechazarCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("contratoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function admin_comentarios($contratoId) {
		$this -> layout = "ajax";
		//$this -> Contrato -> recursive = -1;
		$contrato = $this -> Contrato -> read(null, $contratoId);
		$this -> set(compact("contrato"));
	}

	public function comentarios($contratoId) {
		$this -> layout = "ajax";
		//$this -> Contrato -> recursive = -1;
		$contrato = $this -> Contrato -> read(null, $contratoId);
		$this -> set(compact("contrato"));
	}

	public function confirmarRechazo() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Contrato"]["id"];
		//$this -> Contrato -> recursive = -1;
		$this -> Contrato -> id = $id;
		$this -> Contrato -> saveField("comentarios", $this -> request -> data["Contrato"]["comentarios"]);
		$this -> Contrato -> saveField("estado_id", 6);
		//$this -> Contrato -> save();
		$this -> Contrato -> crearAlarma($id, "Se ha rechazado la cotización", false);
		$this -> Contrato -> eliminarAlarma($id, "contrato en espera de aprobación");
		$this -> Contrato -> eliminarAlarma($id, "contrato nuevo");
		
		$contrato = $this -> Contrato -> read('nombre', $id);

		$mail_body =
			"Se ha rechazado la cotizaciòn del contrato de mantenimiento: "
			. $contrato["Contrato"]["nombre"]
			. "\n" . $this -> request -> data["Contrato"]["comentarios"];
		
		//$this -> enviarCorreo($contrato["Contrato"]["id"], $mail_body);
		$this -> Session -> setFlash(__('Esperamos hacer parte de su equipo de trabajo en futuros proyectos.'), 'crud/success');

	}

	//*------------

	public function admin_iniciarDesarrollo($id = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$contratoId = $this -> request -> data["Contrato"]["id"];
			//$this -> Contrato -> recursive = -1;
			$contrato = $this -> Contrato -> read(null, $contratoId);
			$this -> Contrato -> set("fecha_inicio_desarrollo", $this -> request -> data["Contrato"]["fecha_inicio_desarrollo"]);
			$this -> Contrato -> set("estado_id", 4);
			$this -> Contrato -> save();
			$mail_body = "El contrato: " . $contrato["Contrato"]["nombre"] . " ha cambiado de estado a EN DESARROLLO";
			//$this -> enviarCorreo($contratoId, $mail_body);

			$this -> Contrato -> crearAlarma($contratoId, "contrato en desarrollo", true);
			$this -> Contrato -> eliminarAlarma($contratoId, "puede iniciar el desarrollo del contrato");
			$this -> Contrato -> eliminarAlarma($contratoId, "contrato en perfeccionamiento");
			$this -> set("flash", true);
		}
		$this -> set("contrato", $id);
	}

	public function admin_ingresarCc($id = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$contratoId = $this -> request -> data["Contrato"]["id"];
			//$this -> Contrato -> recursive = -1;
			$contrato = $this -> Contrato -> read(null, $contratoId);
			if(isset($this -> request -> data['Contrato']['nombre'])) {
				$this -> Contrato -> set("nombre", $this -> request -> data["Contrato"]["nombre"]);	
			}
			$this -> Contrato -> set("centro_de_costo", $this -> request -> data["Contrato"]["centro_de_costo"]);
			$this -> Contrato -> set("fecha_inicio_desarrollo", $this -> request -> data["Contrato"]["fecha_inicio_desarrollo"]);
			$this -> Contrato -> set("estado_id", 4);

			if ($this -> Contrato -> save()) {
				$mail_body = "El contrato: " . $contrato["Contrato"]["nombre"] . " ha cambiado de estado a EN DESARROLLO";
				//$this -> enviarCorreo($contratoId, $mail_body);
				$this -> Contrato -> crearAlarma($contratoId, "contrato en desarrollo", true);
				$this -> Contrato -> eliminarAlarma($contratoId, "contrato en perfeccionamiento");
				$this -> Contrato -> eliminarAlarma($contratoId, "debe ingresar el centro de costo");

				$this -> set("flash", true);
			} else {

			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Contrato -> read(null, $id);
		}
		$this -> set("contrato", $id);
	}

	public function admin_edit($id = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$contratoId = $this -> request -> data["Contrato"]["id"];
			$contrato = $this -> Contrato -> read(null, $contratoId);
			if(isset($this -> request -> data['Contrato']['nombre'])) {
				$this -> Contrato -> set("nombre", $this -> request -> data["Contrato"]["nombre"]);	
			}
			$this -> Contrato -> set("centro_de_costo", $this -> request -> data["Contrato"]["centro_de_costo"]);
			$this -> Contrato -> set("fecha_inicio_desarrollo", $this -> request -> data["Contrato"]["fecha_inicio_desarrollo"]);

			if ($this -> Contrato -> save()) {
				$mail_body = "El contrato: " . $contrato["Contrato"]["nombre"] . " ha cambiado de estado a EN DESARROLLO";
				//$this -> enviarCorreo($contratoId, $mail_body);
				$this -> Contrato -> crearAlarma($contratoId, "contrato en desarrollo", true);
				$this -> Contrato -> eliminarAlarma($contratoId, "contrato en perfeccionamiento");
				$this -> Contrato -> eliminarAlarma($contratoId, "debe ingresar el centro de costo");

				$this -> set("flash", true);
			} else {

			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Contrato -> read(null, $id);
		}
		$this -> set("contrato", $id);
	}

	public function admin_subirCotizacion() {
		$this -> layout = "ajax";
	}

	public function admin_listaCorreo($id) {
		$this -> layout = "ajax";
		$this -> Contrato -> contain('Correo');
		$contrato = $this -> Contrato -> read(null, $id);
		$this -> set("correos", $contrato["Correo"]);
		$this -> set("contratoId", $id);
	}

	public function admin_crearCorreo() {
		$correo['Correo']['modelo'] = 'Contrato';
		$correo["Correo"]["llave_foranea"] = $this -> request -> data["Contrato"]["contrato_id"];
		$correo["Correo"]["correo"] = $this -> request -> data["Contrato"]["correo"];
		$correo["Correo"]["nombre"] = $this -> request -> data["Contrato"]["nombre"];
		$this -> Contrato -> Correo -> create();
		if ($this -> Contrato -> Correo -> save($correo)) {
			$this -> Session -> setFlash(__("Correo Guardado"), 'crud/success');
			$this -> redirect(array('action' => 'listaCorreo', $this -> request -> data["Contrato"]["contrato_id"]));
		} else {
			$this -> Session -> setFlash("No se pudo guardar el correo");
			$this -> redirect(array('action' => 'listaCorreo', $this -> request -> data["Contrato"]["contrato_id"]));
		}
	}

	public function admin_borrarCorreo($correoId, $contratoId) {
		if ($this -> Contrato -> Correo -> delete($correoId)) {
			$this -> Session -> setFlash(__("Se ha borrado el correo"), 'crud/success');
			$this -> redirect(array('action' => 'listaCorreo', $contratoId));
		} else {
			$this -> Session -> setFlash(__("No se pudo borrar el correo"), 'crud/error');
			$this -> redirect(array('action' => 'listaCorreo', $contratoId));
		}

	}

	public function admin_verCotizacion($id) {
		$contrato = $this -> Contrato -> read("cotizacion", $id);
		$partes = explode("/", $contrato["Contrato"]["cotizacion"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);

	}

	public function verCotizacion($id) {
		$contrato = $this -> Contrato -> read("cotizacion", $id);
		$partes = explode("/", $contrato["Contrato"]["cotizacion"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array(
			'id' => $partes[2],
			'name' => $nombrePartido[0],
			'download' => true,
			'extension' => $nombrePartido[1],
			'mimeType' => array(
				'docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
				"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
				"ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
				"potx" => "application/vnd.openxmlformats-officedocument.presentationml.template",
				"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"),
				'path' => $partes[1] . DS
			);
		$this -> set($params);
	}

	public function AJAX_subirCotizacion() {
		$contratoId = $this -> data["id"];
		$cotizacionPath = $this -> data["path"];
		$contrato = $this -> Contrato -> read(null, $contratoId);
		if ($contrato["Contrato"]["cotizacion"]) {
			$archivo = substr($contrato["Contrato"]["cotizacion"], 1);
			$archivo = str_replace("/", DS, $archivo);
			unlink(WWW_ROOT . $archivo);
		}
		$contrato["Contrato"]["cotizacion"] = $cotizacionPath;
		$contrato["Contrato"]["estado_id"] = 2;
		//CAmbia estado a en espera de aprobación
		if ($this -> Contrato -> save($contrato)) {
			$this -> Contrato -> eliminarAlarma($contratoId, "debe subir la cotización");
			$this -> Contrato -> crearAlarma($contratoId, "contrato en espera de aprobación", true);
			$this -> enviarCorreo($contrato["Contrato"]["id"], "Se ha subido la cotización del contrato: " . $contrato["Contrato"]["nombre"]);
			echo "La cotización ha sido subida con exito";
		} else {
			debug($this -> data);
			debug($contrato);
			debug($this -> Contrato -> invalidFields());
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function enviarCorreo($contratoId, $mail_body) {
		$this -> Contrato -> contain('Empresa');
		//$this -> Contrato -> recursive = 1;
		$contrato = $this -> Contrato -> read(null, $contratoId);
		//$this -> Contrato -> Empresa -> EmpresasUsuario -> bindModel(array("belongsTo" => array("Usuario")));
		$usuarios = $this -> requestAction('/usuarios/getUsuariosServicio/1');
		$usuarios = $this -> Contrato -> Empresa -> Usuario -> find("all", array("conditions" => array("Usuario.id" => $usuarios, "Usuario.empresa_id" => $contrato["Empresa"]["id"])));
		$emailUsuario = "";
		foreach ($usuarios as $usuario) {
			$emailUsuario = $usuario["Usuario"]["correo"];
		}
		$correos = $this -> Contrato -> Correo -> find("all", array("conditions" => array('Correo.modelo' => 'Contrato', "Correo.llave_foranea" => $contratoId)));

		$Name = "OMEGA INGENIEROS";
		//senders name
		$email = "no-responder@omegaingenieros.com";
		//senders e-mail adress
		$subject = "Nueva actividad en el contrato: " . $contrato["Contrato"]["nombre"];
		//subject
		$header = "From: " . $Name . " <" . $email . ">\r\nPort:587\r\n";
		//optional headerfields
		//	mail($contrato["Empresa"]["email"], $subject, $mail_body, $header);
		//	mail($emailUsuario, $subject, $mail_body, $header);
		$this -> sendbySMTP("", $emailUsuario, $subject, $mail_body);
		$this -> sendbySMTP($contrato["Empresa"]["nombre"], $contrato["Empresa"]["correo"], $subject, $mail_body);
		if (!empty($correos)) {
			foreach ($correos as $correo) {
				$recipient = $correo["Correo"]["correo"];
				//recipient
				//mail($recipient, $subject, $mail_body, $header);
				$this -> sendbySMTP($correo["Correo"]["nombre"], $correo["Correo"]["correo"], $subject, $mail_body);
			}
		}
		return true;
	}

	public function admin_alarmaEquipo($equipo_id) {
		return $this->_alarmaEquipo($equipo_id);
	}

	public function alarmaEquipo($equipo_id) {
		return $this->_alarmaEquipo($equipo_id);
	}

	private function _alarmaEquipo($equipo_id) {
		$this->loadModel('Alarma');
		$alarma = $this->Alarma->find(
			'first',
			array(
				'conditions' => array(
					'Alarma.modelo' => 'Equipo',
					'Alarma.llave_foranea' => $equipo_id
				)
			)
		);
		/*if($alarma) {
			return true;
		} else {
			return false;
		}*/
		return $alarma;
	}

}
