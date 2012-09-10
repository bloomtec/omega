<div class="archivos form">
	<h2>Por favor Seleccione el Archivo a subir</h2>
	<div>
		<?php echo $this -> Form -> input('categoria_archivo_id', array('empty' => 'Seleccione...', 'options' => $categoriasArchivos)); ?>
	</div>
	<div id="upload" path='/files' message="El Archivo se ha subido con Exito" controller="archivos" action="AJAX_subirArchivo" modelId="<?php echo $equipoId ?>"></div>
	<div class="uploaded"></div>
</div>
