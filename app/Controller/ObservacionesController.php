<?php
App::uses('AppController', 'Controller');
/**
 * Observacions Controller
 *
 * @property Observacion $Observacion
 */
class ObservacionesController extends AppController {

	function admin_AJAX_addObservacionPublica() {
		$this -> Observacion -> bindModel(array('belongsTo' => array('Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''), 'ContratosEquipo' => array('className' => 'ContratosEquipo', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'ContratosEquipo'), 'fields' => '', 'order' => ''))));
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["contratos_equipo_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'ContratosEquipo';
		$comentario["Observacion"]["es_publico"] = 1;
		if ($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this -> Observacion -> save($comentario)) {
				$contratoEquipo = $this -> Observacion -> ContratosEquipo -> read(null, $comentario["Observacion"]["llave_foranea"]);
				$this -> Observacion -> ContratosEquipo -> Contrato -> contain();
				$contrato = $this -> Observacion -> ContratosEquipo -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
				$servicios_usuario = $this -> requestAction('/usuarios/getServiciosUsuario/' . $this -> Auth -> user('id'));
				if (in_array(1, $servicios_usuario)) {
					if (!$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"])
						$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"] = true;
					if (!$contrato["Contrato"]["tiene_publicacion_empresa"]) {
						$this -> Observacion -> ContratosEquipo -> Contrato -> set("tiene_publicacion_empresa", true);
						$this -> Observacion -> ContratosEquipo -> Contrato -> save();
					}
				}
				if ($this -> Auth -> user('rol_id') <= 2) {
					if (!$contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"])
						$contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"] = true;
					if (!$contrato["Contrato"]["tiene_publicacion_omega"]) {
						$this -> Observacion -> ContratosEquipo -> Contrato -> set("tiene_publicacion_omega", true);
						$this -> Observacion -> ContratosEquipo -> Contrato -> save();
					}
				}
				$this -> Observacion -> ContratosEquipo -> save($contratoEquipo);
				echo "OK";
			} else {
				echo "No se pudo agregar su comentario, Por favor Intente de nuevo";
			}
		} else {
			echo "Debe escribir un comentario";
		}
		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

	function AJAX_addObservacionPublica() {
		$this -> Observacion -> bindModel(array('belongsTo' => array('Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''), 'ContratosEquipo' => array('className' => 'ContratosEquipo', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'ContratosEquipo'), 'fields' => '', 'order' => ''))));
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["contratos_equipo_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'ContratosEquipo';
		$comentario["Observacion"]["es_publico"] = 1;
		if ($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this -> Observacion -> save($comentario)) {
				$contratoEquipo = $this -> Observacion -> ContratosEquipo -> read(null, $comentario["Observacion"]["llave_foranea"]);
				$this -> Observacion -> ContratosEquipo -> Contrato -> contain();
				$contrato = $this -> Observacion -> ContratosEquipo -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
				$servicios_usuario = $this -> requestAction('/usuarios/getServiciosUsuario/' . $this -> Auth -> user('id'));
				if (in_array(1, $servicios_usuario)) {
					if (!$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"])
						$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"] = true;
					if (!$contrato["Contrato"]["tiene_publicacion_empresa"]) {
						$this -> Observacion -> ContratosEquipo -> Contrato -> set("tiene_publicacion_empresa", true);
						$this -> Observacion -> ContratosEquipo -> Contrato -> save();
					}
				}
				if ($this -> Auth -> user('rol_id') <= 2) {
					if (!$contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"])
						$contratoEquipo["ContratosEquipo"]["tiene_publicacion_omega"] = true;
					if (!$contrato["Contrato"]["tiene_publicacion_omega"]) {
						$this -> Observacion -> ContratosEquipo -> Contrato -> set("tiene_publicacion_omega", true);
						$this -> Observacion -> ContratosEquipo -> Contrato -> save();
					}
				}

				$this -> Observacion -> ContratosEquipo -> save($contratoEquipo);

				$this -> Observacion -> Usuario -> contain();
				$usuario = $this -> Observacion -> Usuario -> read(null, $comentario["Observacion"]["usuario_id"]);

				$contrato = $this -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
				$this -> enviarCorreoObservacionesPublicas($contrato["Contrato"]["id"], "El Usuario: " . $usuario["Usuario"]["nombre_de_usuario"] . " ha escrito el siguiente comentario: \n" . $comentario["Observacion"]["texto"]);
				echo "OK";
			} else {
				echo "No se pudo agregar su comentario, Por favor Intente de nuevo";
			}
		} else {
			echo "Debe escribir un comentario";
		}
		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

	function enviarCorreoObservacionesPublicas($contratoId, $mail_body) {
		$this -> loadModel('Contrato');
		$this -> Contrato -> contain('Correo');
		$contrato = $this -> Contrato -> read(null, $contratoId);
		$correos = $this -> Contrato -> Correo -> find("all", array("conditions" => array("Correo.modelo" => "Contrato", "Correo.llave_foranea" => $contratoId)));
		$Name = "OMEGA INGENIEROS";
		//senders name
		$email = "no-responder@omegaingenieros.com";
		//senders e-mail adress
		$subject = "Nueva actividad en el contrato: " . $contrato["Contrato"]["nombre"];
		//subject
		$header = "From: " . $Name . " <" . $email . ">\r\n";
		//optional headerfields
		//	mail($contrato["Cliente"]["email"], $subject, $mail_body, $header);
		$this -> sendbySMTP($contrato["Empresa"]["nombre"], $contrato["Empresa"]["correo"], $subject, $mail_body);
		if (!empty($correos)) {
			foreach ($correos as $correo) {
				$recipient = $correo["Correo"]["correo"];
				$this -> sendbySMTP($correo["Correo"]["nombre"], $correo["Correo"]["correo"], $subject, $mail_body);
			}
		}
		return true;
	}

	function admin_AJAX_addObservacionPrivada() {
		$this -> Observacion -> bindModel(array('belongsTo' => array('Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''), 'ContratosEquipo' => array('className' => 'ContratosEquipo', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'ContratosEquipo'), 'fields' => '', 'order' => ''))));
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["contratos_equipo_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'ContratosEquipo';
		$comentario["Observacion"]["es_publico"] = 0;
		if ($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this -> Observacion -> save($comentario)) {
				$contratoEquipo = $this -> Observacion -> ContratosEquipo -> read(null, $comentario["Observacion"]["llave_foranea"]);
				if (!$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"])
					$contratoEquipo["ContratosEquipo"]["tiene_publicacion_empresa"] = true;
				//Toco poner tiene publicacion cliente en verdadero porque os elementos de alertas asumen que las publicaciones del cliente son las que activan las alarmas para omega
				$this -> Observacion -> ContratosEquipo -> save($contratoEquipo);

				echo "OK";
			} else {
				echo "No se pudo agregar su comentario, Por favor Intente de nuevo";
			}
		} else {
			echo "Debe escribir un comentario";
		}
		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

}
