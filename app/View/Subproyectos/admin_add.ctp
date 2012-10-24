<div>
<?php echo $this -> Form -> create('Subproyecto'); ?>
	<fieldset>
 		<legend><?php echo __('Añadir Sub Proyecto'); ?></legend>
		<?php
		echo $this -> Form -> input('proyecto_id', array("type" => "hidden", "value" => $proyectoId));
		echo $this -> Form -> input('solicitud_proyecto_id', array("type" => "hidden", "value" => $solicitudProyectoId));
		echo $this -> Form -> input('nombre');
		echo $this -> Form -> hidden('presupuesto_path');
		echo $this -> Form -> hidden('cronograma_path');
		?>
		<label style="float:left; margin-right:10px; margin-top:5px;">Presupuesto: </label>
		<div id="presupuesto" path='/files'></div>
		<div class="uploadedPresupuesto"></div>
		<label style="float:left; margin-right:10px; margin-top:5px;">Cronograma: </label>
		<div id="cronograma" path='/files' ></div>
		<div class="uploadedCronograma"></div>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar', true)); ?>
</div>
