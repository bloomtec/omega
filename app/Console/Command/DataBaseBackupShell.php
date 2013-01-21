<?php
/**
 * Database Backup Shell
 */
class DataBaseBackupShell extends AppShell {

	public $uses = array('Config');

	public function main() {
		// Obtener datos de la conexión a la BD
		App::import('Core', 'ConnectionManager');
		$dataSource = ConnectionManager::getDataSource('default');
				
		// Leer la configuración de la base de datos
		$config = $this -> Config -> read(null, 1);
		$backupTime = json_decode($config['Config']['backup']);

		// Proceder a verificar horario asignado
		$week_day = $this -> get_day_number();
		if(
			($this -> check_time($backupTime -> hora))
			&& (
				($backupTime -> lunes && $week_day == 1)
				|| ($backupTime -> martes && $week_day == 2)
				|| ($backupTime -> miercoles && $week_day == 3)
				|| ($backupTime -> jueves && $week_day == 4)
				|| ($backupTime -> viernes && $week_day == 5)
				|| ($backupTime -> sabado && $week_day == 6)
				|| ($backupTime -> domingo && $week_day == 7) 
			)
		) {
			$this -> backup_database($dataSource -> config['login'], $dataSource -> config['password'], $dataSource -> config['database'], $dataSource -> config['host']);
			$this -> out('Se corrió el shell y se realizó el backup.');
		} else {		
			$this -> out('Se corrió el shell pero no se realizó backup alguno.');
		}
	}
	
	/**
	 * Verifica si la hora asignada concuerda con la hora actual
	 * @return true o false acorde si se está o no en la hora configurada
	 */
	private function check_time($time) {
		$now = gmdate('Y-m-d H:i:s', time() + (3600 * -5));
		$now_plus = gmdate('Y-m-d H:i:s', time() + (3600 * -4));
		$configured = date('Y-m-d H:i:s', strtotime($time));
		$_now = strtotime($now);
		$_now_plus = strtotime($now_plus);
		$_configured = strtotime($configured);
		if(($_configured >= $_now) && ($_configured <= $_now_plus)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Retorna el número del día de la semana.
	 * @return El número del día de la semana
	 * 1 - Lunes
	 * 2 - Martes
	 * 3 - Miercoles
	 * 4 - Jueves
	 * 5 - Viernes
	 * 6 - Sabado
	 * 7 - Domingo
	 */
	private function get_day_number() {
		$date = $this -> now();
		return date('N', strtotime(date($date)));
	}

	private function backup_database($username, $password, $database, $host) {
		$filename = $this -> filename();
		exec("mysqldump -u $username -p$password --host=$host --opt $database > $filename");
	}

	/**
	 * Generar la fecha actual formateada para comparar con la fecha de mysql
	 * GMT -5 para hora colombiana
	 */
	private function now() {
		return gmdate('Y-m-d H:i:s', time() + (3600 * -5));
	}

	/**
	 * Generar el nombre de archivo para el backup de la base de datos
	 */
	private function filename() {
		$now = $this -> now();
		$now = str_replace(' ', '_', $now);
		$now = str_replace(':', '-', $now);
		$backup_file = WWW_ROOT . 'files' . DS . 'db_backups' . DS . $now . '.sql';
		return $backup_file;
	}

}
