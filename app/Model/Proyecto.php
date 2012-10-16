<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
/**
 * Proyecto Model
 *
 * @property EstadoProyecto $EstadoProyecto
 * @property Empresa $Empresa
 * @property Subproyecto $Subproyecto
 * @property SolicitudProyecto $SolicitudProyecto
 */
class Proyecto extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'validez' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'debe ser numeŕico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alerta_para_empresa' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'debe ser boolean',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alerta_para_omega' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'debe ser boolean',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar un nombre',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cotizacion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe subir la cotización',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'supervisor' => array(
			'validarEncargadoYSupervisor' => array(
				'rule' => array('validarEncargadoYSupervisor'),
				'message' => 'Debe seleccionar un supervisor si no selecciona un ingeniero',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'encargado' => array(
			'validarEncargadoYSupervisor' => array(
				'rule' => array('validarEncargadoYSupervisor'),
				'message' => 'Debe seleccionar un ingeniero si no selecciona un supervidor',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'comentarios' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'no debe estar vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	);
	
	function validarEncargadoYSupervisor() {
		if(empty($this -> data['Proyecto']['supervisor']) && empty($this -> data['Proyecto']['encargado'])) {
			return false;
		} elseif (!empty($this -> data['Proyecto']['supervisor']) || !empty($this -> data['Proyecto']['encargado'])) {
			return true;
		} else {
			return false;
		}
	}
	
	function afterSave($created) {
		if ($created) {
			/*$alarma["Alarma"]["proyecto_id"]=$this->id;
			 $alarma["Alarma"]["texto"]="Contrato Nuevo";
			 $alarma["Alarma"]["para_empresa"]=true;
			 $this->Alarma->create();
			 $this->Alarma->save($alarma);*/
			//$this->crearAlarma($this->id,"contrato nuevo",true);
			if(empty($this -> data['Proyecto']['cotizacion'])) {
				$this -> crearAlarmaProyecto($this -> id, "debe subir la cotización", false);
			} elseif($created) {
				$this -> crearAlarmaProyecto($this -> id, "proyecto en espera de aprobación", true);
				$this -> crearAlarmaProyecto($this -> id, "en espera de aprobación por el cliente", false);
				
				/*$proyectoId = $this -> id;
				$mail_body = 'Se ha subido la cotización del proyecto: ' . $this -> data['Proyecto']['nombre'];
				$proyecto = $this -> read(null, $proyectoId);
				//$this -> Proyecto -> Empresa -> ClientesUsuario -> bindModel(array("belongsTo" => array("Usuario")));
				//$usuarios = $this -> Proyecto -> Empresa -> ClientesUsuario -> find("all", array("conditions" => array("cliente_id" => $proyecto["Empresa"]["id"])));
				$usuarios = $this -> requestAction('/usuarios/getUsuariosServicio/2');
				$usuarios = $this -> Empresa -> Usuario -> find("all", array("conditions" => array("Usuario.id" => $usuarios, "Usuario.empresa_id" => $proyecto["Proyecto"]["empresa_id"])));
				$empresa = $this -> Empresa -> read(null, $proyecto['Proyecto']['empresa_id']);
				$correoUsuario = "";
				foreach ($usuarios as $usuario) {
					$correoUsuario = $usuario["Usuario"]["correo"];
				}
				$correos = $this -> Correo -> find("all", array("conditions" => array('Correo.modelo' => 'Proyecto', "Correo.llave_foranea" => $proyectoId)));
				$Name = "OMEGA INGENIEROS";
				//senders name
		
				/*$correo = "no-responder@omegaingenieros.com"; //senders e-mail adress
				 $subject = "Nueva actividad en el Proyecto: ".$proyecto["Proyecto"]["nombre"]; //subject
				 $header = "From: ". $Name . " <" . $correo . ">\r\n"; //optional headerfields
				 mail($proyecto["Empresa"]["correo"], $subject, $mail_body, $header);
				 mail($correoUsuario, $subject, $mail_body, $header);*/
				/*$subject = "Nueva actividad en el Proyecto: " . $proyecto["Proyecto"]["nombre"];
				//subject
				$email = new CakeEmail('smtp');
				$email -> emailFormat('html');
				$email -> to($empresa["Empresa"]["correo"]);
				$email -> subject($subject);
				$email -> send($mail_body);
				foreach ($correos as $correo) {
					$email = new CakeEmail('smtp');
					$email -> emailFormat('html');
					$email -> to($correo["Correo"]["correo"]);
					$email -> subject($subject);
					$email -> send($mail_body);
				}*/
			}
		}
	}

	function crearAlarmaProyecto($proyectoId, $mensaje, $paraCliente) {
		$existe = $this -> Alarma -> find("first", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId, "Alarma.texto" => $mensaje)));
		if (!$existe) {
			$alarma["Alarma"]["modelo"] = 'Proyecto';
			$alarma["Alarma"]["llave_foranea"] = $proyectoId;
			$alarma["Alarma"]["texto"] = $mensaje;
			$alarma["Alarma"]["para_empresa"] = $paraCliente;
			$this -> Alarma -> create();
			$this -> Alarma -> save($alarma);
			if ($paraCliente) {
				$this -> id = $proyectoId;
				$this -> saveField("alerta_para_empresa", true);
			} else {
				$this -> id = $proyectoId;
				$this -> saveField("alerta_para_omega", true);
			}
		}
		return true;
	}

	function eliminarAlarmaProyecto($proyectoId, $texto) {
		$alarma = $this -> Alarma -> find("first", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId, "Alarma.texto" => $texto)));

		if ($alarma)
			$this -> Alarma -> delete($alarma["Alarma"]["id"]);
		$alarmasDelProyectoParaCliente = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId, "Alarma.para_empresa" => true)));
		if ($alarmasDelProyectoParaCliente <= 0) {
			$this -> id = $proyectoId;
			$this -> saveField("alerta_para_empresa", false);
		}
		$alarmasDelProyectoParaOmega = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId, "Alarma.para_empresa" => false)));
		if ($alarmasDelProyectoParaOmega <= 0) {
			$this -> id = $proyectoId;
			$this -> saveField("alerta_para_omega", 0);
		}

	}

	function eliminarAlarmaSola($alarmaId) {
		$alarma = $this -> Alarma -> read(null, $alarmaId);
		$proyectoId = $alarma["Alarma"]["llave_foranea"];
		if ($proyectoId) {
			$this -> Alarma -> delete($alarmaId);
			$alarmasDelProyectoParaCliente = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $alarma["Alarma"]["llave_foranea"], "Alarma.para_empresa" => true)));
			if ($alarmasDelProyectoParaCliente <= 0) {
				$this -> id = $proyectoId;
				$this -> saveField("alerta_para_empresa", 0);
			}

			$alarmasDelProyectoParaOmega = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId)));

			if ($alarmasDelProyectoParaOmega == 0) {
				$this -> id = $proyectoId;
				$this -> saveField("alerta_para_omega", 0);
			}

			return $alarmasDelProyectoParaOmega;
		} else {
			return true;
		}

	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'EstadoProyecto' => array(
			'className' => 'EstadoProyecto',
			'foreignKey' => 'estado_proyecto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'foreignKey' => 'empresa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Alarma' => array(
			'className' => 'Alarma',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Alarma.modelo' => 'Proyecto'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Observacion' => array(
			'className' => 'Observacion',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Observacion.modelo' => 'Proyecto'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Correo' => array(
			'className' => 'Correo',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Correo.modelo' => 'Proyecto'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Subproyecto' => array(
			'className' => 'Subproyecto',
			'foreignKey' => 'proyecto_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SolicitudProyecto' => array(
			'className' => 'SolicitudProyecto',
			'foreignKey' => 'proyecto_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Archivo' => array(
			'className' => 'Archivo',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Archivo.modelo' => 'Proyecto'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}
