<div class="categoriasEquipos form">
<?php echo $this->Form->create('CategoriasEquipo'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Categorias Equipo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('empresa_id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CategoriasEquipo.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CategoriasEquipo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Categorias Equipos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
