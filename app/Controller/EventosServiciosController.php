<?php
App::uses('AppController', 'Controller');
/**
 * EventosServicios Controller
 *
 * @property Evento $Evento
 */
class EventosServiciosController extends AppController {

	function view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Evento no válido'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> set('evento', $this -> Evento -> read(null, $id));
	}

	function admin_AJAX_add() {
		$evento["EventosServicio"]["texto"] = $this -> data["texto"];
		$evento["EventosServicio"]["modelo"] = $this -> data["modelo"];
		$evento["EventosServicio"]["llave_foranea"] = $this -> data["llave_foranea"];
		$this -> EventosServicio -> create();
		if ($this -> EventosServicio -> save($evento))
			echo "YES";
		else
			echo "No se pudo guardar su comentario. Por favor, intente de nuevo";
		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

}
