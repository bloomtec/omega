<?php
App::uses('AppModel', 'Model');
/**
 * RevisionContratosEquipo Model
 *
 * @property Usuario $Usuario
 * @property ContratosEquipo $ContratosEquipo
 */
class RevisionContratosEquipo extends AppModel {
	
	function getLast($usuarioId, $contratoEquipoId) {
		return $this -> find(
			"first",
			array(
				"conditions" => array(
					"RevisionContratosEquipo.contratos_equipo_id" => $contratoEquipoId,
					"RevisionContratosEquipo.usuario_id" => $usuarioId
				),
				"order" => array(
					"RevisionContratosEquipo.id" => "DESC"
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
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContratosEquipo' => array(
			'className' => 'ContratosEquipo',
			'foreignKey' => 'contratos_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
