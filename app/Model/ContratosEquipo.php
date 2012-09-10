<?php
App::uses('AppModel', 'Model');
/**
 * ContratosEquipo Model
 *
 * @property Contrato $Contrato
 * @property Equipo $Equipo
 * @property Fase $Fase
 * @property Evento $Evento
 */
class ContratosEquipo extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'id';
	
	public function getLast($usuarioId, $equipoId) {
		return $this -> find(
			"first",
			array(
				"conditions" => array(
					"RevisionEquipo.equipo_id" => $equipoId,
					"RevisionEquipo.usuario_id" => $usuarioId
				),
				"order" => array(
					"RevisionEquipo.id" => "DESC"
				)
			)
		);
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Equipo' => array(
			'className' => 'Equipo',
			'foreignKey' => 'equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fase' => array(
			'className' => 'Fase',
			'foreignKey' => 'fase_id',
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
		'RevisionContratosEquipo' => array(
			'className' => 'RevisionContratosEquipo',
			'foreignKey' => 'contratos_equipo_id',
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
		'Evento' => array(
			'className' => 'Evento',
			'foreignKey' => 'contratos_equipo_id',
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
		'Observacion' => array(
			'className' => 'Observacion',
			'foreignKey' => 'llave_foranea',
			'dependent' => true,
			'conditions' => array('Observacion.modelo' => 'ContratosEquipo'),
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
