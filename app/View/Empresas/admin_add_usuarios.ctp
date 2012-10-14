<div class="clientes form">
<?php echo $this -> Form -> create('Empresa'); ?>

	<fieldset>
 		<legend>Añadir Cuenta De Usuario</legend>
	
	<?php
		//echo $this -> Form -> input('Usuario.role', array('options' => array('clienteMantenimiento' => "Mantenimiento", 'clienteProyecto' => "Proyecto")));
		echo $this -> Form -> input('Usuario.nombre', array());
		echo $this -> Form -> input('Usuario.apellido', array());
		echo $this -> Form -> input('Usuario.correo', array());
		echo $this -> Form -> input('Usuario.nombre_de_usuario', array());
		echo $this -> Form -> input('Usuario.contraseña', array('type' => 'password'));
		echo $this -> Form -> input('Usuario.verificar_contraseña', array('type' => 'password'));
		echo $this -> Form -> input('Usuario.servicios', array('multiple' => 'checkbox'));
		//echo $this -> Form -> input('Usuario.empresa_id', array('type' => 'hidden', 'value' => $empresaId));
		echo $this -> Form -> input('Email.body', array('label' => 'Mensaje Personalizado Para El Correo', 'type' => 'textarea'));
	?>
	</fieldset>
	
<?php echo $this -> Form -> end(__('Guardar', true)); ?>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Listar Empresas', true), array('action' => 'index')); ?></li>
	</ul>
</div>