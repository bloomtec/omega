<?php
App::uses('AppController', 'Controller');
/**
 * Usuarios Controller
 *
 * @property Usuario $Usuario
 */
class UsuariosController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this -> Auth -> allow('getUsuariosServicio', 'getServiciosUsuario');
	}
	
	public function getServiciosUsuario($usuario_id) {
		//$this -> autoRender = false;
		$servicios = $this -> Usuario -> ServiciosUsuario -> find(
			'list',
			array(
				'conditions' => array('ServiciosUsuario.usuario_id' => $usuario_id),
				'fields' => array('ServiciosUsuario.servicio_id')
			)
		);
		//debug($usuarios);
		return $servicios;
	}
	
	public function getUsuariosServicio($servicio_id) {
		//$this -> autoRender = false;
		$usuarios = $this -> Usuario -> ServiciosUsuario -> find(
			'list',
			array(
				'conditions' => array('ServiciosUsuario.servicio_id' => $servicio_id),
				'fields' => array('ServiciosUsuario.usuario_id')
			)
		);
		//debug($usuarios);
		return $usuarios;
	}
	
	public function getOmega() {
		return $this -> Usuario -> find("list", array("conditions" => array("role <=" => 2), "fields" => array("correo", "nombre")));
	}

	public function recordar() {
		if ($this -> request -> is('post')) {
			$usuario = $this -> Usuario -> findByCorreo($this -> request -> data["Usuario"]["correo"]);
			if (!$usuario) {
				$this -> Session -> setFlash(__('El correo electrónico no se encuetra registrado'), 'crud/error');
			} else {
				$uno = rand(0, 9);
				$dos = rand(0, 9);
				$tres = rand(0, 9);
				$cuatro = rand(0, 9);
				$password = $uno . $dos . $tres . $cuatro;
				$usuario["Usuario"]["contraseña"] = $password;
				$usuario["Usuario"]["verificar_contraseña"] = $password;
				$usuario["Usuario"]["primer_login"] = true;
				if ($this -> Usuario -> save($usuario)) {
					$this -> Session -> setFlash(__('Se ha enviado una nueva contraseña a su correo electrónico'), 'crud/success');
					$Name = "OMEGA INGENIEROS";
					//senders name
					$email = "info@omegaingenieros.com";
					//senders e-mail adress
					$recipient = $usuario["Usuario"]["correo"];
					//recipient
					$subject = "Reestablecer contraseña";
					//subject
					$header = "From: " . $Name . " <" . $email . ">\r\n";
					//optional headerfields
					$mail_body = "Gracias por usar nuestra plataforma de Atencion de clientes, sus datos son los siguientes:\n usuario:" . $usuario["Usuario"]["nombre_de_usuario"] . "\nContraseña:" . $password;
					//mail($recipient, $subject, $mail_body, $header);
					$this -> sendbySMTP("", $usuario["Usuario"]["correo"], $subject, $mail_body);
					$this -> redirect(array('action' => 'login'));
				} else {
					$this -> Session -> setFlash(__('No se pudo completar su solicitud. Por favor, intente mas tarde'), 'crud/error');
				}
			}
		}
	}
	
	/**
	 * login method
	 *
	 * @return void
	 */
	public function login() {
		if ($this -> request -> is('post')) {
			if ($this -> Auth -> login()) {
				$this -> redirect($this -> Auth -> redirect());
			} else {
				$this -> Session -> setFlash(__('Nombre de usuario y/o contraseña no válido.'), 'crud/error');
			}
		}
	}
	
	/**
	 * logout method
	 *
	 * @return void
	 */
	public function logout() {
		$this -> redirect($this -> Auth -> logout());
	}
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		//$this -> Usuario -> recursive = 0;
		$this -> set('usuarios', $this -> paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		$this -> set('usuario', $this -> Usuario -> read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this -> request -> is('post')) {
			$this -> Usuario -> create();
			if ($this -> Usuario -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se registró el usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo registrar el usuario. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list', array('conditions' => array('Rol.id' => 3)));
		$servicios = $this -> Usuario -> Servicio -> find('list');
		$this -> set(compact('empresas', 'roles', 'servicios'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Usuario -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se guardaron los cambios del usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se guardaron los cambios del usuario. Por favor, intente de nuevo.'), 'crud/error');
			}
		} else {
			$this -> request -> data = $this -> Usuario -> read(null, $id);
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list', array('conditions' => array('Rol.id' => 3)));
		$servicios = $this -> Usuario -> Servicio -> find('list');
		$this -> set(compact('empresas', 'roles', 'servicios'));
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		if ($this -> Usuario -> delete()) {
			$this -> Session -> setFlash(__('Se eliminó el usuario'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el usuario'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}
	
	/**
	 * admin_login method
	 *
	 * @return void
	 */
	public function admin_login() {
		if ($this -> request -> is('post')) {
			if ($this -> Auth -> login()) {
				$this -> redirect($this -> Auth -> redirect());
			} else {
				$this -> Session -> setFlash(__('Nombre de usuario y/o contraseña no válido.'), 'crud/error');
			}
		}
	}
	
	/**
	 * admin_logout method
	 *
	 * @return void
	 */
	public function admin_logout() {
		$this -> redirect($this -> Auth -> logout());
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> Usuario -> contain('Rol');
		$this -> set('usuarios', $this -> paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this -> Usuario -> contain('Rol');
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		$this -> set('usuario', $this -> Usuario -> read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this -> request -> is('post')) {
			$this -> Usuario -> create();
			if ($this -> Usuario -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se registró el usuario'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo registrar el usuario. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list', array('conditions' => array('Rol.id >=' => $this -> Auth -> user('rol_id'))));
		unset($roles[3]);
		$servicios = $this -> Usuario -> Servicio -> find('list');
		$this -> set(compact('empresas', 'roles', 'servicios'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this -> Usuario -> id = $id;
		$this -> Usuario -> contain('Servicio', 'Empresa');
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if($this -> request -> data['Usuario']['rol_id'] == 3 && empty($this -> request -> data['Usuario']['servicios'])) {
				$this -> Session -> setFlash(__('Seleccione al menos un servicio visible para el usuario'));
			} else {
				if ($this -> Usuario -> save($this -> request -> data)) {
					$servicios_previos = $this -> Usuario -> ServiciosUsuario -> find('all', array('conditions' => array('ServiciosUsuario.usuario_id' => $this -> request -> data['Usuario']['id'])));
					foreach($servicios_previos as $key => $servicio) {
						$this -> Usuario -> ServiciosUsuario -> delete($servicio['ServiciosUsuario']['id']);
					}
					foreach($this -> request -> data['Usuario']['servicios'] as $key => $servicio_id) {
						$this -> Usuario -> ServiciosUsuario -> create();
						$tmp_data = array(
							'ServiciosUsuario' => array(
								'usuario_id' => $this -> Usuario -> id,
								'servicio_id' => $servicio_id
							)
						);
						$this -> Usuario -> ServiciosUsuario -> save($tmp_data);
					}
					$this -> Session -> setFlash(__('Se guardaron los cambios del usuario'), 'crud/success');
					$this -> redirect(array('action' => 'index'));
				} else {
					$this -> Session -> setFlash(__('No se guardaron los cambios del usuario. Por favor, intente de nuevo.'), 'crud/error');
				}
			}
		}
		$this -> request -> data = $this -> Usuario -> read(null, $id);
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list', array('conditions' => array('Rol.id >=' => $this -> Auth -> user('rol_id'))));
		unset($roles[3]);
		$servicios = $this -> Usuario -> Servicio -> find('list');
		$servicios_visibles = array();
		foreach($this -> request -> data['Servicio'] as $key => $servicio) {
			$servicios_visibles[$servicio['id']] = $servicio['id'];
		}
		$this -> set(compact('empresas', 'roles'));
		if(isset($this -> request -> data['Empresa']['id']) && !empty($this -> request -> data['Empresa']['id'])) {
			$this -> set('servicios_visibles', $servicios_visibles);
			$this -> set('servicios', $this -> requestAction('/empresas/getServicios/' . $this -> request -> data['Empresa']['id']));
		}
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Usuario no válido'));
		}
		if ($this -> Usuario -> delete()) {
			$this -> Session -> setFlash(__('Se eliminó el usuario'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el usuario'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

}