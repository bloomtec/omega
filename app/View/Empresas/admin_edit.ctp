<div class="clientes form">
<?php echo $this -> Form -> create('Empresa'); ?>
	<fieldset>
 		<legend><?php echo __('Editar Empresa', true); ?></legend>
	<?php
	echo $this -> Form -> input('id');
	echo $this -> Form -> input('nombre', array("label" => "Nombre/Razón Social"));
	echo $this -> Form -> input('identificacion', array("label" => "CC/NIT"));
	echo $this -> Form -> input('contacto');
	echo $this -> Form -> input('telefono', array("label" => "Teléfono"));
	echo $this -> Form -> input('correo');
	echo $this -> Form -> input('servicios', array('multiple' => 'checkbox', 'selected' => $servicios_prestados));
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
		<li><?php echo $this -> Html -> link(__('Listar Empresas', true), array('action' => 'index')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nuevo Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>