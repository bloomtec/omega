<?php
App::uses('AppModel', 'Model');
/**
 * Contrato Model
 *
 * @property Empresa $Empresa
 * @property Tipo $Tipo
 * @property Estado $Estado
 * @property Equipo $Equipo
 */
class Contrato extends AppModel {

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
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'comentarios' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tiene_alerta' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tiene_publicacion_empresa' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tiene_publicacion_omega' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	function afterSave($created) {
		if ($created) {
			/*$alarma["Alarma"]["contrato_id"]=$this->id;
			 $alarma["Alarma"]["texto"]="Contrato Nuevo";
			 $alarma["Alarma"]["para_empresa"]=true;
			 $this->Alarma->create();
			 $this->Alarma->save($alarma);*/
			//$this->crearAlarma($this->id,"contrato nuevo",true);
			$this -> crearAlarma($this -> id, "debe subir la cotización", false);
		}

	}

	function crearAlarma($contratoId, $mensaje, $paraCliente) {
		$existe = $this -> Alarma -> find("first", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.llave_foranea" => $contratoId, "Alarma.texto" => $mensaje)));
		if (!$existe) {
			$this -> recursive = -1;
			$contrato = $this -> read(null, $contratoId);
			$this -> set("tiene_alerta", true);
			$this -> save();
			$alarma['Alarma']['modelo'] = 'Contrato';
			$alarma["Alarma"]["llave_foranea"] = $contratoId;
			$alarma["Alarma"]["texto"] = $mensaje;
			$alarma["Alarma"]["para_empresa"] = $paraCliente;
			$alarma["Alarma"]["empresa_id"] = $contrato["Contrato"]["empresa_id"];
			$this -> Alarma -> create();
			$this -> Alarma -> save($alarma);
			$cliente = $this -> Empresa -> read(null, $contrato["Contrato"]["empresa_id"]);
			$this -> Empresa -> set("tiene_alerta", true);
			$this -> Empresa -> save();
		}
	}

	function eliminarAlarma($contratoId, $texto) {
		$this -> recursive = -1;
		$contrato = $this -> read(null, $contratoId);

		$alarma = $this -> Alarma -> find("first", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.llave_foranea" => $contratoId, "Alarma.texto" => $texto)));

		if ($alarma)
			$this -> Alarma -> delete($alarma["Alarma"]["id"]);

		$alarmasDelContrato = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.llave_foranea" => $contratoId)));
		if ($alarmasDelContrato < 1) {
			$this -> set("tiene_alerta", false);
			$this -> save();
		}
		$alarmasCliente = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.empresa_id" => $contrato["Contrato"]["empresa_id"])));
		if ($alarmasCliente < 1) {
			$cliente = $this -> Empresa -> read(null, $contrato["Contrato"]["empresa_id"]);
			$this -> Empresa -> set("tiene_alerta", false);
			$this -> Empresa -> save();
		}
	}

	function eliminarAlarmaSola($alarmaId) {
		$alarma = $this -> Alarma -> read(null, $alarmaId);
		$contratoId = $alarma["Alarma"]["llave_foranea"];
		$this -> recursive = -1;
		$contrato = $this -> read(null, $contratoId);

		if ($this -> Alarma -> delete($alarma["Alarma"]["id"])) {

			$alarmasDelContrato = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.llave_foranea" => $contratoId)));
			if ($alarmasDelContrato < 1) {
				$this -> set("tiene_alerta", false);
				$this -> save();
			}
			$alarmasCliente = $this -> Alarma -> find("count", array("conditions" => array('Alarma.modelo' => 'Contrato', "Alarma.empresa_id" => $contrato["Contrato"]["empresa_id"])));
			if ($alarmasCliente < 1) {
				$cliente = $this -> Empresa -> read(null, $contrato["Contrato"]["empresa_id"]);
				$this -> Empresa -> set("tiene_alerta", false);
				$this -> Empresa -> save();
			}
			return true;
		} else {
			return false;
		}
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Empresa' => array(
			'className' => 'Empresa',
			'foreignKey' => 'empresa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tipo' => array(
			'className' => 'Tipo',
			'foreignKey' => 'tipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'Alarma' => array(
			'className' => 'Alarma',
			'foreignKey' => 'llave_foranea',
			'dependent' => false,
			'conditions' => array('Alarma.modelo' => 'Contrato'),
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
			'conditions' => array('Correo.modelo' => 'Contrato'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Equipo' => array(
			'className' => 'Equipo',
			'joinTable' => 'contratos_equipos',
			'foreignKey' => 'contrato_id',
			'associationForeignKey' => 'equipo_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'order' => array('ContratosEquipo.tiene_publicacion_omega' => 'desc'),
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
