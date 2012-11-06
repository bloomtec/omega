<?php
App::uses('AppController', 'Controller');
/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 */
class EmpresasController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		//$this -> Empresa -> recursive = 0;
		$this -> layout="empresa";
		$servicios_usuario = $this -> requestAction('/usuarios/getServiciosUsuario/' . $this -> Auth -> user('id'));
		$this -> set('servicios_usuario', $servicios_usuario);
		$this -> set('empresa', $this -> Empresa -> read(null, $this -> Auth -> user('empresa_id')));
		$this -> paginate = array(
			'Contrato' => array(
				'conditions' => array(
					'Contrato.empresa_id' => $this -> Auth -> user('empresa_id')
				)
			),
			'Proyecto' => array(
				'conditions' => array(
					'Proyecto.empresa_id' => $this -> Auth -> user('empresa_id'),
					'Proyecto.estado_proyecto_id <>' => 9
				)
			)
		);
		
		$estadosProyectosCotizacion = $this -> Empresa -> Proyecto -> EstadoProyecto -> find("list", array("fields" => array("id", "nombre"), "conditions" => array("id <" => 3)));
		$estadosProyectosEjecucion = $this -> Empresa -> Proyecto -> EstadoProyecto -> find("list", array("fields" => array("id", "nombre"), "conditions" => array("id >=" => 3)));
		
		$this -> set('empresa', $this -> Empresa -> read(null, $this -> Auth -> user('empresa_id')));		
		$this -> set('contratos', $this -> paginate('Contrato'));
		$this -> set('proyectos', $this -> paginate('Proyecto'));
		$this -> set(compact("estadosProyectosCotizacion", "estadosProyectosEjecucion"));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		$this -> set('empresa', $this -> Empresa -> read(null, $id));
	}

	public function cambiarPassword() {
		$usuario = $this -> Empresa -> Usuario -> read(null, $this -> Auth -> user('id'));
		$usuario["Usuario"]["contraseña"] = $this -> request -> data["Empresa"]["contraseña"];
		$usuario["Usuario"]["verificar_contraseña"] = $this -> request -> data["Empresa"]["verificar_contraseña"];
		$usuario["Usuario"]["primer_login"] = false;
		if ($this -> Empresa -> Usuario -> save($usuario)) {
			$Name = "OMEGA INGENIEROS";
			//senders name
			$email = "info@omegaingenieros.com";
			//senders e-mail adress
			$recipient = $usuario["Usuario"]["correo"];
			//recipient
			$subject = "Cambio de contraseña";
			//subject
			$header = "From: " . $Name . " <" . $email . ">\r\n";
			//optional headerfields
			$mail_body = "Gracias por usar nuestra plataforma de Atencion de clientes, sus datos son los siguientes:\n usuario:" . $usuario["Usuario"]["nombre_de_usuario"] . "\nContraseña:" . $this -> request -> data["Empresa"]["contraseña"];
			//mail($recipient, $subject, $mail_body, $header);
			$this -> sendbySMTP("", $usuario["Usuario"]["correo"], $subject, $mail_body);
			$this -> Session -> write("Auth.User.primer_login", false);
			$this -> Session -> setFlash(__('Se ha cambiado su contraseña'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		} else {
			$this -> Session -> setFlash(__('No se pudo cambiar la contraseña'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
	}

	/**
	 * admin_solilcitudes method
	 *
	 * @return void
	 */
	public function admin_solicitudes($clienteId) {
		$this -> layout = "ajax";
		$this -> set("solicitudes", $this -> Empresa -> Solicitud -> find("all"));
	}

	/**
	 * admin_borrarSolicitud method
	 *
	 * @return void
	 */
	public function admin_borrarSolicitud($solicitudId, $empresaId) {
		$this -> Empresa -> Solicitud -> delete($solicitudId);
		$solicitudes = $this -> Empresa -> Solicitud -> find("count", array("conditions" => array("Solicitud.empresa_id" => $empresaId)));
		if ($solicitudes < 1) {
			$this -> Empresa -> recursive = -1;
			$this -> Empresa -> read(null, $empresaId);
			$this -> Empresa -> set("tiene_solicitud", false);
			$this -> Empresa -> save();
		}
		$this -> redirect(array('action' => 'solicitudes', $empresaId));
	}

	public function admin_todos() {
		$this -> Empresa -> contain('Usuario', 'Solicitud');
		//$this -> Empresa -> Contrato -> bindModel(array("hasMany" => array("ContratosEquipo" => array('className' => 'ContratosEquipo', 'foreignKey' => 'contrato_id', 'dependent' => false))));
		$this -> set('empresas', $this -> paginate());
	}

	public function admin_proyectos() {
		$this -> Empresa -> Usuario -> contain('Empresa.Proyecto.Alarma');
		$servicios_usuarios = $this -> Empresa -> Usuario -> ServiciosUsuario -> find('all', array('conditions' => array('ServiciosUsuario.servicio_id' => 2)));
		$usuarios_proyectos = array();
		foreach ($servicios_usuarios as $key => $servicios_usuario) {
			$user_id = $servicios_usuario['ServiciosUsuario']['usuario_id'];
			$usuarios_proyectos[$user_id] = $user_id;
		}
		$this -> paginate = array(
			'Usuario' => array(
				'conditions' => array(
					'Usuario.id' => $usuarios_proyectos
				),
				'order' => array(
					'Empresa.tiene_publicacion_empresa' => 'DESC',
					'Empresa.tiene_publicacion_omega' => 'DESC',
					'Empresa.tiene_alerta' => 'DESC'
				)
			)
		);
		$this -> set('empresas', $this -> paginate('Usuario'));
	}

	public function admin_mantenimientos() {
		$this -> Empresa -> Usuario -> contain('Empresa.Contrato.Alarma');
		$servicios_usuarios = $this -> Empresa -> Usuario -> ServiciosUsuario -> find('all', array('conditions' => array('ServiciosUsuario.servicio_id' => 1)));
		$usuarios_proyectos = array();
		foreach ($servicios_usuarios as $key => $servicios_usuario) {
			$user_id = $servicios_usuario['ServiciosUsuario']['usuario_id'];
			$usuarios_proyectos[$user_id] = $user_id;
		}
		$this -> paginate = array(
			'Usuario' => array(
				'conditions' => array(
					'Usuario.id' => $usuarios_proyectos
				),
				'order' => array(
					'Empresa.tiene_publicacion_empresa' => 'DESC',
					'Empresa.tiene_publicacion_omega' => 'DESC',
					'Empresa.tiene_alerta' => 'DESC'
				)
			)
		);
		$this -> set('empresas', $this -> paginate('Usuario'));
	}

	public function admin_add_usuarios($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Empresa no válida'));
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> request -> is('post')) {
			if (empty($this -> request -> data['Usuario']['servicios'])) {
				$this -> Session -> setFlash(__('Seleccione al menos un servicio visible para el usuario'), 'crud/error');
			} else {
				// Asignar ID de la empresa y el rol correspondiente al usuario
				$this -> request -> data['Usuario']['empresa_id'] = $id;
				$this -> request -> data['Usuario']['rol_id'] = 3;
				$this -> request -> data['Usuario']['primer_login'] = 1;

				//$this -> request -> data['Usuario']['password'] = $this -> Auth -> password($this -> request -> data["Usuario"]["password2"]);
				//$user["Usuario"] = $this -> request -> data["Usuario"];

				if ($this -> Empresa -> Usuario -> save($this -> request -> data)) {

					foreach ($this -> request -> data['Usuario']['servicios'] as $key => $servicio_id) {
						$this -> Empresa -> Usuario -> ServiciosUsuario -> create();
						$tmp_data = array('ServiciosUsuario' => array('usuario_id' => $this -> Empresa -> Usuario -> id, 'servicio_id' => $servicio_id));
						$this -> Empresa -> Usuario -> ServiciosUsuario -> save($tmp_data);
					}

					// Código anterior para lo de los permisos. Esto ya no aplica.
					// $clienteUsuario["EmpresasUsuario"]["cliente_id"] = $this -> request -> data["Empresa"]["Empresa"]["id"];
					// $clienteUsuario["EmpresasUsuario"]["usuario_id"] = $this -> Empresa -> Usuario -> id;
					// $clienteUsuario["EmpresasUsuario"]["role"] = $this -> request -> data["Usuario"]["role"];
					// $this -> Empresa -> EmpresasUsuario -> save($clienteUsuario);

					// Recipient name
					$recipient_name = $this -> request -> data['Usuario']['nombre'] . ' ' . $this -> request -> data['Usuario']['apellido'];

					// Recipient e-mail adress
					$recipient_email = $this -> request -> data["Usuario"]["correo"];

					// Subject
					$subject = "Datos de cuenta de usuario";

					//optional headerfields
					$mail_body =
						"Bienvenido a nuestra plataforma de atención de clientes.
						\n
						Sus datos son los siguientes:
						\n
						Usuario: " . $this -> request -> data["Usuario"]["nombre_de_usuario"] . "
						\n
						Contraseña: " . $this -> request -> data["Usuario"]["contraseña"] . "
						\n
						";
					
					if(isset($this -> request -> data['Email']['body']) && !empty($this -> request -> data['Email']['body'])) {
						$mail_body .= '
						
						' . $this -> request -> data['Email']['body'];
					}

					$this -> sendbySMTP('', $recipient_email, $subject, $mail_body);

					$this -> Session -> setFlash(__('El nuevo Usuario ha sido creado'), 'crud/success');
					$this -> redirect(array('action' => 'index'));
				} else {
					$this -> request -> data["Usuario"]["contraseña"] = "";
					$this -> request -> data["Usuario"]["verificar_contraseña"] = "";
					//$this -> set("clienteId", $this -> request -> data["Empresa"]["Empresa"]["id"]);
					$this -> Session -> setFlash(__('No se pudo crear el nuevo Usuario. Por favor, intente de nuevo.'), 'crud/error');
				}
			}
		} else {
			//$this -> set("empresaId", $id);
		}

		$this -> set('servicios', $this -> getServicios($id));
	}

	/**
	 * Obtener los servicios asignados a una empresa
	 */
	public function getServicios($id) {
		$servicios = $this -> Empresa -> Servicio -> find('list');
		$servicios_empresa = $this -> Empresa -> EmpresasServicio -> find('all', array('conditions' => array('EmpresasServicio.empresa_id' => $id)));

		foreach ($servicios as $key => $servicio) {
			$service_found = false;
			foreach ($servicios_empresa as $key2 => $servicio2) {
				if ($servicio2['EmpresasServicio']['servicio_id'] == $key) { $service_found = true;
				}
			}
			if (!$service_found) {
				unset($servicios[$key]);
			}
		}
		return $servicios;
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> Empresa -> contain('Contrato', 'Solicitud');
		$paginate = array(
			'order' => array(
				'Empresa.activa' => 'DESC',
				'Empresa.tiene_publicacion_empresa' => 'DESC',
				'Empresa.tiene_publicacion_omega' => 'DESC',
				'Empresa.tiene_alerta' => 'DESC'
			)
		);
		if($this -> request -> is('post')) {
			$paginate['conditions']['or'] = array(
				'nombre LIKE' => '%' . $this -> request -> data['Empresa']['nombre'] . '%',
				'identificacion LIKE' => '%' . $this -> request -> data['Empresa']['nombre'] . '%'
			);
		}
		$this -> paginate = $paginate;
		$this -> set('empresas', $this -> paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this -> Empresa -> contain(
			'Proyecto',
			'Proyecto.Alarma',
			'Contrato',
			'Contrato.Equipo',
			'Contrato.Alarma',
			'Contrato.Tipo',
			'Contrato.Estado'
		);
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		$this -> set('empresa', $this -> Empresa -> read(null, $id));
		$this -> set('servicios', $this -> getServicios($id));
		$estadosProyectosCotizacion = $this -> Empresa -> Proyecto -> EstadoProyecto -> find("list", array("fields" => array("id", "nombre"), "conditions" => array("or" => array("id <" => 3, "id >" => 7))));
		$estadosProyectosEjecucion = $this -> Empresa -> Proyecto -> EstadoProyecto -> find("list", array("fields" => array("id", "nombre"), "conditions" => array("id >=" => 3, "id <" => "8")));
		$this -> set(compact("estadosProyectosCotizacion", "estadosProyectosEjecucion"));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this -> request -> is('post')) {
			if (empty($this -> request -> data['Empresa']['servicios'])) {
				$this -> Session -> setFlash(__('Seleccione al menos un servicio para la empresa.'), 'crud/error');
			} else {
				$this -> Empresa -> create();
				if ($this -> Empresa -> save($this -> request -> data)) {
					foreach ($this -> request -> data['Empresa']['servicios'] as $key => $servicio_id) {
						$this -> Empresa -> EmpresasServicio -> create();
						$tmp_data = array('EmpresasServicio' => array('empresa_id' => $this -> Empresa -> id, 'servicio_id' => $servicio_id));
						$this -> Empresa -> EmpresasServicio -> save($tmp_data);
					}
					$this -> Session -> setFlash(__('Se guardó la empresa'), 'crud/success');
					$this -> redirect(array('action' => 'add_usuarios', $this -> Empresa -> id));
				} else {
					$this -> Session -> setFlash(__('No se pudo guardar la empresa. Por favor, intente de nuevo.'), 'crud/error');
				}
			}
		}
		$servicios = $this -> Empresa -> Servicio -> find('list');
		$this -> set(compact('servicios'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this -> Empresa -> contain('Servicio');
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Empresa -> save($this -> request -> data)) {
				$servicios_previos = $this -> Empresa -> EmpresasServicio -> find('all', array('conditions' => array('EmpresasServicio.empresa_id' => $this -> request -> data['Empresa']['id'])));
				foreach ($servicios_previos as $key => $servicio) {
					$this -> Empresa -> EmpresasServicio -> delete($servicio['EmpresasServicio']['id']);
				}
				foreach ($this -> request -> data['Empresa']['servicios'] as $key => $servicio_id) {
					$this -> Empresa -> EmpresasServicio -> create();
					$tmp_data = array('EmpresasServicio' => array('empresa_id' => $this -> Empresa -> id, 'servicio_id' => $servicio_id));
					$this -> Empresa -> EmpresasServicio -> save($tmp_data);
				}
				$this -> Session -> setFlash(__('Se guardó la empresa'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo guardar la empresa. Por favor, intente de nuevo.'), 'crud/error');
			}
		} else {
			$this -> request -> data = $this -> Empresa -> read(null, $id);
		}
		$servicios = $this -> Empresa -> Servicio -> find('list');
		$servicios_prestados = array();
		foreach ($this -> request -> data['Servicio'] as $key => $servicio) {
			$servicios_prestados[$servicio['id']] = $servicio['id'];
		}
		$this -> set(compact('servicios', 'servicios_prestados'));
		$this -> set('referer', $this -> referer());
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	/*public function admin_delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this -> Empresa -> delete()) {
			$this -> Session -> setFlash(__('Empresa deleted'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Empresa was not deleted'));
		$this -> redirect(array('action' => 'index'));
	}*/
	
	public function admin_enable($id) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		if ($this -> Empresa -> saveField('activa', 1)) {
			$this -> Session -> setFlash(__('Se activó la empresa'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se activó la empresa'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}
	
	public function admin_disable($id) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Empresa -> id = $id;
		if (!$this -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		if ($this -> Empresa -> saveField('activa', 0)) {
			$this -> Session -> setFlash(__('Se desactivó la empresa'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se desactivó la empresa'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

}