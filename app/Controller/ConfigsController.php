<?php
App::uses('AppController', 'Controller');
/**
 * Configs Controller
 *
 * @property Config $Config
 */
class ConfigsController extends AppController {
	
	protected $exclusiveActions = array('admin_edit', 'admin_restore');
	
	private $horas = array(
		'00:30' => '00:30',
		'01:30' => '01:30',
		'02:30' => '02:30',
		'03:30' => '03:30',
		'04:30' => '04:30',
		'05:30' => '05:30',
		'06:30' => '06:30',
		'07:30' => '07:30',
		'08:30' => '08:30',
		'09:30' => '09:30',
		'10:30' => '10:30',
		'11:30' => '11:30',
		'12:30' => '12:30',
		'13:30' => '13:30',
		'14:30' => '14:30',
		'15:30' => '15:30',
		'16:30' => '16:30',
		'17:30' => '17:30',
		'18:30' => '18:30',
		'19:30' => '19:30',
		'20:30' => '20:30',
		'21:30' => '21:30',
		'22:30' => '22:30',
		'23:30' => '23:30',
	);

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit() {
		$id = 1;
		$this -> Config -> id = $id;
		if (!$this -> Config -> exists()) {
			throw new NotFoundException(__('Invalid config'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			$backup = $this -> request -> data['Config'];
			unset($backup['id']);
			unset($backup['backup']);
			$backup = json_encode($backup);
			$this -> request -> data['Config']['backup'] = $backup;
			if ($this -> Config -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('Se ha modificado la configuración del backup.'));
			} else {
				$this -> Session -> setFlash(__('No se pudo modificar la configuración del backup. Por favor, intente de nuevo.'));
			}
		} else {
			$this -> request -> data = $this -> Config -> read(null, $id);
			$backup = json_decode($this -> request -> data['Config']['backup']);
			foreach($backup as $key => $value) {
				$this -> request -> data['Config'][$key] = $value;
			}
		}
		$this -> set('horas', $this -> horas);
		$this -> set('archivos', $this -> paginate());
	}
	
	public function admin_restore($filename) {
		// Obtener datos de la conexión a la BD
		App::import('Core', 'ConnectionManager');
		$dataSource = ConnectionManager::getDataSource('default');
		$this -> restore($dataSource -> config['login'], $dataSource -> config['password'], $dataSource -> config['database'], $dataSource -> config['host'], $filename);
		$this -> Session -> setFlash(__("Se restauró la base de datos con el archivo :: $filename"));
		$this -> redirect($this -> referer());
	}
	
	private function restore($username, $password, $database, $host, $filename) {
		$file = WWW_ROOT . 'files' . DS . 'clean_db.sql';
		exec("mysql -u $username -p$password --database=$database --host=$host < $file");
		$backup_file = WWW_ROOT . 'files' . DS . 'db_backups' . DS . $filename;
		exec("mysql -u $username -p$password --database=$database --host=$host < $backup_file");
	}

}
