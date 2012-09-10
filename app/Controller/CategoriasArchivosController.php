<?php
App::uses('AppController', 'Controller');
/**
 * CategoriasArchivos Controller
 *
 * @property CategoriasArchivo $CategoriasArchivo
 */
class CategoriasArchivosController extends AppController {

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> CategoriasArchivo -> recursive = 0;
		$this -> set('categoriasArchivos', $this -> paginate());
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this -> request -> is('post')) {
			$this -> CategoriasArchivo -> create();
			if ($this -> CategoriasArchivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se agregó la categoría'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo agregar la categoría. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this -> CategoriasArchivo -> id = $id;
		if (!$this -> CategoriasArchivo -> exists()) {
			throw new NotFoundException(__('Invalid categorias archivo'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> CategoriasArchivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se modificó la categoría'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se pudo modificar la categoría. Por favor, intente de nuevo.'), 'crud/error');
			}
		} else {
			$this -> request -> data = $this -> CategoriasArchivo -> read(null, $id);
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
		$this -> CategoriasArchivo -> id = $id;
		if (!$this -> CategoriasArchivo -> exists()) {
			throw new NotFoundException(__('Invalid categorias archivo'));
		}
		if($this -> CategoriasArchivo -> Archivo -> findByCategoriasArchivoId($id)) {
			$this -> Session -> setFlash(__('Hay archivos relacionados con la categoría. Intente de nuevo cuando la categoría este libre de archivos.'), 'crud/error');
		} else {
			if ($this -> CategoriasArchivo -> delete()) {
				$this -> Session -> setFlash(__('Se eliminó la categoría'), 'crud/success');
			} else {
				$this -> Session -> setFlash(__('No se eliminó la categoría'), 'crud/error');
			}
		}
		$this -> redirect(array('action' => 'index'));
	}

}
