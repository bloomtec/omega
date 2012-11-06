<?php
App::uses('BaseServiciosController', 'Controller');
/**
 * Proyectos Controller
 *
 * @property Proyecto $Proyecto
 */
class CalidadDeAiresController extends BaseServiciosController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		parent::index();
	}

	public function admin_listaCorreo($id) {
		parent::admin_listaCorreo($id);
	}

	public function admin_crearCorreo() {
		parent::admin_crearCorreo();
	}

	public function admin_borrarCorreo($correoId, $proyectoId) {
		parent::admin_borrarCorreo($correoId, $proyectoId);
	}

	public function tieneAlarmaEmpresa($proyecto_id) {
		parent::tieneAlarmaEmpresa($proyecto_id);
	}

	public function admin_view($id = null) {
		parent::admin_view($id);
	}

	public function view($id = null) {
		parent::view($id);
	}

	public function solicitudAdicional($proyectoId = null) {
		parent::solicitudAdicional($proyectoId);
	}

	function isValidEmail($email) {
		parent::isValidEmail($email);
	}

	public function admin_add($id = null) {
		parent::admin_add($id, 2);
	}

	public function admin_add2($id = null) {
		parent::admin_add2($id);
	}

	public function admin_edit($id = null) {
		parent::admin_edit($id);
	}

	public function admin_delete($id = null) {
		parent::admin_delete($id);
	}

	public function admin_verCronograma($id) {
		parent::admin_verCronograma($id);
	}

	public function admin_verControlEjecucion($id) {
		parent::admin_verControlEjecucion($id);
	}

	public function verControlEjecucion($id) {
		parent::verControlEjecucion($id);
	}

	public function verCronograma($id) {
		parent::verCronograma($id);
	}

	public function admin_verCotizacion($id) {
		parent::admin_verCotizacion($id);
	}

	public function verCotizacion($id) {
		parent::verCotizacion($id);
	}

	public function admin_subirCotizacion() {
		parent::admin_subirCotizacion();
	}

	public function admin_comentarios($id) {
		parent::admin_comentarios($id);
	}

	public function aprobarCotizacion($id) {
		parent::aprobarCotizacion($id);
	}

	public function confirmarAprobacion() {
		parent::confirmarAprobacion();
	}

	public function rechazarCotizacion($id) {
		parent::rechazarCotizacion($id);
	}

	public function confirmarRechazo() {
		parent::confirmarRechazo();
	}

	public function admin_anularCotizacion($id) {
		parent::admin_anularCotizacion($id);
	}

	public function admin_confirmarAnulacion() {
		parent::admin_confirmarAnulacion();
	}

	public function admin_ingresarCc($id = null) {
		parent::admin_ingresarCc($id);
	}

	public function solicitarProyecto($empresaId = null) {
		parent::solicitarProyecto($empresaId);
	}

	public function sendToOmegaProyecto($clienteName, $data) {
		parent::sendToOmegaProyecto($clienteName, $data);
	}

	public function verFicha($id) {
		parent::verFicha($id);
	}

	public function admin_subirFicha() {
		parent::admin_subirFicha();
	}

	public function admin_verFicha($id) {
		parent::admin_verFicha($id);
	}

	public function quitarPulicacionParaOmega() {
		parent::quitarPulicacionParaOmega();
	}

	public function quitarPulicacionParaEmpresa() {
		parent::quitarPulicacionParaCliente();
	}

	public function enviarCorreo($proyectoId, $mail_body) {
		parent::enviarCorreo($proyectoId, $mail_body);
	}
	
	public function AJAX_eliminarAlarma() {
		parent::AJAX_eliminarAlarma();
	}
	
	public function AJAX_subirFicha() {
		parent::AJAX_subirFicha();
	}
	
	public function AJAX_guardarDesarrollo() {
		parent::AJAX_guardarDesarrollo();
	}
	
	public function AJAX_cambiarEstado() {
		parent::AJAX_cambiarEstado();
	}
	
	public function AJAX_subirCotizacion() {
		parent::AJAX_subirCotizacion();
	}

}
