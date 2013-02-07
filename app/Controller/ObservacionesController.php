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
	
	public function pruebas() {
		$this -> autoRender = false;
		$data = array(
				0 => array(
						'event' => 'inbound',
						'ts' => 1348662138,
						'msg' => array(
								'text' => 'asdlfkjasldñfkjaslñknlñkjñasdfasldfkj!!!lkjfsnfñafhng!!!

											2012/9/26 Aplicación Web Omega Ingenieros <notificaciones@omega.bloomweb.co>:
											> El Usuario: jucedogi ha escrito el siguiente comentario: tests envío datos
											> correo 7
											>
											> <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< RESPONDER SOBRE ESTA LINEA
											>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
											> <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
											>
											>
											> {"observacion_id":"15","usuario_id":"1","modelo":"Contrato","llave_foranea":"2"}
											>',
								'from_email' => 'juliodominguez@gmail.com',
								'from_name' => 'Julio César Domínguez Giraldo',
								'to' => array(
										0 => array(
												0 => 'notificaciones@omega.bloomweb.co',
												1 => 'Aplicación Web Omega Ingenieros'
										)
								),
								'email' => 'notificaciones@omega.bloomweb.co',
								'subject' => 'Re: Nueva actividad en el contrato: Contrato Preventivo Prueba 1',
								'tags' => array(),
								'sender' => null
						)
				)
		);
		//debug($data);
		$email_text = $data[0]['msg']['text'];
		debug($email_text);
		$info = json_decode(substr($email_text, strpos($email_text, '{"observacion_id"'), strrpos($email_text, '"}') - strpos($email_text, '{"observacion_id"') + 2), true);
		
		debug(trim(substr($email_text, 0, (strpos($email_text, 'Aplicación Web Omega Ingenieros <notificaciones@omega.bloomweb.co>') - 11))));
		
		$this -> Observacion -> Usuario -> contain('Observacion');
		$usuario = $this -> Observacion -> Usuario -> findByCorreo($data[0]['msg']['from_email']);
		debug($data[0]['msg']['from_email']);
		debug($usuario);
		$texto = trim(substr($email_text, 0, (strpos($email_text, 'Aplicación Web Omega Ingenieros <notificaciones@omega.bloomweb.co>') - 11)));
		$texto = 'Se ha escrito desde el correo ' . $data[0]['msg']['from_email'] . ': ' . $texto;
		debug($texto);
	}
	
	public function correoACarlos($text) {
		$this -> sendBySMTP('Carlos Sanchez', 'csanchez@omegaingenieros.com', 'SICLOM :: Nuevo comentario de cliente', $text);
	}
	
	/**
	 * Encontrar el usuario que envía el correo según su correo o el ID de usuario
	 * @param string $email
	 * @param int $user_id
	 * @param string $modelo
	 * @param int $llave_foranea
	 * @return string Comentarios del usuario sobre el modelo y llave correspondiente
	 */
	public function getRelatedComments($email = null, $user_id = null, $modelo = null, $llave_foranea = null) {
		/******/
		$user_id = 3;
		$modelo = 'ContratosEquipo';
		$llave_foranea = 2;
		/******/
		$this -> autoRender = false;
		$this -> Observacion -> contain('Usuario.nombre', 'Usuario.apellido', 'Usuario.correo');
		$this -> Observacion -> Usuario -> contain('Empresa', 'Rol');
		$user = null;
		if(!$user_id && $email) {
			$user = $this -> Observacion -> Usuario -> findByCorreo($email);	
		} elseif(!$email && $user_id) {
			$user = $this -> Observacion -> Usuario -> findById($user_id);
		} else {
			return false;
		}
		if(($user['Usuario']['rol_id'] == 3) && $modelo && $llave_foranea) {
			$tmp_comments = $this -> Observacion -> find(
				'all',
				array(
					'conditions' => array(
						'Observacion.modelo' => $modelo,
						'Observacion.llave_foranea' => $llave_foranea
					),
					'limit' => 3,
					'order' => array(
						'Observacion.created' => 'DESC'
					)
				)
			);
			$this -> loadModel($modelo);
			$this -> loadModel('Empresa');
			$Modelo = $this -> {$modelo} -> findById($llave_foranea);
			$this -> Empresa -> contain();
			$Empresa = null;
			$Acerca = null;
			if(isset($Modelo['Contrato'])) {
				$Empresa = $this -> Empresa -> findById($Modelo['Contrato']['empresa_id']);
				$Acerca = ' en cuanto al contrato ' . $Modelo['Contrato']['nombre'];
			} elseif(isset($Modelo['Proyecto'])) {
				$Empresa = $this -> Empresa -> findById($Modelo['Proyecto']['empresa_id']);
				$Acerca = ' en cuanto al servicio ' . $Modelo['Proyecto']['nombre'];
			}
			$comments = '
			La empresa ' . $Empresa['Empresa']['nombre'] . $Acerca . ' se trata ha recibido un comentario hecho por un cliente. ' . '
			';
			foreach($tmp_comments as $key => $tmp_comment) {
				$comments .= '
				' . $tmp_comment['Usuario']['nombre'] . ' ' . $tmp_comment['Usuario']['apellido'] . ' (' . $tmp_comment['Usuario']['correo'] . ' - ' . $tmp_comment['Observacion']['created'] . ') :: ' . $tmp_comment['Observacion']['texto'] . '
				';
			}
			return $comments;
		} else {
			return false;
		}
	}

	/**
	 * Método para manejar respuestas de los correos para
	 * las respuestas a observaciones.
	 */
	public function emailResponseHandler() {
		$data = json_decode($_POST['mandrill_events'], true);
		
		if(isset($data[0]['event']) && !empty($data[0]['event']) && $data[0]['event'] == 'inbound') {
			$email_text = $data[0]['msg']['text'];
			$info = json_decode(substr($email_text, strpos($email_text, '{"observacion_id"'), strrpos($email_text, '"}') - strpos($email_text, '{"observacion_id"') + 2), true);
			$from_email = $data[0]['msg']['from_email'];
			$texto = trim(substr($email_text, 0, (strpos($email_text, 'Aplicación Web Omega Ingenieros <notificaciones@omega.bloomweb.co>') - 11)));
			$texto = 'Se ha escrito desde el correo ' . $from_email . ': ' . $texto;
			$observacion = array(
				'Observacion' => array(
						'modelo' => $info['modelo'],
						'llave_foranea' => $info['llave_foranea'],
						'es_publico' => 1,
						'texto' => $texto
				)
			);
			$this -> Observacion -> create();
			if($this -> Observacion -> save($observacion)) {
				$mensaje = $this -> getRelatedComments($from_email, null, $info['modelo'], $info['llave_foranea']);
				$this -> correoACarlos($mensaje);
			}
		} else {
			$this -> Observacion -> create();
			$this -> Observacion -> save(
					array(
							'Observacion' => array(
									'modelo' => 'PruebasEnvio',
									'llave_foranea' => 0,
									'es_publico' => 0,
									'texto' => print_r($data, true)
							)
					)
			);
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
				$this -> enviarCorreoObservacionesPublicas($this -> Observacion -> id, $contrato["Contrato"]["id"], $comentario["Observacion"]["llave_foranea"], "El Usuario: " . $usuario["Usuario"]["nombre_de_usuario"] . " ha escrito el siguiente comentario: \n" . $comentario["Observacion"]["texto"]);
				
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
				$this -> enviarCorreoObservacionesPublicas($this -> Observacion -> id, $contrato["Contrato"]["id"], $comentario["Observacion"]["llave_foranea"], "El Usuario: " . $usuario["Usuario"]["nombre_de_usuario"] . " ha escrito el siguiente comentario: \n" . $comentario["Observacion"]["texto"]);
				$mensaje = $this -> getRelatedComments(null, $comentario["Observacion"]["usuario_id"], $comentario["Observacion"]["modelo"], $comentario["Observacion"]["llave_foranea"]);
				$this -> correoACarlos($mensaje);
				
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

	function enviarCorreoObservacionesPublicas($observacionId, $contratoId, $contratoEquipoId, $mail_body) {
		$this -> loadModel('Contrato');
		$this -> loadModel('Usuario');
		$this -> Contrato -> contain('Correo', 'Empresa');
		$contrato = $this -> Contrato -> read(null, $contratoId);
		$observacion = $this -> Observacion -> read(null, $observacionId);
		$modelo = 'ContratosEquipo';
		$correos = $this -> Contrato -> Correo -> find("all", array("conditions" => array("Correo.modelo" => $modelo, "Correo.llave_foranea" => $contratoId)));
		// Asunto del mensaje
		$subject = "Nueva actividad en el contrato: " . $contrato["Contrato"]["nombre"];
		// Cabeceras
		$datos = array(
			'observacion_id' => $observacionId,
			'usuario_id' => $observacion['Observacion']['usuario_id'],
			'modelo' => $modelo,
			'llave_foranea' => $contratoEquipoId,
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
		$empresaId = $contrato['Contrato']['empresa_id'];
		$usuarios = $this -> requestAction('/usuarios/getUsuariosServicio/1');
		$usuarios = $this -> Usuario -> find('all', array('conditions' => array('Usuario.id' => $usuarios, 'Usuario.id <>' => $observacion['Observacion']['usuario_id'], 'Usuario.empresa_id' => $empresaId)));
		foreach ($usuarios as $key => $usuario) {
			$this -> sendbySMTP($usuario["Usuario"]["nombre_de_usuario"], $usuario["Usuario"]["correo"], $subject, $mail_body);
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
	
	/* -----------------------------------------------------------------------------------------------------------------------------------*/
	
	public function enviarCorreoComentariosPublicos($observacionId,$proyectoId,$servicioId,$mail_body) {
		$this -> loadModel('Proyecto');
		$this -> loadModel('Usuario');
		$this -> Proyecto -> contain('Correo', 'Empresa');
		$proyecto = $this -> Proyecto -> read(null,$proyectoId);
		$modelo = 'Proyecto';
		$correos = $this -> Proyecto -> Correo -> find("all", array("conditions" => array("Correo.modelo" => $modelo, "Correo.llave_foranea" => $proyectoId)));
		$observacion = $this -> Observacion -> read(null, $observacionId);
		$Name = "OMEGA INGENIEROS"; //senders name
		$email = "no-responder@omegaingenieros.com"; //senders e-mail adress
		$subject = "Nueva actividad en el Proyecto: ".$proyecto["Proyecto"]["nombre"]; //subject
		$datos = array(
			'observacion_id' => $observacionId,
			'usuario_id' => $observacion['Observacion']['usuario_id'],
			'modelo' => $modelo,
			'llave_foranea' => $proyectoId,
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
		$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields	
		//	mail($contrato["Cliente"]["email"], $subject, $mail_body, $header);
		$this -> sendbySMTP($proyecto["Empresa"]["nombre"],$proyecto["Empresa"]["correo"],$subject,$mail_body);
		
		if(!empty($correos)){
			foreach($correos as $correo){
				$recipient = $correo["Correo"]["correo"]; //recipient
				//mail($recipient, $subject, $mail_body, $header);
				$this->sendbySMTP($correo["Correo"]["nombre"],$correo["Correo"]["correo"],$subject,$mail_body);
			}
		}
		
		$empresaId = $proyecto['Proyecto']['empresa_id'];
		$usuarios = $this -> requestAction('/usuarios/getUsuariosServicio/' . $servicioId);
		$usuarios = $this -> Usuario -> find('all', array('conditions' => array('Usuario.id' => $usuarios, 'Usuario.id <>' => $observacion['Observacion']['usuario_id'], 'Usuario.empresa_id' => $empresaId)));
		foreach ($usuarios as $key => $usuario) {
			$this -> sendbySMTP($usuario["Usuario"]["nombre_de_usuario"], $usuario["Usuario"]["correo"], $subject, $mail_body);
		}
		
		return true;
	}
	
	function admin_AJAX_addComentarioPrivado() {
		$this -> Observacion -> bindModel(
			array(
				'belongsTo' => array(
					'Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''),
					'Proyecto' => array('className' => 'Proyecto', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'Proyecto'), 'fields' => '', 'order' => '')
				)
			)
		);
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["proyecto_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'Proyecto';
		$comentario["Observacion"]["es_publico"] = 0;
		if($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this->Observacion->save($comentario)) {
				$proyecto = $this -> Observacion -> Proyecto -> read(null,$comentario["Observacion"]["llave_foranea"]);
				if($this -> Auth -> user('rol_id') < 3){
					if(!$proyecto["Proyecto"]["publicacion_para_empresa"]) $proyecto["Proyecto"]["publicacion_para_empresa"]=true;
				}	
				$this->Observacion->Proyecto->save($proyecto);
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
	
	function admin_AJAX_addComentarioPublico() {
		$this -> Observacion -> bindModel(
			array(
				'belongsTo' => array(
					'Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''),
					'Proyecto' => array('className' => 'Proyecto', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'Proyecto'), 'fields' => '', 'order' => '')
				)
			)
		);
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["proyecto_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'Proyecto';
		$comentario["Observacion"]["es_publico"] = 1;
		if($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this->Observacion->save($comentario)) {
				$proyecto = $this -> Observacion -> Proyecto -> read(null,$comentario["Observacion"]["llave_foranea"]);
				if($this -> Auth -> user('rol_id') < 3){
					if(!$proyecto["Proyecto"]["publicacion_para_empresa"]) $proyecto["Proyecto"]["publicacion_para_empresa"]=true;
				}	
				$this->Observacion->Proyecto->save($proyecto);				
				echo "OK";	
			} else {
				echo "No se pudo agregar su comentario, Por favor Intente de nuevo";
			}
		} else {
			echo "Debe escribir un comentario";
		}
		configure::Write("debug",0);
		$this->autoRender=false;
		exit(0);
	}
	
	public function AJAX_addComentarioPublico() {
		$this -> Observacion -> bindModel(
			array(
				'belongsTo' => array(
					'Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id', 'conditions' => '', 'fields' => '', 'order' => ''),
					'Proyecto' => array('className' => 'Proyecto', 'foreignKey' => 'llave_foranea', 'conditions' => array('modelo' => 'Proyecto'), 'fields' => '', 'order' => '')
				)
			)
		);
		$comentario["Observacion"]["usuario_id"] = $this -> data['Observacion']["usuario_id"];
		$comentario["Observacion"]["llave_foranea"] = $this -> data['Observacion']["proyecto_id"];
		$comentario["Observacion"]["texto"] = $this -> data['Observacion']["observacion"];
		$comentario["Observacion"]["modelo"] = 'Proyecto';
		$comentario["Observacion"]["es_publico"] = 1;
		if($comentario["Observacion"]["texto"]) {
			$this -> Observacion -> create();
			if ($this->Observacion->save($comentario)) {
				$proyecto = $this -> Observacion -> Proyecto -> read(null,$comentario["Observacion"]["llave_foranea"]);
				$servicios_usuario = $this -> requestAction('/usuarios/getServiciosUsuario/' . $this -> Auth -> user('id'));
				if (in_array(2, $servicios_usuario)) {
					if(!$proyecto["Proyecto"]["publicacion_para_omega"]) $proyecto["Proyecto"]["publicacion_para_omega"]=true;
				}
				$this->Observacion->Proyecto->save($proyecto);
				$usuario=$this->Observacion->Usuario->recursive=0;
				$usuario=$this->Observacion->Usuario->read(null,$comentario["Observacion"]["usuario_id"]);
				$this->enviarCorreoComentariosPublicos($this -> Observacion -> id,$comentario["Observacion"]["llave_foranea"],$proyecto['Proyecto']['servicio_id'], "El Usuario: ".$usuario["Usuario"]["nombre"]." del Proyecto ".$proyecto["Proyecto"]["nombre"]." ha escrito el siguiente comentario: \n".$comentario["Observacion"]["texto"]);
				$mensaje = $this -> getRelatedComments(null, $comentario["Observacion"]["usuario_id"], $comentario["Observacion"]["modelo"], $comentario["Observacion"]["llave_foranea"]);
				$this -> correoACarlos($mensaje);
				echo "OK";
			}else{
				echo "No se pudo agregar su comentario, Por favor Intente de nuevo";
			}
		}else{
			echo "Debe escribir un comentario";
		}
		configure::Write("debug",0);
		$this->autoRender=false;
		exit(0);
	}
	
}