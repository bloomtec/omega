<?php
App::uses('AppController', 'Controller');
/**
 * Proyectos Controller
 *
 * @property Proyecto $Proyecto
 */
class ProyectosController extends AppController {
	
	public function index() {
		$this -> Proyecto -> recursive = 0;
		$this -> set('proyectos', $this -> paginate());
	}

	public function prueba() {
		$body = "Esta es una prueba de correo electronico";
		$this -> Email -> smtpOptions = array('port' => '465', 'timeout' => '30', 'auth' => true, 'host' => 'ssl://smtp.gmail.com', 'username' => 'omegaingsoporte@gmail.com', 'password' => 'omega123', );
		$nombrePara = "";
		$subject = "prueba";
		$correoPara = "tatiana0204@gmail.com";
		$this -> Email -> delivery = 'smtp';
		$this -> Email -> from = 'Aplicación Web Omega Ingenieros <no-responder@omegaingenieros.com>';
		$this -> Email -> to = $nombrePara . '<' . $correoPara . '>';
		$this -> Email -> subject = $subject;
		$this -> Email -> send($body);

		/* Check for SMTP errors. */
		debug($this -> Email -> smtpError);

	}

	public function admin_listaCorreo($id) {
		$this -> layout = "ajax";
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> set("correos", $proyecto["Email"]);
		$this -> set("proyectoId", $id);
	}

	public function admin_crearCorreo() {
		$correo["Email"]["proyecto_id"] = $this -> data["Proyecto"]["proyecto_id"];
		$correo["Email"]["email"] = $this -> data["Proyecto"]["email"];
		$correo["Email"]["nombre"] = $this -> data["Proyecto"]["nombre"];
		$this -> Proyecto -> Email -> create();
		if ($this -> Proyecto -> Email -> save($correo)) {
			$this -> Session -> setFlash("Correo Guardado");
			$this -> redirect(array('action' => 'listaCorreo', $this -> data["Proyecto"]["proyecto_id"]));
		} else {
			$this -> Session -> setFlash("No se pudo guardar el correo");
			$this -> redirect(array('action' => 'listaCorreo', $this -> data["Proyecto"]["proyecto_id"]));
		}

	}

	public function admin_borrarCorreo($correoId, $proyectoId) {
		if ($this -> Proyecto -> Email -> delete($correoId)) {
			$this -> Session -> setFlash("Se ha borrado el correo");
			$this -> redirect(array('action' => 'listaCorreo', $proyectoId));
		} else {
			$this -> Session -> setFlash("No se pudo borrar el correo");
			$this -> redirect(array('action' => 'listaCorreo', $proyectoId));
		}

	}

	public function tieneAlarmaCliente($proyecto_id) {
		$alarmas = $this -> Proyecto -> Alarma -> find("count", array("conditions" => array("llave_foranea" => $proyecto_id, "para_empresa" => false)));
		if ($alarmas)
			return true;

		return false;
	}

	public function view($id = null) {
		$this -> layout = "cliente";
		if (!$id) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'proyecto'));
			$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $this -> Proyecto -> read(null, $id);
		$comentariosPublicos = $this -> Proyecto -> ComentarioPublico -> find("all", array("conditions" => array("ComentarioPublico.proyecto_id" => $proyecto["Proyecto"]["id"])));

		$this -> set(compact('proyecto', 'comentariosPrivados', 'comentariosPublicos'));
	}

	public function solicitudAdicional($proyectoId = null) {
		$this -> layout = "ajax";
		$proyectoId = $proyectoId;
		if (!empty($this -> data)) {
			$proyectoId = $this -> data["SolicitudProyecto"]["proyecto_id"];
			if ($this -> Proyecto -> SolicitudProyecto -> save($this -> data)) {

				$this -> Session -> setFlash(sprintf(__('Su solicitud ha sido registrada, pronto uno de nuestros Ingenieros se contactará con usted.', true), 'proyecto'));
			} else {
				$this -> Session -> setFlash(sprintf(__('No se pudo procesar su solicitud por favor intente de nuevo', true), 'proyecto'));

			}
		}
		$this -> set(compact("proyectoId"));

	}

	public function admin_view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'proyecto'));
			$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $this -> Proyecto -> read(null, $id);
		$comentariosPrivados = $this -> Proyecto -> ComentarioPrivado -> find("all", array("conditions" => array("ComentarioPrivado.proyecto_id" => $proyecto["Proyecto"]["id"])));
		$comentariosPublicos = $this -> Proyecto -> ComentarioPublico -> find("all", array("conditions" => array("ComentarioPublico.proyecto_id" => $proyecto["Proyecto"]["id"])));

		$this -> set(compact('proyecto', 'comentariosPrivados', 'comentariosPublicos'));
	}

	public function admin_add($id = null) {
		$clienteId = $id;
		if (!empty($this -> data)) {

			$this -> Proyecto -> create();
			if ($this -> Proyecto -> save($this -> data)) {
				$usuarios = $this -> requestAction("/usuarios/getOmega");
				$correo["Email"]["proyecto_id"] = $this -> Proyecto -> id;
				$correo["Email"]["email"] = $this -> data["Proyecto"]["encargado"];
				$correo["Email"]["nombre"] = $usuarios[$this -> data["Proyecto"]["encargado"]];
				$this -> Proyecto -> Email -> create();
				$this -> Proyecto -> Email -> save($correo);
				$this -> Proyecto -> Email -> id = 0;
				$correo = null;
				$correo["Email"]["proyecto_id"] = $this -> Proyecto -> id;
				$correo["Email"]["email"] = $this -> data["Proyecto"]["supervisor"];
				$correo["Email"]["nombre"] = $usuarios[$this -> data["Proyecto"]["supervisor"]];
				$this -> Proyecto -> Email -> create();
				$this -> Proyecto -> Email -> save($correo);
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'proyecto'));
				$this -> redirect(array('action' => 'view', "controller" => "clientes", $this -> data["Proyecto"]["cliente_id"], "proyectos"));
			} else {
				$clienteId = $this -> data["Proyecto"]["cliente_id"];
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'proyecto'));
			}
		}
		$clientes = $this -> Proyecto -> Cliente -> find('list');
		$this -> set(compact('clientes', 'clienteId'));
	}

	public function admin_add2($id = null) {
		$this -> layout = "ajax";
		$clienteId = $id;
		if (!empty($this -> data)) {
			$this -> Proyecto -> create();
			if ($this -> Proyecto -> save($this -> data)) {
				$this -> Session -> setFlash(sprintf(__('Se ha creado la nueva cotizacion, recuerde subir los archivos necesarios', true), 'proyecto'));
				//$this->redirect(array('action' => 'view',"controller"=>"clientes",$this->data["Proyecto"]["cliente_id"]));
			} else {
				$clienteId = $this -> data["Proyecto"]["cliente_id"];
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'proyecto'));
			}
		}
		$clientes = $this -> Proyecto -> Cliente -> find('list');
		$this -> set(compact('clientes', 'clienteId'));
	}

	public function admin_edit($id = null) {
		$this -> layout = "ajax";
		if (!$id && empty($this -> data)) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'proyecto'));
			$this -> redirect(array('action' => 'index'));
		}
		$proyecto = $id;
		if (!empty($this -> data)) {
			if ($this -> Proyecto -> save($this -> data)) {
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'proyecto'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$proyecto = $this -> data["Proyecto"]["id"];
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'proyecto'));
			}
		}
		if (empty($this -> data)) {
			$this -> data = $this -> Proyecto -> read(null, $id);
		}
		$clientes = $this -> Proyecto -> Cliente -> find('list');
		$this -> set(compact('clientes'));
		$this -> set("proyecto", $id);
	}

	public function delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(sprintf(__('Invalid id for %s', true), 'proyecto'));
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Proyecto -> delete($id)) {
			$this -> Session -> setFlash(sprintf(__('%s deleted', true), 'Proyecto'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(sprintf(__('%s was not deleted', true), 'Proyecto'));
		$this -> redirect(array('action' => 'index'));
	}

	public function enviarCorreo($proyectoId, $mail_body) {

		$proyecto = $this -> Proyecto -> read(null, $proyectoId);
		$this -> Proyecto -> Cliente -> ClientesUsuario -> bindModel(array("belongsTo" => array("Usuario")));
		$usuarios = $this -> Proyecto -> Cliente -> ClientesUsuario -> find("all", array("conditions" => array("cliente_id" => $proyecto["Cliente"]["id"])));
		$emailUsuario = "";
		foreach ($usuarios as $usuario) {
			if ($usuario["Usuario"]["role"] == "clienteProyecto")
				$emailUsuario = $usuario["Usuario"]["email"];
		}
		$correos = $this -> Proyecto -> Email -> find("all", array("conditions" => array("Email.proyecto_id" => $proyectoId)));
		$Name = "OMEGA INGENIEROS";
		//senders name

		/*$email = "no-responder@omegaingenieros.com"; //senders e-mail adress
		 $subject = "Nueva actividad en el Proyecto: ".$proyecto["Proyecto"]["nombre"]; //subject
		 $header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
		 mail($proyecto["Cliente"]["email"], $subject, $mail_body, $header);
		 mail($emailUsuario, $subject, $mail_body, $header);*/
		$subject = "Nueva actividad en el Proyecto: " . $proyecto["Proyecto"]["nombre"];
		//subject
		$this -> sendbySMTP("", $emailUsuario, $subject, $mail_body);
		$this -> sendbySMTP($proyecto["Cliente"]["nombre"], $proyecto["Cliente"]["email"], $subject, $mail_body);
		foreach ($correos as $correo) {
			$this -> sendbySMTP($correo["Email"]["nombre"], $correo["Email"]["email"], $subject, $mail_body);
		}
		return true;
	}

	public function sendbySMTP($nombrePara, $correoPara, $subject, $body) {
		$this -> Email -> smtpOptions = array('port' => '465', 'timeout' => '30', 'auth' => true, 'host' => 'ssl://smtp.gmail.com', 'username' => 'omegaingsoporte@gmail.com', 'password' => 'omega123', );

		$this -> Email -> delivery = 'smtp';
		$this -> Email -> from = 'Aplicación Web Omega Ingenieros <no-responder@omegaingenieros.com>';
		$this -> Email -> to = $nombrePara . '<' . $correoPara . '>';
		$this -> Email -> subject = $subject;
		$this -> Email -> send($body);
		$this -> Email -> reset();
	}

	public function AJAX_eliminarAlarma() {
		$alarmaId = $this -> params["form"]["alarmaId"];
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

	public function admin_verCotizacion($id) {
		$proyecto = $this -> Proyecto -> read("cotizacion", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cotizacion"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> view = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);

	}

	public function verCotizacion($id) {
		$proyecto = $this -> Proyecto -> read("cotizacion", $id);
		$partes = explode("/", $proyecto["Proyecto"]["cotizacion"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> view = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);

	}

	public function admin_subirCotizacion() {
		$this -> layout = "ajax";
	}

	public function AJAX_subirCotizacion() {

		$proyectoId = $this -> params["form"]["id"];
		$cotizacionPath = $this -> params["form"]["path"];
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
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

	public function admin_comentarios($id) {
		$this -> layout = "ajax";
		$this -> Proyecto -> recursive = -1;
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
	}

	public function confirmarAprobacion() {
		$this -> layout = "ajax";
		$id = $this -> data["Proyecto"]["id"];
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> Proyecto -> set("estado_proyecto_id", 2);
		$this -> Proyecto -> set("comentarios", $this -> data["Proyecto"]["comentarios"]);
		$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en perfeccionamiento", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$mail_body = "Usted ha apropado la cotizaciòn del proyecto: " . $proyecto["Proyecto"]["nombre"];
		$this -> enviarCorreo($proyecto["Proyecto"]["id"], $mail_body);
		$this -> Session -> setFlash(sprintf(__('Gracias por permitirnos hacer parte de su equipo de trabajo.', true), 'Proyecto'));

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
	}

	public function confirmarRechazo() {
		$this -> layout = "ajax";
		$id = $this -> data["Proyecto"]["id"];
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> Proyecto -> set("estado_proyecto_id", 9);
		$this -> Proyecto -> set("comentarios", $this -> data["Proyecto"]["comentarios"]);
		$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en rechazado", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$mail_body = "Se ha rechazado la cotización del proyecto: " . $proyecto["Proyecto"]["nombre"];
		$this -> enviarCorreo($proyecto["Proyecto"]["id"], $mail_body);
		$this -> Session -> setFlash(sprintf(__('Esperamos hacer parte de su equipo de trabajo en futuros proyectos', true), 'Proyecto'));

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
		$id = $this -> data["Proyecto"]["id"];
		$proyecto = $this -> Proyecto -> read(null, $id);
		$this -> Proyecto -> set("estado_proyecto_id", 8);
		$this -> Proyecto -> set("comentarios", $this -> data["Proyecto"]["comentarios"]);
		$this -> Proyecto -> save();
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "en espera de aprobación por el cliente");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto en espera de aprobación");
		$this -> Proyecto -> eliminarAlarmaProyecto($id, "proyecto nuevo");
		$this -> Proyecto -> crearAlarmaProyecto($id, "proyecto en perfeccionamiento", false);
		//$this->Proyecto->crearAlarmaProyecto($id,"debe ingresar el centro de costo",false);
		$mail_body = "Se ha anulado la cotización del proyecto: " . $proyecto["Proyecto"]["nombre"];
		$this -> enviarCorreo($proyecto["Proyecto"]["id"], $mail_body);
		$this -> Session -> setFlash(sprintf(__('Se ha anulado la cotizazción', true), 'Proyecto'));

	}

	public function admin_ingresarCc($id = null) {
		$this -> layout = "ajax";
		if (!empty($this -> data)) {
			$proyectoId = $this -> data["Proyecto"]["id"];
			$proyecto = $this -> Proyecto -> read(null, $proyectoId);
			$this -> Proyecto -> set("centro_de_costo", $this -> data["Proyecto"]["centro_de_costo"]);
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
		if (empty($this -> data)) {
			$this -> data = $this -> Proyecto -> read(null, $id);
		}
		$this -> set("proyecto", $id);
	}

	public function AJAX_cambiarEstado() {
		$proyectoId = $this -> params["form"]["id"];
		$estadoProyectoId = $this -> params["form"]["estado_proyecto_id"];
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

	public function solicitarProyecto($clienteId = null) {
		$this -> layout = "ajax";
		if (!empty($this -> data)) {
			$clienteId = $this -> data["Proyecto"]["cliente_id"];
			$solicitud["Solicitud"]["cliente_id"] = $clienteId;
			$solicitud["Solicitud"]["tipo_solicitud"] = "proyecto";
			$solicitud["Solicitud"]["texto_solicitud"] = $this -> data["Proyecto"]["texto_solicitud"];

			if ($this -> Proyecto -> Cliente -> Solicitud -> save($solicitud)) {
				$this -> Proyecto -> Cliente -> recursive = -1;
				$cliente = $this -> Proyecto -> Cliente -> read(null, $clienteId);
				$cliente["Cliente"]["tiene_solicitud"] = true;
				$this -> Proyecto -> Cliente -> save($cliente);
				$Name = $cliente["Cliente"]["nombre"];
				//senders name
				$email = $cliente["Cliente"]["email"];
				//senders e-mail adress
				$recipient = "ricardopandales@gmail.com";
				//direccion que se va a utilizar por smtp
				$subject = "Solicitud de nuevo proyecto ";
				//subject

				$header = "From: " . $Name . " <" . $email . ">\r\n";
				//optional headerfields
				//mail($recipient, $subject, $this->data["Proyecto"]["texto_solicitud"], $header);
				$this -> sendbySMTP("", $cliente["Cliente"]["email"], $subject, $this -> data["Proyecto"]["texto_solicitud"]);
				$this -> sendToOmegaProyecto($Name, $this -> data);
				$this -> Session -> setFlash(sprintf(__('Su solicitud ha sido enviada con exito, Pronto uno de nuestros Ingenieros se contactará con usted.', true), 'Proyecto'));

			} else {
				$this -> Session -> setFlash(sprintf(__('No se pudo enviar su solicitud por favor intente de nuevo', true), 'Proyecto'));

			}

		}
		$this -> set(compact("clienteId"));
	}

	public function sendToOmegaProyecto($clienteName, $data) {/*
		 $this->sendbySMTP($clienteName,"gacruz@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"lcastano@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"wgrajales@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 $this->sendbySMTP($clienteName,"servicios@omegaingenieros.com",$subject,$data["Proyecto"]["texto_solicitud"]);
		 */
		return true;
	}

	public function AJAX_guardarDesarrollo() {
		$proyectoId = $this -> params["form"]["id"];
		$texto = $this -> params["form"]["texto"];
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
		$this -> view = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => false, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);

	}

	public function AJAX_subirFicha() {

		$proyectoId = $this -> params["form"]["id"];
		$fichaPath = $this -> params["form"]["path"];
		$this -> Proyecto -> recursive = -1;
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
		$this -> view = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => false, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);

	}

	public function quitarPulicacionParaOmega() {

		$proyectoId = $this -> params["form"]["id"];

		$this -> Proyecto -> recursive = -1;
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

		$proyectoId = $this -> params["form"]["id"];

		$this -> Proyecto -> recursive = -1;
		$proyecto = $this -> Proyecto -> read(null, $proyectoId);

		$proyecto["Proyecto"]["publicacion_para_empresa"] = false;
		if ($this -> Proyecto -> save($proyecto)) {
			debug($proyecto);
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}
	
}
