<?php
App::uses('AppController', 'Controller');
/**
 * Usuarios Controller
 *
 * @property Usuario $Usuario
 */
class UsuariosController extends AppController {
	
	public function getOmega() {
		return $this -> Usuario -> find("list", array("conditions" => array("role" => "omega"), "fields" => array("email", "nombre")));
	}

	public function recordar() {
		if (!empty($this -> data)) {
			$usuario = $this -> Usuario -> findByEmail($this -> data["Usuario"]["email"]);
			if (!$usuario) {
				$this -> Session -> setFlash(sprintf(__('El email no se encuetra registrado', true), 'Proyecto'));

			} else {
				$uno = rand(0, 9);
				$dos = rand(0, 9);
				$tres = rand(0, 9);
				$cuatro = rand(0, 9);
				$password = $uno . $dos . $tres . $cuatro;
				$usuario["Usuario"]["password"] = $this -> Auth -> password($password);
				$usuario["Usuario"]["cambio_password"] = false;
				if ($this -> Usuario -> save($usuario)) {
					$this -> Session -> setFlash(sprintf(__('Se ha enviado un nuevo password a su correo eléctronico', true), 'Proyecto'));
					$Name = "OMEGA INGENIEROS";
					//senders name
					$email = "info@omegaingenieros.com";
					//senders e-mail adress
					$recipient = $usuario["Usuario"]["email"];
					//recipient
					$subject = "Reestablecer contraseña";
					//subject
					$header = "From: " . $Name . " <" . $email . ">\r\n";
					//optional headerfields
					$mail_body = "Gracias por usar nuestra plataforma de Atencion de clientes, sus datos son los siguientes:\n usuario:" . $usuario["Usuario"]["username"] . "\nContraseña:" . $password;
					//mail($recipient, $subject, $mail_body, $header);
					$this -> sendbySMTP("", $usuario["Usuario"]["email"], $subject, $mail_body);
					$this -> redirect(array('action' => 'login'));
				} else {
					$this -> Session -> setFlash(sprintf(__('No se pudo completar su solicitud. Por favor, intente mas tarde', true), 'Proyecto'));
				}
			}
		}
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
		$this -> Usuario -> recursive = 0;
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
