<?php
App::uses('AppModel', 'Model');
/**
 * Evento Model
 *
 * @property ContratosEquipo $ContratosEquipo
 */
class Evento extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'texto';
	
	public $validate = array(
		'texto' => array(
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
		'ContratosEquipo' => array(
			'className' => 'ContratosEquipo',
			'foreignKey' => 'contratos_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
