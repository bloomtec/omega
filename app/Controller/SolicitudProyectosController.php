<?php
class SolicitudProyectosController extends AppController {

	var $name = 'SolicitudProyectos';

	function index() {
		$this -> SolicitudProyecto -> contain('Proyecto');
		$this->SolicitudProyecto->recursive = 0;
		$this->set('solicitudProyectos', $this->paginate());
	}

	function view($id = null) {
		$this->layout="ajax";
		$this -> SolicitudProyecto -> contain('Proyecto');
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'solicitud proyecto'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('solicitudProyecto', $this->SolicitudProyecto->read(null, $id));
	}
	function admin_view($id = null) {
		$this->layout="ajax";
		$this -> SolicitudProyecto -> contain('Proyecto');
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'solicitud proyecto'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('solicitudProyecto', $this->SolicitudProyecto->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->SolicitudProyecto->create();
			if ($this->SolicitudProyecto->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'solicitud proyecto'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'solicitud proyecto'));
			}
		}
		$proyectos = $this->SolicitudProyecto->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'solicitud proyecto'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SolicitudProyecto->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'solicitud proyecto'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'solicitud proyecto'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SolicitudProyecto->read(null, $id);
		}
		$proyectos = $this->SolicitudProyecto->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'solicitud proyecto'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SolicitudProyecto->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Solicitud proyecto'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Solicitud proyecto'));
		$this->redirect(array('action' => 'index'));
	}
}
?>