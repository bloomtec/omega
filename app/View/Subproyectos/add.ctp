<div class="subproyectos form">
<?php echo $this->Form->create('Subproyecto');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Subproyecto', true)); ?></legend>
	<?php
		echo $this->Form->input('proyecto_id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('presupuesto_path');
		echo $this->Form->input('cronograma_path');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Subproyectos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
	</ul>
</div>