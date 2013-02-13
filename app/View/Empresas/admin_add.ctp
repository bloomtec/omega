<div class="clientes form">
	<?php echo $this -> Form -> create('Empresa'); ?>
	<fieldset>
 		<legend><?php echo __('Crear Empresa'); ?></legend>
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
	<div class="actions" style="display: inherit;">
		<ul>
			<li><?php echo $this -> Html -> link(__('Listar Empresas', true), array('action' => 'index')); ?></li>	
		</ul>
	</div>
</div>