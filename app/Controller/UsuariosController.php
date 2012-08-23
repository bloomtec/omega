<?php
App::uses('AppController', 'Controller');
/**
 * Usuarios Controller
 *
 * @property Usuario $Usuario
 */
class UsuariosController extends AppController {
	
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
		$roles = $this -> Usuario -> Rol -> find('list', array('conditions' => array('Rol.id >=' => $this -> Auth -> user('rol_id'))));
		$servicios = $this -> Usuario -> Servicio -> find('list');
		$this -> set(compact('empresas', 'roles', 'servicios'));
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
