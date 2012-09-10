<?php
App::uses('AppController', 'Controller');
/**
 * Eventos Controller
 *
 * @property Evento $Evento
 */
class EventosController extends AppController {

	function view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Evento no válido'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> set('evento', $this -> Evento -> read(null, $id));
	}

	function admin_AJAX_add() {
		$evento["Evento"]["texto"] = $this -> data["texto"];
		$evento["Evento"]["contratos_equipo_id"] = $this -> data["contratosEquipoId"];
		$this -> Evento -> create();
		if ($this -> Evento -> save($evento))
			echo "YES";
		else
			echo "No se pudo guardar su comentario. Por favoer, intente de nuevo";
		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

}
