<div class="proyectos form">
<?php echo $this -> Form -> create('Proyecto'); ?>
	<fieldset>
 		<legend><?php echo __('Creación De Proyecto'); ?></legend>
	<?php
	echo $this -> Form -> input('empresa_id', array("type" => "hidden", "value" => $empresaId));
	echo $this -> Form -> input('estado_proyecto_id', array("type" => "hidden", "value" => 1));
	echo $this -> Form -> input('nombre');
	//echo $this->Form->input('centro_de_costo');
	echo $this -> Form -> input('fecha_de_entrega');
	echo $this -> Form -> input('fecha_de_inicio');
	$usuarios = $this -> requestAction("/usuarios/getOmega");
	echo $this -> Form -> input('supervisor', array("type" => "select", "options" => $usuarios));
	echo $this -> Form -> input('encargado', array("type" => "select", "options" => $usuarios, "label" => "Ingeniero"));
	echo $this -> Form -> input('descripcion', array("label" => "Descripción"));
	?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar', true)); ?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>		
		<li><?php echo $this -> Html -> link("Volver", array('controller' => 'empresas', 'action' => 'view', $empresaId)); ?> </li>
	</ul>
</div>