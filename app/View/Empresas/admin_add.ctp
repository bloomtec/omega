<div class="clientes form">
<?php echo $this -> Form -> create('Empresa'); ?>
	<fieldset>
 		<legend><?php echo __('Añadir Empresa'); ?></legend>
	<?php
	echo $this -> Form -> input('nombre', array("label" => "Nombre/Razón Social"));
	echo $this -> Form -> input('identificacion', array("label" => "CC/NIT"));
	echo $this -> Form -> input('contacto');
	echo $this -> Form -> input('telefono', array("label" => "Teléfono"));
	echo $this -> Form -> input('correo');
	echo $this -> Form -> input('servicios', array('multiple' => 'checkbox'));
	?>
	</fieldset>
	
<?php echo $this -> Form -> end(__('Guardar', true)); ?>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Listar Empresas', true), array('action' => 'index')); ?></li>	
	</ul>
</div>