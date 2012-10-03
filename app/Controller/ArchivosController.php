<?php
App::uses('AppController', 'Controller');
/**
 * Archivos Controller
 *
 * @property Archivo $Archivo
 */
class ArchivosController extends AppController {

	public function index($equipoId) {
		$this -> layout = "ajax";
		$this -> Archivo -> contain('CategoriasArchivo', 'Equipo');
		$equipo_id = null;
		if($equipoId) {
			$equipo_id = $equipoId;
		} else {
			$equipo_id = $this -> params["pass"][0];
		}
		$this -> paginate = array(
			'conditions' => array(
				'Archivo.modelo' => 'Equipo',
				'Archivo.llave_foranea' => $equipoId
			)
		);
		$this -> set('archivos', $this -> paginate());
		$this -> set(compact("equipoId", $equipoId));
	}

	public function view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> set('archivo', $this -> Archivo -> read(null, $id));
	}

	public function add() {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$equipoId = $this -> request -> data["Archivo"]["equipo_id"];
			$this -> Archivo -> create();
			if ($this -> Archivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'archivo'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'archivo'));
			}
		} else {
			$equipoId = $this -> params["pass"][0];
		}
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
		$this -> set(compact('equipoId'));
	}

	public function edit($id = null) {
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			if ($this -> Archivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'archivo'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'archivo'));
			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Archivo -> read(null, $id);
		}
		$equipos = $this -> Archivo -> Equipo -> find('list');
		$this -> set(compact('equipos'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(sprintf(__('Invalid id for %s', true), 'archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Archivo -> delete($id)) {
			$this -> Session -> setFlash(sprintf(__('%s deleted', true), 'Archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(sprintf(__('%s was not deleted', true), 'Archivo'));
		$this -> redirect(array('action' => 'index'));
	}

	public function admin_index($equipoId) {
		$this -> Archivo -> contain('CategoriasArchivo', 'Equipo');
		$this -> layout = "ajax";
		$equipo_id = null;
		if($equipoId) {
			$equipo_id = $equipoId;
		} else {
			$equipo_id = $this -> params["pass"][0];
		}
		$this -> paginate = array(
			'conditions' => array(
				'Archivo.modelo' => 'Equipo',
				'Archivo.llave_foranea' => $equipoId
			)
		);
		$this -> set('archivos', $this -> paginate());
		$this -> set(compact("equipoId", $equipoId));
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Invalid archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> set('archivo', $this -> Archivo -> read(null, $id));
	}

	public function admin_add() {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$equipoId = $this -> request -> data["Archivo"]["equipo_id"];
			$this -> Archivo -> create();
			if ($this -> Archivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'archivo'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'archivo'));
			}
		} else {
			$equipoId = $this -> params["pass"][0];
		}
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
		$this -> set(compact('equipoId'));
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this -> request -> data)) {
			$this -> Session -> setFlash(sprintf(__('Invalid %s', true), 'archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		if (!empty($this -> request -> data)) {
			if ($this -> Archivo -> save($this -> request -> data)) {
				$this -> Session -> setFlash(sprintf(__('The %s has been saved', true), 'archivo'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'archivo'));
			}
		}
		if (empty($this -> request -> data)) {
			$this -> request -> data = $this -> Archivo -> read(null, $id);
		}
		$equipos = $this -> Archivo -> Equipo -> find('list');
		$this -> set(compact('equipos'));
	}

	public function admin_delete($id = null, $equipo_id) {
		if (!$id) {
			$this -> Session -> setFlash(__('Invalid archivo'));
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Archivo -> delete($id)) {
			$this -> Session -> setFlash(__('Archivo borrado'), 'crud/success');
		} else {
			$this -> Session -> setFlash(__('No se borro el archivo'), 'crud/error');
		}
		$this -> redirect(array('controller' => 'archivos', 'action' => 'index'));
	}

	public function admin_verArchivo($id) {
		$archivo = $this -> Archivo -> read("ruta", $id);
		$partes = explode("/", $archivo["Archivo"]["ruta"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);

	}

	public function verArchivo($id) {
		$archivo = $this -> Archivo -> read("ruta", $id);
		$partes = explode("/", $archivo["Archivo"]["ruta"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);

		$this -> set($params);

	}

	public function AJAX_subirArchivo() {
		$archivo['Archivo']['modelo'] = 'Equipo';
		$archivo["Archivo"]["llave_foranea"] = $this -> data["id"];
		$archivo["Archivo"]["ruta"] = $this -> data["path"];
		$archivo['Archivo']['categorias_archivo_id'] = $this -> data['category'];
		$this -> Archivo -> create();
		if ($this -> Archivo -> save($archivo)) {
			echo "El Archivo ha sido subido con exito";
		} else {
			echo "NO";
		}
		Configure::Write("debug", 0);
		$this -> Autorender = false;
		exit(0);
	}

}
