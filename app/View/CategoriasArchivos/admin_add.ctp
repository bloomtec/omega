<div class="categoriasArchivos form">
<?php echo $this->Form->create('CategoriasArchivo'); ?>
	<fieldset>
		<legend><?php echo __('Agregar Categoría Archivo'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Agregar')); ?>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index')); ?></li>
	</ul>
</div>
