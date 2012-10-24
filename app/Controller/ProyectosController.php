<?php
App::uses('AppController', 'Controller');
/**
 * Proyectos Controller
 *
 * @property Proyecto $Proyecto
 */
class ProyectosController extends AppController {

	public function index() {
		//$this -> Proyecto -> recursive = 0;
		$this -> set('proyectos', $this -> paginate());
	}

	public function admin_listaCorreo($id) {
		$this -> layout = "ajax";
		$this -> Proyecto -> contain('Correo');
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> set("correos", $proyecto["Correo"]);
		$this -> set("proyectoId", $id);
	}
	
	public function admin_crearCorreo() {
		$correo['Correo']['modelo'] = 'Proyecto';
		$correo["Correo"]["llave_foranea"] = $this -> request -> data["Proyecto"]["proyecto_id"];
		$correo["Correo"]["correo"] = $this -> request -> data["Proyecto"]["correo"];
		$correo["Correo"]["nombre"] = $this -> request -> data["Proyecto"]["nombre"];
		$this -> Proyecto -> Correo -> create();
		if ($this -> Proyecto -> Correo -> save($correo)) {
			$this -> Session -> setFlash("Correo Guardado", 'crud/success');
			$this -> redirect(array('action' => 'listaCorreo', $this -> request -> data["Proyecto"]["proyecto_id"]));
		} else {
			$this -> Session -> setFlash("No se pudo guardar el correo", 'crud/error');
			$this -> redirect(array('action' => 'listaCorreo', $this -> request -> data["Proyecto"]["proyecto_id"]));
		}
	}

	public function admin_borrarCorreo($correoId, $proyectoId) {
		if ($this -> Proyecto -> Correo -> delete($correoId)) {
			$this -> Session -> setFlash("Se ha borrado el correo", 'crud/success');
			$this -> redirect(array('action' => 'listaCorreo', $proyectoId));
		} else {
			$this -> Session -> setFlash("No se pudo borrar el correo", 'crud/error');
			$this -> redirect(array('action' => 'listaCorreo', $proyectoId));
		}

	}

	public function tieneAlarmaEmpresa($proyecto_id) {
		$alarmas = $this -> Proyecto -> Alarma -> find("count", array("conditions" => array("Alarma.modelo" => "Proyecto", "Alarma.llave_foranea" => $proyecto_id, "Alarma.para_empresa" => false)));
		if ($alarmas)
			return true;

		return false;
	}

	public function view($id = null) {
		$this -> layout = "empresa";
		$this -> Proyecto -> contain('Subproyecto', 'SolicitudProyecto', 'Archivo', 'EventosServicio');
		$this -> Proyecto -> id = $id;
		if (!$this -> Proyecto -> exists()) {
			throw new NotFoundException(__('Proyecto no válido'));
			//$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $this -> Proyecto -> read(null, $id);
		$comentariosPublicos = $this -> Proyecto -> Observacion -> find(
			"all",
			array(
				"conditions" => array(
					"Observacion.llave_foranea" => $proyecto["Proyecto"]["id"],
					"Observacion.modelo" => "Proyecto",
					"Observacion.es_publico" => true
				)
			)
		);
		$eventos = $proyecto['EventosServicio'];
		$this -> set(compact('proyecto', 'comentariosPublicos', 'eventos'));
	}

	public function solicitudAdicional($proyectoId = null) {
		$this -> layout = "ajax";
		$proyectoId = $proyectoId;
		if (!empty($this -> request -> data)) {
			$proyectoId = $this -> request -> data["SolicitudProyecto"]["proyecto_id"];
			if ($this -> Proyecto -> SolicitudProyecto -> save($this -> request -> data)) {
				$proyecto = $this -> Proyecto -> read(null, $proyectoId);
				$this -> sendBySMTP(
					$proyecto['Proyecto']['responsable_comercial'],
					$proyecto['Proyecto']['correo_comercial'],
					"Solicitud De Subproyecto",
					"Se ha solicitado un subproyecto en el proyecto " . $proyecto['Proyecto']['nombre'] 
				);
				//public function sendbySMTP($nombrePara, $correoPara, $subject, $body, $headers = false) {
				$this -> Session -> setFlash(__('Su solicitud ha sido registrada, pronto uno de nuestros Ingenieros se contactará con usted.'), 'crud/success');
			} else {
				$this -> Session -> setFlash(__('No se pudo procesar su solicitud por favor intente de nuevo'), 'crud/error');
			}
		}
		$this -> set(compact("proyectoId"));
	}

	public function admin_view($id = null) {
		
		if($this -> request -> is('post')) {
			if(!empty($this -> request -> data['Proyecto']['control_ejecucion']) && $this -> Proyecto -> save($this -> request -> data)) {
				$this -> Session -> setFlash('Se actualizó el archivo de control de ejecución', 'crud/success');
			} else {
				$this -> Session -> setFlash('Error al actualizar el archivo de control de ejecución. Verifique que ha subido un archivo e intente de nuevo.', 'crud/error');
			}
			$this -> redirect($this -> referer());
		}
		
		$this -> Proyecto -> id = $id;
		$this -> Proyecto -> contain('Subproyecto', 'SolicitudProyecto', 'Archivo', 'EventosServicio');
		if (!$this -> Proyecto -> exists()) {
			throw new NotFoundException(__('Proyecto no válido'));
			//$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $this -> Proyecto -> read(null, $id);
		$comentariosPrivados = $this -> Proyecto -> Observacion -> find(
			"all",
			array(
				"conditions" => array(
					"Observacion.llave_foranea" => $proyecto["Proyecto"]["id"],
					"Observacion.modelo" => "Proyecto",
					"Observacion.es_publico" => false
				)
			)
		);
		$comentariosPublicos = $this -> Proyecto -> Observacion -> find(
			"all",
			array(
				"conditions" => array(
					"Observacion.llave_foranea" => $proyecto["Proyecto"]["id"],
					"Observacion.modelo" => "Proyecto",
					"Observacion.es_publico" => true
				)
			)
		);
		$eventos = $proyecto['EventosServicio'];
		$this -> set(compact('proyecto', 'comentariosPrivados', 'comentariosPublicos', 'eventos'));
	}
	
	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}

	public function admin_add($id = null) {
		$empresaId = $id;
		if (!empty($this -> request -> data)) {
			$procesar_correos = true;
			$correos_validos = true;
			$texto_no_validos = "";
			$lista_correos = trim($this -> request -> data['Proyecto']['correos']);
			if(!empty($lista_correos)) {
				$lista_correos = trim($lista_correos);
				$lista_correos = explode(",", $lista_correos);
				foreach ($lista_correos as $key => $correo) {
					$lista_correos[$key] = trim($correo);
					$lista_correos[$key] = explode('<', $lista_correos[$key]);
					$lista_correos[$key][0] = trim($lista_correos[$key][0]);
					if(isset($lista_correos[$key][1])) {
						$lista_correos[$key][1] = trim($lista_correos[$key][1], '> ');
						$lista_correos[$key][2] = $this -> isValidEmail($lista_correos[$key][1]);
					} else {
						$lista_correos[$key][2] = false;
					}
					if(!$lista_correos[$key][2]) {
						$correos_validos = false;
						if(isset($lista_correos[$key][1])) {
							$texto_no_validos = 'Por favor revise la lista de correos. Hay un error alrededor del texto "' . $lista_correos[$key][1] . '"';
						} else {
							$texto_no_validos = 'Por favor revise la lista de correos. Hay un error alrededor del texto "' . $lista_correos[$key][0] . '"';
						}
						break;
					}
				}
			} else {
				$procesar_correos = false;
			}
			
			//debug($lista_correos);
			
			if($correos_validos) {
				$this -> Proyecto -> create();
				if ($this -> Proyecto -> save($this -> request -> data)) {
					$usuarios = $this -> requestAction("/usuarios/getOmega");
					// --------------
					if(!empty($this -> request -> data["Proyecto"]["encargado"])) {
						$correo = array();
						$correo["Correo"]["modelo"] = 'Proyecto';
						$correo["Correo"]["llave_foranea"] = $this -> Proyecto -> id;
						$correo["Correo"]["correo"] = $this -> request -> data["Proyecto"]["encargado"];
						$correo["Correo"]["nombre"] = $usuarios[$this -> request -> data["Proyecto"]["encargado"]];
						$this -> Proyecto -> Correo -> create();
						$this -> Proyecto -> Correo -> save($correo);
					}
					// --------------
					$this -> Proyecto -> Correo -> id = 0;
					if(!empty($this -> request -> data["Proyecto"]["supervisor"])) {
						$correo = array();
						$correo["Correo"]["modelo"] = 'Proyecto';
						$correo["Correo"]["llave_foranea"] = $this -> Proyecto -> id;
						$correo["Correo"]["correo"] = $this -> request -> data["Proyecto"]["supervisor"];
						$correo["Correo"]["nombre"] = $usuarios[$this -> request -> data["Proyecto"]["supervisor"]];
						$this -> Proyecto -> Correo -> create();
						$this -> Proyecto -> Correo -> save($correo);
					}
					// --------------
					if($procesar_correos) {
						foreach ($lista_correos as $key => $correo) {
							$correo = array();
							$correo["Correo"]["modelo"] = 'Proyecto';
							$correo["Correo"]["llave_foranea"] = $this -> Proyecto -> id;
							$correo["Correo"]["nombre"] = $lista_correos[$key][0];
							$correo["Correo"]["correo"] = $lista_correos[$key][1];
							$this -> Proyecto -> Correo -> create();
							$this -> Proyecto -> Correo -> save($correo);
						}
					}
					// --------------
					if(!empty($this -> request -> data['Proyecto']['cotizacion'])) {
						$this -> enviarCorreo($this -> Proyecto -> id, "Se ha subido la cotización del proyecto: " . $this -> request -> data["Proyecto"]["nombre"]);
					}
					$this -> Session -> setFlash(__('Se agregó el proyecto'), 'crud/success');
					$this -> redirect(array('action' => 'view', "controller" => "empresas", $this -> request -> data["Proyecto"]["empresa_id"], "proyectos"));
				} else {
					$empresaId = $this -> request -> data["Proyecto"]["empresa_id"];
					$this -> Session -> setFlash(__('No se pudo agregar el proyecto. Por favor, intente de nuevo. ¿Agregó la cotización?'), 'crud/error');
				}
			} else {
				$empresaId = $this -> request -> data["Proyecto"]["empresa_id"];
				$this -> Session -> setFlash($texto_no_validos, 'crud/error');
			}
			
		}
		$empresas = $this -> Proyecto -> Empresa -> find('list');
		$this -> set(compact('empresas', 'empresaId'));
		$this -> set('referer', $this -> referer());
	}

	public function admin_add2($id = null) {
		$this -> layout = "ajax";
		$empresaId = $id;
		if (!empty($this -> request -> data)) {
			$this -> Proyecto -> create();
			if ($this -> Proyecto -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se ha creado la nueva cotizacion, recuerde subir los archivos necesarios'), 'crud/success');
				//$this->redirect(array('action' => 'view',"controller"=>"clientes",$this->data["Proyecto"]["cliente_id"]));
			} else {
				$empresaId = $this -> request -> data["Proyecto"]["empresa_id"];
				$this -> Session -> setFlash(__('No se ha creado la cotización. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		$empresas = $this -> Proyecto -> Empresa -> find('list');
		$this -> set(compact('empresas', 'empresaId'));
	}

	public function admin_edit($id = null) {
		$this -> layout = "ajax";
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(__('Proyecto no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $id;
		if (!empty($this -> request -> data)) {
			if ($this -> Proyecto -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se ha modificado el proyecto.'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$proyecto = $this -> request -> data["Proyecto"]["id"];
				$this -> Session -> setFlash(__('No se ha modificado el proeycto. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Proyecto -> read(null, $id);
		}
		$empresas = $this -> Proyecto -> Empresa -> find('list');
		$this -> set(compact('empresas'));
		$this -> set("proyecto", $id);
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Proyecto no válido'), 'crud/error');
			$this -> redirect($this -> referer());
		}
		if ($this -> Proyecto -> delete($id)) {
			$this -> Session -> setFlash(__('Se eliminó el proyecto'), 'crud/success');
			$this -> redirect($this -> referer());
		}
		$this -> Session -> setFlash(__('No se eliminó el proyecto'), 'crud/error');
		$this -> redirect($this -> referer());
	}

	public function AJAX_eliminarAlarma() {
		$alarmaId = $this -> data["alarmaId"];
		if ($alarmaId) {

			if ($this -> Proyecto -> eliminarAlarmaSola($alarmaId)) {
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
	
	public function admin_verCronograma($id) {
		$proyecto = $this -> Proyecto -> read("cronograma", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cronograma"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);		
	}
	
	public function verControlEjecucion($id) {
		$proyecto = $this -> Proyecto -> read("control_ejecucion", $id);
		$partes = explode("/", $proyecto["Proyecto"]["control_ejecucion"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
	}

	public function verCronograma($id) {
		$proyecto = $this -> Proyecto -> read("cronograma", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cronograma"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
	}

	public function admin_verCotizacion($id) {
		$proyecto = $this -> Proyecto -> read("cotizacion", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cotizacion"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);		
	}

	public function verCotizacion($id) {
		$proyecto = $this -> Proyecto -> read("cotizacion", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cotizacion"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
	}

	public function admin_subirCotizacion() {
		$this -> layout = "ajax";
	}

	public function AJAX_subirCotizacion() {
		$proyectoId = $this -> request -> data["id"];
		$cotizacionPath = $this -> request -> data["path"];
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		if ($proyecto["Proyecto"]["cotizacion"]) {
			$archivo = substr($proyecto["Proyecto"]["cotizacion"], 1);
			$archivo = str_replace("/", DS, $archivo);
			unlink(WWW_ROOT . $archivo);
		}
		$proyecto["Proyecto"]["cotizacion"] = $cotizacionPath;
		/*$proyecto["Proyecto"]["estado_proyecto_id"]=2;//CAmbia estado a en espera de aprobación*/
		if ($this -> Proyecto -> save($proyecto)) {
			$this -> Proyecto -> eliminarAlarmaProyecto($proyectoId, "debe subir la cotización");
			$this -> Proyecto -> crearAlarmaProyecto($proyectoId, "proyecto en espera de aprobación", true);
			$this -> Proyecto -> crearAlarmaProyecto($proyectoId, "en espera de aprobación por el cliente", false);
			$this -> enviarCorreo($proyecto["Proyecto"]["id"], "Se ha subido la cotización del proyecto: " . $proyecto["Proyecto"]["nombre"]);
			echo "La Cotizacion ha sido subida con exito";
		} else {
			debug($this -> Proyecto -> invalidFields());
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function admin_comentarios($id) {
		$this -> layout = "ajax";
		//$this -> Proyecto -> recursive = -1;
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> set(compact("proyecto"));
	}

	public function aprobarCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("proyectoId", $id);
		$this -> set("verificacion", $verificacion);
		$this -> set('proyecto', $this -> Proyecto -> read(null, $id));
	}

	public function confirmarAprobacion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Proyecto"]["id"];
		$this -> Proyecto -> id = $id;
		//$this -> Proyecto -> saveField("estado_proyecto_id", 2);
		$this -> Proyecto -> saveField("estado_proyecto_id", 3);
		//$this -> Proyecto -> set("estado_proyecto_id", 2);
		$this -> Proyecto -> saveField("comentarios", $this -> request -> data["Proyecto"]["comentarios"]);
		//$this -> Proyecto -> set("comentarios", $this -> request -> data["Proyecto"]["comentarios"]);
		//$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		//$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en perfeccionamiento", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$proyecto = $this -> Proyecto -> read('nombre', $id);
		$mail_body =
			"Usted ha apropado la cotizaciòn del proyecto: "
			. $proyecto["Proyecto"]["nombre"]
			. "\n" . $this -> request -> data["Proyecto"]["comentarios"]
			. "\n" . "LA APROBACION DE PROYECTO QUE USTED ACABA DE REALIZAR, 
			SERA TRANSMITIDA A NUESTRA AREA DE OPERACIONES  EN  UN
			TIEMPO DE 24 HORAS. DURANTE ESTE PERIODO USTED PUEDRA
			MODIFICAR LA SOLICITUD COMUNICANDOSE CON SU CONTACTO  O
			CON NUESTRA AREA DE CALIDAD sico@omegaingenieros.com";
		$this -> enviarCorreo($id, $mail_body);
		$this -> Session -> setFlash(__('Gracias por permitirnos hacer parte de su equipo de trabajo.'), 'crud/success');
	}

	public function rechazarCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("proyectoId", $id);
		$this -> set("verificacion", $verificacion);
		$this -> set('proyecto', $this -> Proyecto -> read(null, $id));
	}

	public function confirmarRechazo() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Proyecto"]["id"];
		//$id = $this -> request -> data["id"];
		$this -> Proyecto -> id = $id;
		$this -> Proyecto -> saveField("estado_proyecto_id", 9);
		$this -> Proyecto -> saveField("comentarios", $this -> request -> data["Proyecto"]["comentarios"]);
		//$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en rechazado", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$proyecto = $this -> Proyecto -> read('nombre', $id);
		$mail_body =
			"Se ha rechazado la cotización del proyecto: "
			. $proyecto["Proyecto"]["nombre"]
			. "\n" . $this -> request -> data["Proyecto"]["comentarios"];
		$this -> enviarCorreo($id, $mail_body);
		$this -> Session -> setFlash(__('Esperamos hacer parte de su equipo de trabajo en futuros proyectos'), 'crud/success');
	}

	public function admin_anularCotizacion($id) {
		$this -> layout = "ajax";
		$uno = rand(0, 9);
		$dos = rand(0, 9);
		$tres = rand(0, 9);
		$cuatro = rand(0, 9);
		$verificacion = $uno . $dos . $tres . $cuatro;
		$this -> set("proyectoId", $id);
		$this -> set("verificacion", $verificacion);
	}

	public function admin_confirmarAnulacion() {
		$this -> layout = "ajax";
		$id = $this -> request -> data["Proyecto"]["id"];
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> Proyecto -> set("estado_proyecto_id", 8);
		$this -> Proyecto -> set("comentarios", $this -> request -> data["Proyecto"]["comentarios"]);
		$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en perfeccionamiento", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$mail_body = "Se ha anulado la cotización del proyecto: " . $proyecto["Proyecto"]["nombre"];
		$this -> enviarCorreo($proyecto["Proyecto"]["id"], $mail_body);
		$this -> Session -> setFlash(__('Se ha anulado la cotizazción'), 'crud/success');

	}

	public function admin_ingresarCc($id = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$proyectoId = $this -> request -> data["Proyecto"]["id"];
			$proyecto = $this -> Proyecto -> read(null, $proyectoId);
			$this -> Proyecto -> set("centro_de_costo", $this -> request -> data["Proyecto"]["centro_de_costo"]);
			$this -> Proyecto -> set("estado_proyecto_id", 3);
			if ($this -> Proyecto -> save()) {
				$this -> Proyecto -> crearAlarmaProyecto($proyectoId, "Proyecto en Ejecucion", true);
				$this -> Proyecto -> eliminarAlarmaProyecto($proyectoId, "proyecto en perfeccionamiento");
				$this -> Proyecto -> eliminarAlarmaProyecto($proyectoId, "debe ingresar el centro de costo");
				$this -> Proyecto -> eliminarAlarmaProyecto($proyectoId, "puede iniciar el desarrollo del proyecto");
				$this -> set("flash", true);
			} else {

			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Proyecto -> read(null, $id);
		}
		$this -> set("proyecto", $id);
	}

	public function AJAX_cambiarEstado() {
		$proyectoId = $this -> request -> data["id"];
		$estadoProyectoId = $this -> request -> data["estado_proyecto_id"];
		$this -> Proyecto -> recursive = -1;
		$this -> Proyecto -> read(null, $proyectoId);
		$this -> Proyecto -> set("estado_proyecto_id", $estadoProyectoId);
		if ($this -> Proyecto -> save()) {
			echo "Se ha actualizado el estado del proyecto";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function solicitarProyecto($empresaId = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$empresaId = $this -> request -> data["Proyecto"]["empresa_id"];
			$solicitud["Solicitud"]["empresa_id"] = $empresaId;
			$solicitud["Solicitud"]["tipo_solicitud"] = "proyecto";
			$solicitud["Solicitud"]["texto_solicitud"] = $this -> request -> data["Proyecto"]["texto_solicitud"];

			if ($this -> Proyecto -> Empresa -> Solicitud -> save($solicitud)) {
				$this -> Proyecto -> Empresa -> recursive = -1;
				$empresa = $this -> Proyecto -> Empresa -> read(null, $empresaId);
				$empresa["Empresa"]["tiene_solicitud"] = true;
				$this -> Proyecto -> Empresa -> save($empresa);
				$Name = $empresa["Empresa"]["nombre"];
				//senders name
				$correo = $empresa["Empresa"]["correo"];
				//senders e-mail adress
				$recipient = "ricardopandales@gmail.com";
				//direccion que se va a utilizar por smtp
				$subject = "Solicitud de nuevo proyecto ";
				//subject

				$header = "From: " . $Name . " <" . $correo . ">\r\n";
				//optional headerfields
				//mail($recipient, $subject, $this->data["Proyecto"]["texto_solicitud"], $header);
				$this -> sendbySMTP("", $empresa["Empresa"]["correo"], $subject, $this -> request -> data["Proyecto"]["texto_solicitud"]);
				$this -> sendToOmegaProyecto($Name, $this -> request -> data);
				$this -> Session -> setFlash(__('Su solicitud ha sido enviada con exito, Pronto uno de nuestros Ingenieros se contactará con usted.'), 'crud/success');
			} else {
				$this -> Session -> setFlash(__('No se pudo enviar su solicitud por favor intente de nuevo'), 'crud/error');
			}

		}
		$this -> set(compact("empresaId"));
	}

	public function sendToOmegaProyecto($clienteName, $data) {
		/**
		 * @todo ¿esto debe quedar sin enviar correos?
		 */
	 	/**
		 $this->sendbySMTP($clienteName,"gacruz@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"lcastano@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"wgrajales@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"servicios@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 */
		return true;
	}

	public function AJAX_guardarDesarrollo() {
		$proyectoId = $this -> request -> data["id"];
		$texto = $this -> request -> data["texto"];
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		$proyecto["Proyecto"]["desarrollo"] = $texto;
		if ($this -> Proyecto -> save($proyecto)) {
			echo "Se ha actualizdo el campo";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function verFicha($id) {
		$proyecto = $this -> Proyecto -> read("ficha_tecnica", $id);
		$partes = explode("/", $proyecto["Proyecto"]["ficha_tecnica"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function AJAX_subirFicha() {
		$proyectoId = $this -> data["id"];
		$fichaPath = $this -> data["path"];
		//$this -> Proyecto -> recursive = -1;
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		if ($proyecto["Proyecto"]["ficha_tecnica"]) {
			$archivo = substr($proyecto["Proyecto"]["ficha_tecnica"], 1);
			$archivo = str_replace("/", DS, $archivo);
			unlink(WWW_ROOT . $archivo);
		}
		$proyecto["Proyecto"]["ficha_tecnica"] = $fichaPath;
		if ($this -> Proyecto -> save($proyecto)) {
			echo "La Ficha Tecnica ha sido subida con exito";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function admin_subirFicha() {
		$this -> layout = "ajax";
	}

	public function admin_verFicha($id) {
		$proyecto = $this -> Proyecto -> read("ficha_tecnica", $id);
		$partes = explode("/", $proyecto["Proyecto"]["ficha_tecnica"]);
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
				"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
			),
			'path' => $partes[1] . DS
		);
		$this -> set($params);
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);

	}

	public function quitarPulicacionParaOmega() {
		$proyectoId = $this -> data["id"];
		//$this -> Proyecto -> recursive = -1;
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		$proyecto["Proyecto"]["publicacion_para_omega"] = false;
		if ($this -> Proyecto -> save($proyecto)) {
			echo "OK";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function quitarPulicacionParaCliente() {
		$proyectoId = $this -> data["id"];
		//$this -> Proyecto -> recursive = -1;
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		$proyecto["Proyecto"]["publicacion_para_empresa"] = false;
		if ($this -> Proyecto -> save($proyecto)) {
			echo "OK";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}
	
	public function enviarCorreo($proyectoId, $mail_body) {
		$this -> Proyecto -> contain('Empresa');
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		//$this -> Proyecto -> Empresa -> ClientesUsuario -> bindModel(array("belongsTo" => array("Usuario")));
		//$usuarios = $this -> Proyecto -> Empresa -> ClientesUsuario -> find("all", array("conditions" => array("cliente_id" => $proyecto["Empresa"]["id"])));
		$usuarios = $this -> requestAction('/usuarios/getUsuariosServicio/2');
		$usuarios = $this -> Proyecto -> Empresa -> Usuario -> find("all", array("conditions" => array("Usuario.id" => $usuarios, "Usuario.empresa_id" => $proyecto["Empresa"]["id"])));
		$correoUsuario = "";
		foreach ($usuarios as $usuario) {
			$correoUsuario = $usuario["Usuario"]["correo"];
		}
		$correos = $this -> Proyecto -> Correo -> find("all", array("conditions" => array('Correo.modelo' => 'Proyecto', "Correo.llave_foranea" => $proyectoId)));
		$Name = "OMEGA INGENIEROS";
		//senders name

		/*$correo = "no-responder@omegaingenieros.com"; //senders e-mail adress
		 $subject = "Nueva actividad en el Proyecto: ".$proyecto["Proyecto"]["nombre"]; //subject
		 $header = "From: ". $Name . " <" . $correo . ">\r\n"; //optional headerfields
		 mail($proyecto["Empresa"]["correo"], $subject, $mail_body, $header);
		 mail($correoUsuario, $subject, $mail_body, $header);*/
		$subject = "Nueva actividad en el Proyecto: " . $proyecto["Proyecto"]["nombre"];
		//subject
		$this -> sendbySMTP($proyecto["Empresa"]["nombre"], $proyecto["Empresa"]["correo"], $subject, $mail_body);
		foreach ($correos as $correo) {
			$this -> sendbySMTP($correo["Correo"]["nombre"], $correo["Correo"]["correo"], $subject, $mail_body);
		}
		return true;
	}

}