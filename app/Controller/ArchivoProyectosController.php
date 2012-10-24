<?php
App::uses('AppController', 'Controller');
/**
 * ArchivoProyectos Controller
 *
 * @property Archivo $Archivo
 */
class ArchivoProyectosController extends AppController {

	public $uses = array('Archivo');

	function admin_index($proyectoId) {
		$this -> layout = "ajax";
		$this -> Archivo -> contain('Proyecto', 'CategoriasArchivo');
		$paginate = array(
			'Archivo' => array(
				'conditions' => array(
					'Archivo.modelo' => 'Proyecto',
					'Archivo.llave_foranea' => $proyectoId
				)
			)
		);
		if($this -> request -> is('post')) {
			if(!empty($this -> request -> data['Filtro']['categorias_archivo_id'])) {
				$paginate['Archivo']['conditions']['Archivo.categorias_archivo_id'] = $this -> request -> data['Filtro']['categorias_archivo_id'];
			}
			$this -> Session -> write('Archivo.filtro', $paginate);
		}
		if($this -> Session -> read('Archivo.filtro')) {
			$this -> paginate = $this -> Session -> read('Archivo.filtro');
			$this -> set('filtro', 1);
		} else {
			$this -> paginate = $paginate;
			$this -> set('filtro', 0);
		}
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
		$this -> set('archivoProyectos', $this -> paginate('Archivo'));
		$this -> set('proyectoId', $proyectoId);
	}
	
	function index($proyectoId) {
		$this -> layout = "ajax";
		$this -> Archivo -> contain('Proyecto', 'CategoriasArchivo');
		$paginate = array(
			'Archivo' => array(
				'conditions' => array(
					'Archivo.modelo' => 'Proyecto',
					'Archivo.llave_foranea' => $proyectoId
				)
			)
		);
		if($this -> request -> is('post')) {
			if(!empty($this -> request -> data['Filtro']['categorias_archivo_id'])) {
				$paginate['Archivo']['conditions']['Archivo.categorias_archivo_id'] = $this -> request -> data['Filtro']['categorias_archivo_id'];
			}
			$this -> Session -> write('Archivo.filtro', $paginate);
		}
		if($this -> Session -> read('Archivo.filtro')) {
			$this -> paginate = $this -> Session -> read('Archivo.filtro');
			$this -> set('filtro', 1);
		} else {
			$this -> paginate = $paginate;
			$this -> set('filtro', 0);
		}
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
		$this -> set('archivoProyectos', $this -> paginate());
		$this -> set('proyectoId', $proyectoId);
	}
	
	public function admin_removeFilter($proyectoId) {
		$this -> Session -> delete('Archivo.filtro');
		$this -> redirect(array('action' => 'index', $proyectoId));
	}
	
	public function removeFilter($proyectoId) {
		$this -> Session -> delete('Archivo.filtro');
		$this -> redirect(array('action' => 'index', $proyectoId));
	}

	function add($proyectoId = null) {
		$this -> layout = "ajax";
		if (!empty($this -> request -> data)) {
			$proyectoId = $this -> request -> data["ArchivoProyecto"]["proyecto_id"];
			$this -> Archivo -> create();
			$this -> request -> data['ArchivoProyecto']['modelo'] = 'Proyecto';
			$this -> request -> data['ArchivoProyecto']['llave_foranea'] = $proyectoId;
			$archivo = array('Archivo' => $this -> request -> data['ArchivoProyecto']);
			if ($this -> Archivo -> save($archivo)) {
				$this -> Session -> setFlash(__('Se guardó el archivo'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se guardó el archivo'), 'crud/error');
			}
		}
		$this -> set(compact('proyectoId'));
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
	}

	function admin_add($proyectoId = null) {
		$proyectoId = $proyectoId;
		$this -> layout = "ajax";
		if (!empty($this -> data)) {
			$proyectoId = $this -> data["ArchivoProyecto"]["proyecto_id"];
			$this -> Archivo -> create();
			$this -> data['ArchivoProyecto']['modelo'] = 'Proyecto';
			$this -> data['ArchivoProyecto']['llave_foranea'] = $proyectoId;
			$archivo = array('Archivo' => $this -> data['ArchivoProyecto']);
			if ($this -> Archivo -> save($archivo)) {
				$this -> Session -> setFlash(__('Se guardó el archivo'), 'crud/success');
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('No se guardó el archivo'), 'crud/error');
			}
		}
		$this -> set(compact('proyectoId'));
		$this -> set('categoriasArchivos', $this -> Archivo -> CategoriasArchivo -> find('list'));
	}

	function delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Archivo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Archivo -> delete($id)) {
			$this -> Session -> setFlash(__('Eliminado el archivo'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el archivo'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this -> Session -> setFlash(__('Archivo no válido'), 'crud/error');
			$this -> redirect(array('action' => 'index'));
		}
		if ($this -> Archivo -> delete($id)) {
			$this -> Session -> setFlash(__('Eliminado el archivo'), 'crud/success');
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('No se eliminó el archivo'), 'crud/error');
		$this -> redirect(array('action' => 'index'));
	}

	function admin_verArchivo($id) {
		$archivo = $this -> Archivo -> read("ruta", $id);
		$partes = explode("/", $archivo["Archivo"]["ruta"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);
		$this -> set($params);
	}

	function verArchivo($id) {
		$archivo = $this -> Archivo -> read("ruta", $id);
		$partes = explode("/", $archivo["Archivo"]["ruta"]);
		$nombrePartido = explode(".", $partes[2]);
		$this -> viewClass = 'Media';
		$params = array('id' => $partes[2], 'name' => $nombrePartido[0], 'download' => true, 'extension' => $nombrePartido[1], 'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"), 'path' => $partes[1] . DS);
		$this -> set($params);
	}

	function AJAX_subirArchivo() {
		$archivo["Archivo"]["modelo"] = 'Proyecto';
		$archivo["Archivo"]["llave_foranea"] = $this -> request -> data["id"];
		$archivo["Archivo"]["ruta"] = $this -> request -> data["path"];
		$archivo["Archivo"]['categorias_archivo_id'] = $this -> request -> data['category'];
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
