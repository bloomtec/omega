<div class="proyectos form">
<?php echo $this->Form->create('Proyecto');?>
	<fieldset>
 		<legend><?php printf(__('Cotizar %s', true), __('Proyecto', true)); ?></legend>
	<?php
		echo $this->Form->input('cliente_id',array("type"=>"hidden","value"=>$clienteId));
		echo $this->Form->input('estado_proyecto_id',array("type"=>"hidden","value"=>1));
		
		echo $this->Form->input('nombre');
		//echo $this->Form->input('centro_de_costo');
		echo $this->Form->input('descripcion');
	
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar', true));?>
</div>
