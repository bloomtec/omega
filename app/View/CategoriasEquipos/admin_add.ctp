<div class="categoriasEquipos form">
<?php echo $this -> Form -> create('CategoriasEquipo'); ?>
	<fieldset>
		<legend><?php echo __('Agregar Categoría Equipo'); ?></legend>
	<?php
	echo $this -> Form -> input('empresa_id');
	echo $this -> Form -> input('nombre');
	?>
	</fieldset>
<?php echo $this -> Form -> end(__('Crear Categoria')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Volver'), array('controller' => 'contratos', 'action' => 'view', $contrato_id)); ?> </li>
	</ul>
</div>
