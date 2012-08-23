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
		
	}
	
	/**
	 * logout method
	 *
	 * @return void
	 */
	public function logout() {
		
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
			throw new NotFoundException(__('Invalid usuario'));
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
				$this -> Session -> setFlash(__('The usuario has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The usuario could not be saved. Please, try again.'));
			}
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list');
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
			throw new NotFoundException(__('Invalid usuario'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Usuario -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The usuario has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The usuario could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Usuario -> read(null, $id);
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list');
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
			throw new NotFoundException(__('Invalid usuario'));
		}
		if ($this -> Usuario -> delete()) {
			$this -> Session -> setFlash(__('Usuario deleted'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Usuario was not deleted'));
		$this -> redirect(array('action' => 'index'));
	}
	
	/**
	 * admin_login method
	 *
	 * @return void
	 */
	public function admin_login() {
		
	}
	
	/**
	 * admin_logout method
	 *
	 * @return void
	 */
	public function admin_logout() {
		
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> Usuario -> recursive = 0;
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
		$this -> Usuario -> id = $id;
		if (!$this -> Usuario -> exists()) {
			throw new NotFoundException(__('Invalid usuario'));
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
				$this -> Session -> setFlash(__('The usuario has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The usuario could not be saved. Please, try again.'));
			}
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list');
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
			throw new NotFoundException(__('Invalid usuario'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Usuario -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The usuario has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The usuario could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Usuario -> read(null, $id);
		}
		$empresas = $this -> Usuario -> Empresa -> find('list');
		$roles = $this -> Usuario -> Rol -> find('list');
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
			throw new NotFoundException(__('Invalid usuario'));
		}
		if ($this -> Usuario -> delete()) {
			$this -> Session -> setFlash(__('Usuario deleted'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Usuario was not deleted'));
		$this -> redirect(array('action' => 'index'));
	}

}
