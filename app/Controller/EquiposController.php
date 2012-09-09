<?php
App::uses('AppController', 'Controller');
/**
 * Equipos Controller
 *
 * @property Equipo $Equipo
 */
class EquiposController extends AppController {

	public function index() {
		$this -> layout = "empresa";
		//$this -> Equipo -> recursive = 0;
		$this -> set('equipos', $this -> paginate());
	}

	public function view($id = null, $contratoId, $tipoContrato) {
		$this -> layout = "empresa";
		if (!$id) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		$equipo = $this -> Equipo -> read(null, $id);
		/** Definido en el modelo
		$this -> Equipo -> ContratosEquipo -> bindModel(
			array(
				"hasMany" => array(
					'ObservacionPublica' => array(
						'className' => 'ObservacionPublica',
						'foreignKey' => 'contratos_equipo_id'
					),
					'ObservacionPrivada' => array(
						'className' => 'ObservacionPublica',
						'foreignKey' => 'contratos_equipo_id'
					),
				)
			)
		);
		 */
		$this -> Equipo -> ContratosEquipo -> contain();
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> find(
			"first",
			array(
				"conditions" => array(
					"ContratosEquipo.equipo_id" => $id,
					"ContratosEquipo.contrato_id" => $contratoId
				)
			)
		);
		$contrato = $this -> Equipo -> Contrato -> read(null, $contratoId);
		//$observacionesPrivadas=$this->Equipo->ContratosEquipo->ObservacionPrivada->observaciones($contratoEquipo);
		//$observacionesPrivadas = $this -> ObservacionPrivada -> find("all", array("conditions" => array("ObservacionPrivada.contratos_equipo_id" => $contratoEquipo["ContratosEquipo"]["id"])));
		//$observacionesPublicas = $this -> Equipo -> ContratosEquipo -> ObservacionPublica -> observaciones($contratoEquipo);
		$observacionesPrivadas = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
			"all",
			array(
				"conditions" => array(
					"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"],
					"Observacione.modelo" => "ContratosEquipo",
					"Observacione.es_publico" => false
				)
			)
		);
		$observacionesPublicas = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
			"all",
			array(
				"conditions" => array(
					"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"],
					"Observacione.modelo" => "ContratosEquipo",
					"Observacione.es_publico" => true
				)
			)
		);
		$eventos = $this -> Equipo -> ContratosEquipo -> Evento -> find(
			"all",
			array(
				"conditions" => array(
					"Evento.contratos_equipo_id" => $contratoEquipo["ContratosEquipo"]["id"]
				)
			)
		);
		$this -> set(compact("observacionesPublicas", "observacionesPrivadas", "contratoEquipo", "tipoContrato", "contrato", "eventos", "equipo"));
	}

	public function add() {
		$this -> layout = "empresa";
		if (!empty($this -> request -> data)) {
			$this -> Equipo -> create();
			if ($this -> Equipo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se registró el equipo'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se registró el equipo. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		$empresas = $this -> Equipo -> CategoriasEquipo -> Empresa -> find('list');
		$this -> set(compact('empresas'));
	}

	public function edit($id = null) {
		$this -> layout = "empresa";
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			if ($this -> Equipo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se modificó el equipo'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo modificar el equipo. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Equipo -> read(null, $id);
		}
		$empresas = $this -> Equipo -> CategoriasEquipo -> Empresa -> find('list');
		$this -> set(compact('empresas'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Equipo -> delete($id)) {
			$this -> Session -> setFlash(__('Se eliminó el equipo'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el equipo'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

	public function admin_index() {
		//$this -> Equipo -> recursive = 0;
		$this -> set('equipos', $this -> paginate());
	}

	public function admin_Finalizar($contratoEquipoId, $tipo) {
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
		$contratoEquipo["ContratosEquipo"]["fase_id"] = 3;
		$contratoEquipo["ContratosEquipo"]["fecha_finalizacion"] = date("Y-m-d", strtotime("now"));
		if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
			$this -> redirect(array('action' => 'view', $contratoEquipo["ContratosEquipo"]["equipo_id"], $contratoEquipo["ContratosEquipo"]["contrato_id"], $tipo));
		} else {

		}
	}

	public function admin_view($id = null, $contratoId, $tipoContrato) {
		if (!$id) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		$equipo = $this -> Equipo -> read(null, $id);
		/** Esto esta en el modelo
		$this -> Equipo -> ContratosEquipo -> bindModel(array("hasMany" => array('ObservacionPublica' => array('className' => 'ObservacionPublica', 'foreignKey' => 'contratos_equipo_id'), 'ObservacionPrivada' => array('className' => 'ObservacionPublica', 'foreignKey' => 'contratos_equipo_id'), )));
		 */ 
		$this -> Equipo -> ContratosEquipo -> contain();
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> find(
			"first",
			array(
				"conditions" => array(
					"ContratosEquipo.equipo_id" => $id,
					"ContratosEquipo.contrato_id" => $contratoId
				)
			)
		);
		//debug($contratoEquipo);
		$contrato = $this -> Equipo -> Contrato -> read(null, $contratoId);
		//$observacionesPrivadas=$this->Equipo->ContratosEquipo->ObservacionPrivada->observaciones($contratoEquipo);
		//$observacionesPrivadas = $this -> ObservacionPrivada -> find("all", array("conditions" => array("ObservacionPrivada.contratos_equipo_id" => $contratoEquipo["ContratosEquipo"]["id"])));
		//$observacionesPublicas = $this -> Equipo -> ContratosEquipo -> ObservacionPublica -> observaciones($contratoEquipo);
		$observacionesPrivadas = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
			"all",
			array(
				"conditions" => array(
					"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"],
					"Observacione.modelo" => "ContratosEquipo",
					"Observacione.es_publico" => false
				)
			)
		);
		$observacionesPublicas = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
			"all",
			array(
				"conditions" => array(
					"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"],
					"Observacione.modelo" => "ContratosEquipo",
					"Observacione.es_publico" => true
				)
			)
		);
		$eventos = $this -> Equipo -> ContratosEquipo -> Evento -> find(
			"all",
			array(
				"conditions" => array(
					"Evento.contratos_equipo_id" => $contratoEquipo["ContratosEquipo"]["id"]
				)
			)
		);
		$this -> set(compact("observacionesPublicas", "observacionesPrivadas", "contratoEquipo", "tipoContrato", "contrato", "eventos", 'equipo'));
	}

	public function admin_add($id = null) {
		if ($id)
			$contratoId = $id;
		if (!empty($this -> request -> data)) {
			$this -> Equipo -> create();
			if ($this -> Equipo -> save($this -> request -> data)) {
				$contrato = $this -> Equipo -> Contrato -> read(null, $this -> request -> data["Contrato"]["Contrato"][0]);
				if ($contrato["Contrato"]["tipo_id"] == 1) {
					$contratosEquipo = $this -> Equipo -> ContratosEquipo -> find(
						"first",
						array(
							"conditions" => array(
								"contrato_id" => $this -> request -> data["Contrato"]["Contrato"][0],
								"equipo_id" => $this -> Equipo -> id
							)
						)
					);
					$this -> Equipo -> ContratosEquipo -> read(null, $contratosEquipo["ContratosEquipo"]["id"]);
					$this -> Equipo -> ContratosEquipo -> set("fase_id", 2);
					$this -> Equipo -> ContratosEquipo -> save();
				}
				$this -> Session -> setFlash(__('El equipo ha sido guardado'), 'crud/success');
				$this -> redirect(array('action' => 'view', 'controller' => 'contratos', $this -> request -> data["Contrato"]["Contrato"][0]));
			} else {
				$contratoId = $this -> request -> data["Contrato"]["Contrato"][0];
				$this -> Session -> setFlash(__('No se pudo guardar el equipo. Por favor, intente de nuevo.'), 'crud/error');
			}

		}
		$contratos = $this -> Equipo -> Contrato -> find("list");
		$this -> set(compact('contratoId', 'contratos'));
	}

	public function admin_relacionar($id = null) {
		if ($id)
			$contratoId = $id;
		if (!empty($this -> request -> data["Equipos"])) {
			$contratoId = $this -> request -> data["Contrato"]["Contrato"][0];
			foreach ($this->data["Equipos"] as $contrato) {
				if (!empty($contrato)) {
					foreach ($contrato as $equipo) {
						$contratosEquipo["ContratosEquipo"]["contrato_id"] = $contratoId;
						$contratosEquipo["ContratosEquipo"]["equipo_id"] = $equipo;
						$contratoA = $this -> Equipo -> Contrato -> read(null, $this -> request -> data["Contrato"]["Contrato"][0]);
						if ($contratoA["Contrato"]["tipo_id"] == 1) {
							$contratosEquipo["ContratosEquipo"]["fase_id"] = 2;
						} else {
							$contratosEquipo["ContratosEquipo"]["fase_id"] = 1;
						}

						$equiposGuardados[0] = false;
						if (!isset($equiposGuardados[$equipo])) {
							$this -> Equipo -> ContratosEquipo -> create();
							if ($this -> Equipo -> ContratosEquipo -> save($contratosEquipo))
								$equiposGuardados[$equipo] = true;
						}
					}
				}
			}
			$this -> Session -> setFlash(__('Se ha relacionado con exito el equipo al contrato, orpima volver para ir al contrato o relacione otro equipo si lo desea.'), 'crud/success');
		}
		$contrato = $this -> Equipo -> Contrato -> read("empresa_id", $contratoId);
		$contratos = $this -> Equipo -> Contrato -> find("list");
		$contratosCompleto = $this -> Equipo -> Contrato -> find(
			"all",
			array(
				"conditions" => array(
					"Contrato.cliente_id" => $contrato["Contrato"]["empresa_id"],
					"Contrato.id <>" => $contratoId
				)
			)
		);
		$equiposDelContrato = $this -> Equipo -> ContratosEquipo -> find(
			"list",
			array(
				"conditions" => array(
					"ContratosEquipo.contrato_id" => $contratoId
				),
				"fields" => array(
					"ContratosEquipo.equipo_id",
					"ContratosEquipo.id"
				)
			)
		);
		$this -> set(compact('contratoId', 'contratos', "contratosCompleto", "equiposDelContrato"));
	}

	public function admin_edit($id = null, $contratoId) {
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			if ($this -> Equipo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('El equipo ha sido guardado'), 'crud/success');
				$this -> redirect(array('action' => 'view', 'controller' => 'empresas', $this -> request -> data["Equipo"]["empresa_id"]));
			} else {
				$this -> Session -> setFlash(__('No se pudo guardar el equipo. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Equipo -> read(null, $id);
		}
		$this -> set("contrato", $contratoId);
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Equipo -> delete($id)) {
			$this -> Session -> setFlash(__('Se eliminó el equipo'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el equipo'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

	public function admin_subirFicha() {
		$this -> layout = "ajax";
	}

	public function admin_verFicha($id) {
		$equipo = $this -> Equipo -> read("ficha_tecnica", $id);
		$partes = explode("/", $equipo["Equipo"]["ficha_tecnica"]);

		$nombrePartido = explode(".", $partes[2]);
		//debug($partes);
		//debug($nombrePartido);
		$this -> view = 'Media';
		$params = array(
			'id' => $partes[2],
			'name' => $nombrePartido[0],
			'download' => false,
			'extension' => $nombrePartido[1],
			'mimeType' => array(
				'docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
				"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
				"ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
				"potx" => "application/vnd.openxmlformats-officedocument.presentationml.template",
				"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
	}

	public function verFicha($id) {
		$equipo = $this -> Equipo -> read("ficha_tecnica", $id);
		$partes = explode("/", $equipo["Equipo"]["ficha_tecnica"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> view = 'Media';
		$params = array(
			'id' => $partes[2],
			'name' => $nombrePartido[0],
			'download' => false,
			'extension' => $nombrePartido[1],
			'mimeType' => array(
				'docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
				"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
				"ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
				"potx" => "application/vnd.openxmlformats-officedocument.presentationml.template",
				"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
	}

	public function AJAX_subirFicha() {
		$equipoId = $this -> params["form"]["id"];
		$equipoFichaTecnicaPath = $this -> params["form"]["path"];
		//$this -> Equipo -> recursive = -1;
		$equipo = $this -> Equipo -> read(null, $equipoId);
		if ($equipo["Equipo"]["ficha_tecnica"]) {
			$archivo = substr($equipo["Equipo"]["ficha_tecnica"], 1);
			$archivo = str_replace("/", DS, $archivo);
			unlink(WWW_ROOT . $archivo);
		}
		$equipo["Equipo"]["ficha_tecnica"] = $equipoFichaTecnicaPath;
		if ($this -> Equipo -> save($equipo)) {
			echo "La Ficha Tecnica ha sido subida con exito";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function AJAX_registrarVisita() {
		$visita["RevisionContratosEquipo"]["contratos_equipo_id"] = $this -> params["form"]["contratos_equipo_id"];
		$visita["RevisionContratosEquipo"]["usuario_id"] = $this -> params["form"]["usuarioId"];
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $visita["RevisionContratosEquipo"]["contratos_equipo_id"]);
		//$this -> Contrato -> recursive = -1;
		$contrato = $this -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
		//Desactivo las alarmas de publicaciones nuevas
		$empresa = true;
		$servicios_usuario = $this -> requestAction('/usuarios/getServiciosUsuario/' . $this -> Auth -> user('id'));
		if (in_array(1, $servicios_usuario)) {
			if ($contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"])
				$contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"] = false;
		}
		if ($this -> Auth -> user('rol_id') <= 2) {
			if ($contratoEquipo["ContratosEquipo"]["tiene_publicacion_cliente"])
				$contratoEquipo["ContratosEquipo"]["tiene_publicacion_cliente"] = false;
			$empresa = false;
			//Esto quiere decir que la ultima actualizacion la hizo omega
		}
		$this -> Equipo -> ContratosEquipo -> save($contratoEquipo);
		if ($empresa) {
			$contratosEquipoDelContratoConPubliOmega = $this -> Equipo -> ContratosEquipo -> find("count", array("ContratosEquipo.tiene_publicacion_omega" => true));
			if ($contratosEquipoDelContratoConPubliOmega > 0) {
				$contrato["Contrato"]["tiene_publicacion_omega"] = false;
				$this -> Contrato -> save($contrato);
			}
		} else {
			$contratosEquipoDelContratoConPubliCliente = $this -> Equipo -> ContratosEquipo -> find("count", array("ContratosEquipo.tiene_publicacion_cliente" => true));
			if ($contratosEquipoDelContratoConPubliCliente > 0) {
				$contrato["Contrato"]["tiene_publicacion_empresa"] = false;
				$this -> Contrato -> save($contrato);
			}
		}

		if ($this -> Equipo -> ContratosEquipo -> RevisionContratosEquipo -> save($visita)) {
			echo "OK";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function AJAX_verificarVisitas() {
		$visita["contrato_id"] = $this -> params["form"]["contrato_id"];
		$visita["usuario_id"] = $this -> params["form"]["usuarioId"];
		$this -> Equipo -> bindModel(
			array(
				"hasMany" => array(
					'ContratosEquipo' => array(
						'className' => 'ContratosEquipo',
						'foreignKey' => 'equipo_id',
						'dependent' => false
					)
				)
			)
		);
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> find(
			"first",
			array(
				"ContratosEquipo.usuario_id" => $visita["usuario_id"],
				"ContratosEquipo.contrato_id" => $visita["contrato_id"]
			)
		);
		$ultimaVisita = $this -> Equipo -> ContratosEquipo -> RevisionContratosEquipo -> getLast($visita["usuario_id"], $contratoEquipo["ContratosEquipo"]["id"]);
		if ($ultimaVisita) {
			$mensajes = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
				"count",
				array(
					"conditions" => array(
						"Observacione.usuario_id <>" => $visita["usuario_id"],
						"Observacione.created >" => $ultimaVisita["RevisionContratosEquipo"]["created"],
						"Observacione.es_publico" => true,
						"Observacione.modelo" => "ContratosEquipo",
						"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"]
					)
				)
			);
			if ($this -> Auth -> user('rol_id') <= 2) {
				$mensajes += $this -> Equipo -> ContratosEquipo -> Observacione -> find(
				"count",
				array(
					"conditions" => array(
						"Observacione.usuario_id <>" => $visita["usuario_id"],
						"Observacione.created >" => $ultimaVisita["RevisionContratosEquipo"]["created"],
						"Observacione.es_publico" => false,
						"Observacione.modelo" => "ContratosEquipo",
						"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"]
					)
				)
			);
			}
		} else {
			/*		$this->Equipo->bindModel(array("hasMany"=>array(	'ContratosEquipo' => array(
			 'className' => 'ContratosEquipo',
			 'foreignKey' => 'equipo_id',
			 'dependent' => false,
			 )
			 )));*/
			$mensajes = $this -> Equipo -> ContratosEquipo -> Observacione -> find(
				"count",
				array(
					"conditions" => array(
						"Observacione.usuario_id <>" => $visita["usuario_id"],
						"Observacione.es_publico" => true,
						"Observacione.modelo" => "ContratosEquipo",
						"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"]
					)
				)
			);
			if ($this -> Auth -> user('rol_id') <= 2) {
				$mensajes += $this -> Equipo -> ContratosEquipo -> Observacione -> find(
					"count",
					array(
						"conditions" => array(
							"Observacione.usuario_id <>" => $visita["usuario_id"],
							"Observacione.es_publico" => false,
							"Observacione.modelo" => "ContratosEquipo",
							"Observacione.llave_foranea" => $contratoEquipo["ContratosEquipo"]["id"]
						)
					)
				);
			}
		}
		echo $mensajes;
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function admin_addProximaRevision($id = null) {
		$this -> layout = "ajax";
		$mensaje = false;
		$contratoEquipoId = $id;
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			$contratoEquipoId = $this -> request -> data["ContratosEquipo"]["id"];
			$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
			$contratoEquipo["ContratosEquipo"]["proxima_revision"] = $this -> request -> data["ContratosEquipo"]["proxima_revision"];
			if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
				$mensaje = true;
			} else {
				$this -> Session -> setFlash(__('No se pudo guardar el registro. Por favor, intente de nuevo.'), 'crud/error');
			}
		}

		$this -> set(compact("mensaje", "contratoEquipoId"));
	}

	public function admin_comenzarDesarrollo($id = null) {
		$this -> layout = "ajax";
		$mensaje = false;
		$contratoEquipoId = $id;
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(__('Equipo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			$contratoEquipoId = $this -> request -> data["ContratosEquipo"]["id"];
			$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
			$contratoEquipo["ContratosEquipo"]["fase_id"] = 2;
			$contratoEquipo["ContratosEquipo"]["inicio_desarrollo"] = $this -> request -> data["ContratosEquipo"]["inicio_desarrollo"];
			if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
				$mensaje = true;
			} else {
				$this -> Session -> setFlash(__('No se pudo guardar el registro. Por favor, intente de nuevo.'), 'crud/error');
			}
		}

		$this -> set(compact("mensaje", "contratoEquipoId"));
	}

	public function AJAX_guardarDiagnostico() {
		$contratoEquipoId = $this -> params["form"]["id"];
		$texto = $this -> params["form"]["texto"];
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
		$contratoEquipo["ContratosEquipo"]["diagnostico"] = $texto;
		if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
			echo "Se ha actualizdo el diagnostico";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function AJAX_guardarObservacionesFinales() {
		$contratoEquipoId = $this -> params["form"]["id"];
		$texto = $this -> params["form"]["texto"];
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
		$contratoEquipo["ContratosEquipo"]["observaciones_finales"] = $texto;
		if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
			echo "Se han guardado las observaciones finales";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function AJAX_guardarActividadesConcluidas() {
		$contratoEquipoId = $this -> params["form"]["id"];
		$texto = $this -> params["form"]["texto"];
		$contratoEquipo = $this -> Equipo -> ContratosEquipo -> read(null, $contratoEquipoId);
		$contratoEquipo["ContratosEquipo"]["actividades_concluida"] = $texto;
		if ($this -> Equipo -> ContratosEquipo -> save($contratoEquipo)) {
			echo "Se ha guardado la descripcion de las actividades";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

}