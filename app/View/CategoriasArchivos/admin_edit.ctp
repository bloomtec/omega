<div class="categoriasArchivos form">
<?php echo $this->Form->create('CategoriasArchivo'); ?>
	<fieldset>
		<legend><?php echo __('Modificar Categoría Archivo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Modificar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index')); ?></li>
	</ul>
</div>
