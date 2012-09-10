<div class=index>
	<h2>Por favor Seleccione el Archivo a subir</h2>
	<div id="upload" path='/files' message="El Archivo se ha subido con Exito" controller="archivoProyectos" action="AJAX_subirArchivo" modelId="<?php echo $proyectoId ?>"></div>
	<div class="uploaded"></div>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Listar Archivos'), array('action' => 'index', $proyectoId)); ?></li>
	</ul>
</div>