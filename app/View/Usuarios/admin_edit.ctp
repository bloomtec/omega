<div class="usuarios form">
<?php echo $this -> Form -> create('Usuario'); ?>
	<fieldset>
 		<legend><?php echo __('Modificar Usuario'); ?></legend>
	<?php
	echo $this -> Form -> input('id');
	echo $this -> Form -> input('nombre');
	echo $this -> Form -> input('apellido');
	echo $this -> Form -> input('nombre_de_usuario');
	echo $this -> Form -> input('correo');
	echo $this -> Form -> input('contraseña', array('type' => 'password', 'value' => ''));
	echo $this -> Form -> input('verificar_contraseña', array('type' => 'password', 'value' => ''));
	if($this -> request -> data['Usuario']['rol_id'] != 3) {
		echo $this -> Form -> input('rol_id', array('empty' => 'Seleccione...'));
	} else {
		echo $this -> Form -> hidden('rol_id');
		echo $this -> Form -> input('servicios', array('multiple' => 'checkbox', 'selected' => $servicios_visibles));
	}
	?>
	</fieldset>
<?php echo $this -> Form -> end(__('Guardar', true)); ?>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Listar Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nueva Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>