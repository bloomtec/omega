<?php
App::uses('AppModel', 'Model');
/**
 * Solicitud Model
 *
 * @property Empresa $Empresa
 */
class Solicitud extends AppModel {
	
	public $useTable = "solicitudes";

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
		)
	);
}
