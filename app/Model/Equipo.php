<?php
App::uses('AppModel', 'Model');
/**
 * Equipo Model
 *
 * @property CategoriasEquipo $CategoriasEquipo
 * @property Contrato $Contrato
 */
class Equipo extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'codigo';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'codigo' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese el código del equipo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isunique' => array(
				'rule' => array('isunique'),
				'message' => 'El código ingresado ya está registrado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'CategoriasEquipo' => array(
			'className' => 'CategoriasEquipo',
			'foreignKey' => 'categorias_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'Archivo' => array(
			'className' => 'Archivo',
			'foreignKey' => 'llave_foranea',
			'dependent' => false,
			'conditions' => array('Archivo.modelo' => 'Equipo'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Alarma' => array(
			'className' => 'Alarma',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Alarma.modelo' => 'Equipo'),
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
		'Contrato' => array(
			'className' => 'Contrato',
			'joinTable' => 'contratos_equipos',
			'foreignKey' => 'equipo_id',
			'associationForeignKey' => 'contrato_id',
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

}
