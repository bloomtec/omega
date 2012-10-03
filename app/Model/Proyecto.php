<?php
App::uses('AppModel', 'Model');
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
	
	function afterSave($created) {
		if ($created) {
			/*$alarma["Alarma"]["proyecto_id"]=$this->id;
			 $alarma["Alarma"]["texto"]="Contrato Nuevo";
			 $alarma["Alarma"]["para_empresa"]=true;
			 $this->Alarma->create();
			 $this->Alarma->save($alarma);*/
			//$this->crearAlarma($this->id,"contrato nuevo",true);
			$this -> crearAlarmaProyecto($this -> id, "debe subir la cotización", false);
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
				$this -> read(null, $proyectoId);
				$this -> set("alerta_para_empresa", true);
				$this -> save();
			} else {
				$this -> read(null, $proyectoId);
				$this -> set("alerta_para_omega", true);
				$this -> save();
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
			$this -> read(null, $proyectoId);
			$this -> set("alerta_para_empresa", false);
			$this -> save();
		}
		$alarmasDelProyectoParaOmega = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId, "Alarma.para_empresa" => false)));
		if ($alarmasDelProyectoParaOmega <= 0) {
			$this -> read(null, $proyectoId);
			$this -> set("alerta_para_omega", 0);
			$this -> save();
		}

	}

	function eliminarAlarmaSola($alarmaId) {
		$alarma = $this -> Alarma -> read(null, $alarmaId);
		$proyectoId = $alarma["Alarma"]["llave_foranea"];
		if ($proyectoId) {
			$this -> Alarma -> delete($alarmaId);
			$alarmasDelProyectoParaCliente = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $alarma["Alarma"]["llave_foranea"], "Alarma.para_empresa" => true)));
			if ($alarmasDelProyectoParaCliente <= 0) {
				$this -> read(null, $proyectoId);
				$this -> set("alerta_para_empresa", 0);
				$this -> save();
			}

			$alarmasDelProyectoParaOmega = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Proyecto', "Alarma.llave_foranea" => $proyectoId)));

			if ($alarmasDelProyectoParaOmega == 0) {
				$this -> read(null, $proyectoId);
				$this -> set("alerta_para_omega", 0);
				debug($this -> save());
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
			'dependent' => false,
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
			'dependent' => false,
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
			'dependent' => false,
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
			'dependent' => false,
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
			'dependent' => false,
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
			'dependent' => false,
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
