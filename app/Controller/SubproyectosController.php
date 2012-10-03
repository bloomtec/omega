<?php
class SubproyectosController extends AppController {

	var $name = 'Subproyectos';

	function index() {
		$this->Subproyecto->recursive = 0;
		$this->set('subproyectos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'subproyecto'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subproyecto', $this->Subproyecto->read(null, $id));
	}
	function aprobarCotizacion($subProyectoId){
		$this->layout="ajax";
		$uno=rand  ( 0 ,  9 );
		$dos=rand  ( 0 ,  9 );
		$tres=rand  ( 0 ,  9 );
		$cuatro=rand  ( 0 ,  9 );
		$verificacion=$uno.$dos.$tres.$cuatro;
		$this->set("verificacion",$verificacion);
		$this->set(compact("subProyectoId"));
	}

	function confirmarAprobacion(){
		$this->layout="ajax";
		$subproyecto=$this->Subproyecto->read(null,$this->request->data["Subproyecto"]["id"]);
		$this -> Subproyecto -> id = $this->request->data["Subproyecto"]["id"];
		$this -> Subproyecto -> saveField('aprobado', true);
		$this -> Subproyecto -> saveField('estado', 'Aprobado');
		$this -> Subproyecto -> saveField('comentarios', $this -> request -> data["Subproyecto"]["comentarios"]);
		/*$subproyecto["Subproyecto"]["aprobado"]=true;
		$subproyecto["Subproyecto"]["estado"]="Aprobado";
		$subproyecto["Subproyecto"]["comentarios"]=$this->data["Subproyecto"]["comentarios"];
		$this->Subproyecto->save($subproyecto);*/
		$this->Subproyecto->Proyecto->crearAlarmaProyecto($subproyecto["Subproyecto"]["proyecto_id"],"Se ha aprobado un subproyecto",true);
		$this->enviarCorreo($subproyecto["Subproyecto"]["proyecto_id"],"Se ha aprobado un subproyecto");
		$this->Session->setFlash(__('Gracias por permitirnos hacer parte de su equipo de trabajo.'), 'crud/success');
	}
	function rechazarCotizacion($subProyectoId){
		$this->layout="ajax";
		$uno=rand  ( 0 ,  9 );
		$dos=rand  ( 0 ,  9 );
		$tres=rand  ( 0 ,  9 );
		$cuatro=rand  ( 0 ,  9 );
		$verificacion=$uno.$dos.$tres.$cuatro;
		$this->set("verificacion",$verificacion);
		$this->set(compact("subProyectoId"));
	}
	function confirmarRechazo($id=null){
		//$subproyecto = $this -> Subproyecto -> read(null, $this -> request -> data["Subproyecto"]["id"]);
		$this -> Subproyecto -> id = $this -> request -> data["Subproyecto"]["id"];
		$this -> Subproyecto -> saveField("estado","Rechazado");
		$this -> Subproyecto -> saveField("comentarios",$this -> request -> data["Subproyecto"]["comentarios"]);
		//$subproyecto["Subproyecto"]["estado"] = "Rechazado";
		//$subproyecto["Subproyecto"]["comentarios"] = $this -> request -> data["Subproyecto"]["comentarios"];
		//if($this -> Subproyecto -> save()) {
			$subproyecto = $this -> Subproyecto -> read(null, $this -> request -> data["Subproyecto"]["id"]); 
			$this -> Subproyecto -> Proyecto -> crearAlarmaProyecto($subproyecto["Subproyecto"]["proyecto_id"],"Se ha rechazado el subproyecto".$subproyecto["Subproyecto"]["nombre"],false);
			$this->enviarCorreo($subproyecto["Subproyecto"]["proyecto_id"],"Se ha rechasado el subproyecto: ".$subproyecto["Subproyecto"]["nombre"]);
			$this->Session->setFlash(__('Esperamos hacer parte de su equipo de trabajo en futuros proyectos'), 'crud/success');
		/*} else {
			debug($subproyecto);
			debug($this -> Subproyecto -> invalidFields());
		}*/
	}
	function admin_anularCotizacion($subProyectoId){
		$this->layout="ajax";
		$uno=rand  ( 0 ,  9 );
		$dos=rand  ( 0 ,  9 );
		$tres=rand  ( 0 ,  9 );
		$cuatro=rand  ( 0 ,  9 );
		$verificacion=$uno.$dos.$tres.$cuatro;
		$this->set("verificacion",$verificacion);
		$this->set(compact("subProyectoId"));
	}

	function admin_confirmarAnulacion($id=null){
		$subproyecto=$this->Subproyecto->read(null,$this-> request -> data["Subproyecto"]["id"]);
		$this -> Subproyecto -> id = $this-> request -> data["Subproyecto"]["id"];
		$this -> Subproyecto -> saveField("estado","Anulado");
		$this -> Subproyecto -> saveField("comentarios",$this -> request -> data["Subproyecto"]["comentarios"]);
		//$subproyecto["Subproyecto"]["comentarios"]=$this->data["Subproyecto"]["comentarios"];
		//$this->Subproyecto->save();
		$this -> Subproyecto -> Proyecto -> crearAlarmaProyecto($subproyecto["Subproyecto"]["proyecto_id"],"Se ha rechazado el subproyecto".$subproyecto["Subproyecto"]["nombre"],false);
		$this -> enviarCorreo($subproyecto["Subproyecto"]["proyecto_id"],"Se ha rechasado el subproyecto: ".$subproyecto["Subproyecto"]["nombre"]);
		$this -> Session -> setFlash(__('Se ha anulado la cotización'), 'crud/success');
	}

	function admin_add($proyectoId=null,$solicitudProyectoId=null) {
		$this -> layout="ajax";
		if (!empty($this->data)) {
			$proyectoId=$this->data["Subproyecto"]["proyecto_id"];
			$solicitudProyectoId=$this->data["Subproyecto"]["solicitud_proyecto_id"];
			$this->Subproyecto->create();
			if ($this->Subproyecto->save($this->data)) {
				$this->Session->setFlash(__('El sub proyecto ha sido guardado'), 'crud/success');
				if($solicitudProyectoId) $this->Subproyecto->Proyecto->SolicitudProyecto->delete($solicitudProyectoId);
				$this->Subproyecto->Proyecto->crearAlarmaProyecto($proyectoId,"Se creado un subproyecto",true);
				//$this->Subproyecto->Proyecto->enviarCorreo($subproyecto["Subproyecto"]["proyecto_id"],"Se ha creado el subproyecto");
			} else {
				$this->Session->setFlash('El sub proyecto no se pudo guardar. Por favor, intente de nuevo.', 'crud/error');
			}
		}

		$this->set(compact('proyectos','solicitudProyectoId',"proyectoId"));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Subproyecto->create();
			if ($this->Subproyecto->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'subproyecto'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'subproyecto'));
			}
		}
		$proyectos = $this->Subproyecto->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

	function admin_edit($id = null) {
		$this->layout="ajax";
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Sub proyecto no válido'));
			//$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subproyecto->save($this->data)) {
				$this->Session->setFlash(__('Se modificó el sub proyecto'), 'crud/success');
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo modificar el sub proyecto. Por favor, intente de nuevo.'), 'crud/error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subproyecto->read(null, $id);
		}
		$proyectos = $this->Subproyecto->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'subproyecto'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subproyecto->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Subproyecto'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Subproyecto'));
		$this->redirect(array('action' => 'index'));
	}
	function verPresupuesto($id){
		$proyecto=$this->Subproyecto->read("presupuesto_path",$id);
		$partes=explode("/",$proyecto["Subproyecto"]["presupuesto_path"]);
		$nombrePartido=explode(".",$partes[2]);
		$this -> viewClass = 'Media';
		$params = array(
				'id' => $partes[2],
				'name' => $nombrePartido[0],
				'download' => true,
				'extension' => $nombrePartido[1],
				'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document","dotx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.template","pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation","ppsx"=>"application/vnd.openxmlformats-officedocument.presentationml.slideshow","potx"=>"application/vnd.openxmlformats-officedocument.presentationml.template","xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","xltx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.template"),
				'path' => $partes[1] . DS
		);
		$this -> set($params);
	}
	function verCronograma($id){
		$proyecto=$this->Subproyecto->read("cronograma_path",$id);
		$partes=explode("/",$proyecto["Subproyecto"]["cronograma_path"]);
		$nombrePartido=explode(".",$partes[2]);
		$this -> viewClass = 'Media';
		$params = array(
				'id' => $partes[2],
				'name' => $nombrePartido[0],
				'download' => true,
				'extension' => $nombrePartido[1],
				'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document","dotx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.template","pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation","ppsx"=>"application/vnd.openxmlformats-officedocument.presentationml.slideshow","potx"=>"application/vnd.openxmlformats-officedocument.presentationml.template","xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","xltx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.template"),
				'path' => $partes[1] . DS
		);
		$this->set($params);
	}
	function admin_verPresupuesto($id){
		$proyecto=$this->Subproyecto->read("presupuesto_path",$id);
		$partes=explode("/",$proyecto["Subproyecto"]["presupuesto_path"]);
		$nombrePartido=explode(".",$partes[2]);
		$this -> viewClass = 'Media';
		$params = array(
				'id' => $partes[2],
				'name' => $nombrePartido[0],
				'download' => true,
				'extension' => $nombrePartido[1],
				'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document","dotx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.template","pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation","ppsx"=>"application/vnd.openxmlformats-officedocument.presentationml.slideshow","potx"=>"application/vnd.openxmlformats-officedocument.presentationml.template","xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","xltx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.template"),
				'path' => $partes[1] . DS
		);
		$this -> set($params);
	}
	function admin_verCronograma($id){
		$proyecto=$this->Subproyecto->read("cronograma_path",$id);
		$partes=explode("/",$proyecto["Subproyecto"]["cronograma_path"]);
		$nombrePartido=explode(".",$partes[2]);
		$this -> viewClass = 'Media';
		$params = array(
				'id' => $partes[2],
				'name' => $nombrePartido[0],
				'download' => true,
				'extension' => $nombrePartido[1],
				'mimeType' => array('docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document","dotx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.template","pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation","ppsx"=>"application/vnd.openxmlformats-officedocument.presentationml.slideshow","potx"=>"application/vnd.openxmlformats-officedocument.presentationml.template","xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","xltx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.template"),
				'path' => $partes[1] . DS
		);
		$this->set($params);
	}
	function enviarCorreo($proyectoId,$mail_body){
		$proyecto = $this -> Subproyecto -> Proyecto -> read(null,$proyectoId);
		foreach($proyecto["Correo"] as $correo) {
			$Name = "OMEGA INGENIEROS"; //senders name
			$email = "email@adress.com"; //senders e-mail adress
			$recipient = $correo["correo"]; //recipient
			$subject = "Se ha cambiado el estado del proyecto: ".$proyecto["Proyecto"]["nombre"]; //subject
			$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
			//mail($recipient, $subject, $mail_body, $header);
			$this -> sendbySMTP($correo["nombre"],$correo["correo"],$subject,$mail_body);
		}
		return true;
	}
	
}