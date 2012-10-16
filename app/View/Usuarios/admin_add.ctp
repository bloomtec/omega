<div class="usuarios form">
<?php echo $this -> Form -> create('Usuario'); ?>
	<fieldset>
 		<legend><?php echo __('Agregar Usuario'); ?></legend>
	<?php
	echo $this -> Form -> input('nombre');
	echo $this -> Form -> input('apellido');
	echo $this -> Form -> input('nombre_de_usuario');
	echo $this -> Form -> input('correo');
	echo $this -> Form -> input('contraseña', array('type' => 'password'));
	echo $this -> Form -> input('verificar_contraseña', array('type' => 'password'));
	echo $this -> Form -> input('rol_id', array('empty' => 'Seleccione...'));
	?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar', true)); ?>
	<div class="actions">
		<!--<h3><?php echo __('Acciones'); ?></h3>-->
		<ul>		
			<li>
				<?php
					//echo $this -> Html -> link("Volver", array('controller' => 'empresas', 'action' => 'view', $empresaId));
				?>
				<a href="<?php echo $referer; ?>">Volver</a>
			</li>
		</ul>
	</div>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Listar Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nueva Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>		
	</ul>
</div>