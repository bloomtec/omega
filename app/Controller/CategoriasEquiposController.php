<?php
App::uses('AppController', 'Controller');
/**
 * CategoriasEquipos Controller
 *
 * @property CategoriasEquipo $CategoriasEquipo
 */
class CategoriasEquiposController extends AppController {
	
	/**
	 * Retorna un listado de categorías para los equipos de la empresa escogida. 
	 * 
	 * @param $empresa_id ID de la empresa que se quiere obtener sus categorias para los equipos
	 */
	public function get($empresa_id) {
		return $this -> CategoriasEquipo -> find(
			'list',
			array(
				'conditions' => array(
					'CategoriasEquipo.empresa_id' => $empresa_id
				)
			)
		);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> CategoriasEquipo -> recursive = 0;
		$this -> set('categoriasEquipos', $this -> paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this -> CategoriasEquipo -> id = $id;
		if (!$this -> CategoriasEquipo -> exists()) {
			throw new NotFoundException(__('Invalid categorias equipo'));
		}
		$this -> set('categoriasEquipo', $this -> CategoriasEquipo -> read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add($empresa_id, $contrato_id) {
		$this -> CategoriasEquipo -> Empresa -> id = $empresa_id;
		if(!$this -> CategoriasEquipo -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		if ($this -> request -> is('post')) {
			$this -> CategoriasEquipo -> create();
			if ($this -> CategoriasEquipo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se agregó la categoría'), 'crud/success');
				$this -> redirect(array('controller' => 'contratos', 'action' => 'view', $contrato_id));
			} else {
				$this -> Session -> setFlash(__('No se pudo agregar la categoría. Por favor, intente de nuevo.'));
			}
		}
		$empresas = $this -> CategoriasEquipo -> Empresa -> find('list', array('conditions' => array('Empresa.id' => $empresa_id)));
		$this -> set(compact('empresas', 'contrato_id'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($empresa_id, $contrato_id, $categoria_id) {
		$this -> CategoriasEquipo -> Empresa -> id = $empresa_id;
		if(!$this -> CategoriasEquipo -> Empresa -> exists()) {
			throw new NotFoundException(__('Empresa no válida'));
		}
		$this -> CategoriasEquipo -> id = $categoria_id;
		if (!$this -> CategoriasEquipo -> exists()) {
			throw new NotFoundException(__('Categoría de equipo no válida'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> CategoriasEquipo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se ha modificado la categoría de equipos'), 'crud/success');
				$this -> redirect(array('controller' => 'contratos', 'action' => 'view', $contrato_id));
			} else {
				$this -> Session -> setFlash(__('The categorias equipo could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> CategoriasEquipo -> read(null, $categoria_id);
		}
		$empresas = $this -> CategoriasEquipo -> Empresa -> find('list', array('conditions' => array('Empresa.id' => $empresa_id)));
		$this -> set(compact('empresas', 'contrato_id'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id, $contrato_id) {
		/*if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}*/
		$this -> CategoriasEquipo -> id = $id;
		if (!$this -> CategoriasEquipo -> exists()) {
			throw new NotFoundException(__('Categoría no válida'));
		}
		$categoria_asignada = false;
		$this -> CategoriasEquipo -> Equipo -> contain();
		if($this -> CategoriasEquipo -> Equipo -> findByCategoriasEquipoId($id)) $categoria_asignada = true;
		if($categoria_asignada) {
			$this -> Session -> setFlash(__('Existen equipos con esta categoría. Intente luego de que no haya equipos asignados.'), 'crud/error');
		} else {
			if ($this -> CategoriasEquipo -> delete()) {
				$this -> Session -> setFlash(__('Se eliminó la categoría'), 'crud/success');
			} else {
				$this -> Session -> setFlash(__('No se eliminó la categoría'), 'crud/error');
			}
		}
		$this -> redirect(array('controller' => 'contratos', 'action' => 'view', $contrato_id));
	}

}
