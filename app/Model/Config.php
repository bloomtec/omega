<?php
App::uses('AppModel', 'Model');
/**
 * Config Model
 *
 */
class Config extends AppModel {

	public function paginate($object = null, $scope = array(), $whitelist = array()) {
		$files = $this -> backup_list();
		return $files['Archivo'];
	}

	public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$files = $this -> backup_list();
		return count($files['Archivo']);
	}

	private function backup_list() {
		$path = WWW_ROOT . 'files' . DS . 'db_backups';
		$files = array('Archivo' => array());
		if ($handle = opendir($path)) {
			while (false !== ($entry = readdir($handle))) {
				$files['Archivo'][] = array('filename' => $entry);
			}
			closedir($handle);
		}
		foreach ($files['Archivo'] as $key => $file) {
			if ($file['filename'] == '.' || $file['filename'] == '..' || $file['filename'] == 'empty') {
				unset($files['Archivo'][$key]);
			} else {
				$hora = explode('.', $file['filename']);
				$hora = $hora[0];
				$hora = str_replace('_', ' ', $hora);
				$hora = explode(' ', $hora);
				$hora[1] = str_replace('-', ':', $hora[1]);
				$hora = $hora[0] . ' ' . $hora[1];
				$files['Archivo'][$key]['created'] = $hora;
			}
		}
		sort($files['Archivo']);
		return $files;
	}

}
