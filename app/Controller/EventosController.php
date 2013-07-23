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
		// Alarma
		$this->loadModel('ContratosEquipo');
		$contratoEquipo = $this -> ContratosEquipo -> read(null, $this -> data["contratosEquipoId"]);
		$this->loadModel('Alarma');
		$this->Alarma->create();
		$alarma = array(
			'Alarma' => array(
				'modelo' => 'Equipo',
				'llave_foranea' => $contratoEquipo['ContratosEquipo']['equipo_id'],
				'para_empresa' => 1
			)
		);
		if($this->Alarma->save($alarma)) {
			$this -> Evento -> create();
			if ($this -> Evento -> save($evento)) {
				echo "YES";
			} else {
				echo "No se pudo guardar su comentario. Por favor, intente de nuevo";
			}
		} else {
			echo "Error al crear la alarma";
		}
		// Fin Alarma

		configure::Write("debug", 0);
		$this -> autoRender = false;
		exit(0);
	}

}
