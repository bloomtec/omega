<?php
App::uses('AppModel', 'Model');
/**
 * Archivo Model
 *
 * @property CategoriasArchivo $CategoriasArchivo
 */
class Archivo extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'ruta';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'modelo' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'llave_foranea' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ruta' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
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
		'CategoriasArchivo' => array(
			'className' => 'CategoriasArchivo',
			'foreignKey' => 'categorias_archivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Proyecto' => array(
			'className' => 'Proyecto',
			'foreignKey' => 'llave_foranea',
			'conditions' => array('Archivo.modelo' => 'Proyecto'),
			'fields' => '',
			'order' => ''
		),
		'Equipo' => array(
			'className' => 'Equipo',
			'foreignKey' => 'llave_foranea',
			'conditions' => array('Archivo.modelo' => 'Equipo'),
			'fields' => '',
			'order' => ''
		)
	);
}
