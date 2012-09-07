<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		// Contener las relaciones
		$Class = $this -> modelClass;
		$this -> $Class -> contain();
		// Manejo de la parte de autentificación
		$this -> authConfig();
		//$this -> layoutConfig();
	}
	
	protected function authConfig() {
		$this -> Auth -> deny();
		$this -> Auth -> authorize = 'Controller';
		$this -> Auth -> authenticate = array('Form' => array('scope' => array('activo' => 1), 'userModel' => 'Usuario', 'fields' => array('username' => 'nombre_de_usuario', 'password' => 'contraseña')));
		$this -> Auth -> authError = 'No tiene permiso para ver esta sección';
		if (!isset($this -> params['prefix'])) {
			$this -> Auth -> loginAction = array('controller' => 'usuarios', 'action' => 'login', 'admin' => false);
			$this -> Auth -> loginRedirect = array('controller' => 'usuarios', 'action' => 'index', 'admin' => false);
			$this -> Auth -> logoutRedirect = array('controller' => 'usuarios', 'action' => 'login', 'admin' => false);
		} elseif ($this -> params['prefix'] == 'admin') {
			$this -> Auth -> loginAction = array('controller' => 'usuarios', 'action' => 'login', 'admin' => true);
			$this -> Auth -> loginRedirect = array('controller' => 'usuarios', 'action' => 'index', 'admin' => true);
			$this -> Auth -> logoutRedirect = array('controller' => 'usuarios', 'action' => 'login', 'admin' => true);
		}
	}
	
	public function isAuthorized() {
		// Contexto clientes (Clientes[3])
		if (!isset($this -> params['prefix']) && $this -> Auth -> user('rol_id') != 2) {
			return true;
		}
		// Contexto omega (Super Administrador[1] y Administrador[2])
		elseif ($this -> params['prefix'] == 'admin' && $this -> Auth -> user('rol_id') <= 2) {
			return true;
		} else {
			return false;
		}
	}

	protected function layoutConfig() {
		if (isset($this -> params['prefix']) && $this -> params['prefix'] == 'admin') {
			//$this -> layout = ''; // Entorno "/"
		} else {
			//$this -> layout = ''; // Entorno "/admin"
		}
	}
	
}
