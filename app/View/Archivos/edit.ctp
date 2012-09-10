<div class="archivos form">
<?php echo $this->Form->create('Archivo');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Archivo', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('path');
		echo $this->Form->input('equipo_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Archivo.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Archivo.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Archivos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Equipos', true)), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>