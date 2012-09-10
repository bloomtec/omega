<div class="equipos form">
<?php echo $this -> Form -> create('Equipo'); ?>
	<fieldset>
 		<legend><?php echo __('Añadir Equipo'); ?> al contrato <?php echo $contratos[$contratoId]; ?></legend>
	<?php
	echo $this -> Form -> input('categorias_equipo_id', array('empty' => 'Seleccione...'));
	//echo $this -> Form -> input('referencia');
	echo $this -> Form -> input('codigo', array('label' => 'Código'));
	echo $this -> Form -> input('descripcion', array('label' => 'Descripción'));
	//echo $this->Form->input('ficha_tecnica');
	//echo $this->Form->input('proxima_revision');
	//echo $this->Form->input('mensajes_pendientes');
	echo $this -> Form -> input('Contrato.Contrato.0', array("type" => "hidden", "value" => $contratoId));
	?>
	</fieldset>
<?php echo $this -> Form -> end('Guardar'); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Volver'), array('controller' => 'contratos', 'action' => 'view', $contratoId)); ?></li>		
	</ul>
</div>