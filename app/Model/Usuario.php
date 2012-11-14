<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Component');
/**
 * Usuario Model
 *
 * @property Empresa $Empresa
 * @property Rol $Rol
 * @property Servicio $Servicio
 */
class Usuario extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre_de_usuario';
	
	public $virtualFields = array(
		'rol' => 'SELECT nombre FROM roles WHERE roles.id = Usuario.rol_id'
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'rol_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe seleccionar un rol de usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Este campo es numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nombre_de_usuario' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar un nombre de usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isunique' => array(
				'rule' => array('isunique'),
				'message' => 'Este nombre de usuario ya esta registrado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contraseña' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar una contraseña',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'esIgualLaContraseña' => array(
				'rule' => array('esIgualLaContraseña'),
				'message' => 'No coincide con la verificación de la contraseña',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'verificar_contraseña' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe verificar su contraseña',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'esIgualLaContraseña' => array(
				'rule' => array('esIgualLaContraseña'),
				'message' => 'No coincide con la contraseña',
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
		'apellido' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar un apellido',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'correo' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar su correo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isunique' => array(
				'rule' => array('isunique'),
				'message' => 'Este correo ya esta registrado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'primer_login' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'activo' => array(
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
	
	public function esIgualLaContraseña() {
		if($this -> data['Usuario']['contraseña'] === $this -> data['Usuario']['verificar_contraseña']) {
			return true;
		} else {
			return false;
		}
	}
	
	public function beforeSave($options = array()) {
		if(isset($this -> data['Usuario']['contraseña']) && !empty($this -> data['Usuario']['contraseña'])) {
			$this -> data['Usuario']['contraseña'] = AuthComponent::password($this -> data['Usuario']['contraseña']);
		}
		return true;
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
		'Rol' => array(
			'className' => 'Rol',
			'foreignKey' => 'rol_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Servicio' => array(
			'className' => 'Servicio',
			'joinTable' => 'servicios_usuarios',
			'foreignKey' => 'usuario_id',
			'associationForeignKey' => 'servicio_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Observacion' => array(
			'className' => 'Observacion',
			'foreignKey' => 'llave_foranea',
			'dependent' => false,
			'conditions' => array('Observacion.modelo' => 'Usuario'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RevisionContratosEquipo' => array(
			'className' => 'RevisionContratosEquipo',
			'foreignKey' => 'usuario_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
