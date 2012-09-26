<?php
App::uses('AppController', 'Controller');
/**
 * Observacions Controller
 *
 * @property Observacion $Observacion
 */
class ObservacionesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this -> Auth -> allow('emailResponseHandler');
	}

	/**
	 * Método para manejar respuestas de los correos para
	 * las respuestas a observaciones.
	 */
	public function emailResponseHandler() {
		$data = json_decode($_POST['mandrill_events'][0], true);
		if($data['event'] == 'inbound') {
			$email_text = $data['msg']['text'];
			$from_email = $data['msg']['from_email'];
			$observacion = array(
					'Observacion' => array(
							'modelo' => 'PruebasEnvio',
							'llave_foranea' => 0,
							'es_publico' => 1,
							'texto' => $email_text
					)
			);
			$this -> Observacion -> Usuario -> contain();
			if($usuario = $this -> Observacion -> Usuario -> findByCorreo($from_email)) {
				$observacion['Observacion']['usuario_id'] => $usuario['Usuario']['id']; 
			}
			$this -> Observacion -> create();
			$this -> Observacion -> save($observacion);
		}
		$this -> autoRender = false;
		exit(0);
	}

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

				$this -> Observacion -> Usuario -> contain();
				$usuario = $this -> Observacion -> Usuario -> read(null, $comentario["Observacion"]["usuario_id"]);
				$this -> loadModel('Contrato');
				$contrato = $this -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
				$this -> enviarCorreoObservacionesPublicas($this -> Observacion -> id, $contrato["Contrato"]["id"], "El Usuario: " . $usuario["Usuario"]["nombre_de_usuario"] . " ha escrito el siguiente comentario: \n" . $comentario["Observacion"]["texto"]);
				
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
				$this -> loadModel('Contrato');
				$contrato = $this -> Contrato -> read(null, $contratoEquipo["ContratosEquipo"]["contrato_id"]);
				$this -> enviarCorreoObservacionesPublicas($this -> Observacion -> id, $contrato["Contrato"]["id"], "El Usuario: " . $usuario["Usuario"]["nombre_de_usuario"] . " ha escrito el siguiente comentario: \n" . $comentario["Observacion"]["texto"]);
				
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

	function enviarCorreoObservacionesPublicas($observacionId, $contratoId, $mail_body) {
		$this -> loadModel('Contrato');
		$this -> Contrato -> contain('Correo', 'Empresa');
		$contrato = $this -> Contrato -> read(null, $contratoId);
		$observacion = $this -> Observacion -> read(null, $observacionId);
		$modelo = 'Contrato';
		$correos = $this -> Contrato -> Correo -> find("all", array("conditions" => array("Correo.modelo" => $modelo, "Correo.llave_foranea" => $contratoId)));
		// Asunto del mensaje
		$subject = "Nueva actividad en el contrato: " . $contrato["Contrato"]["nombre"];
		// Cabeceras
		$datos = array(
			'observacion_id' => $observacionId,
			'usuario_id' => $observacion['Observacion']['usuario_id'],
			'modelo' => $modelo,
			'llave_foranea' => $contratoId,
		);
		$datos = json_encode($datos);
		$extra_content =
		'<p>
		<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< RESPONDER SOBRE ESTA LINEA >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><br />
		<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		</p>
		<br />
		<div style="color:white; background-color: white;">' . $datos . '</div>
		<br />';
		$mail_body .= $extra_content; 
		// Enviar al contacto principal
		$this -> sendbySMTP($contrato["Empresa"]["nombre"], $contrato["Empresa"]["correo"], $subject, $mail_body);
		if (!empty($correos)) {
			foreach ($correos as $correo) {
				$recipient = $correo["Correo"]["correo"];
				// Enviar a otros contactos registrados
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