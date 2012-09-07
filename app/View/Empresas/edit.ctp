<div class="clientes form">
<?php echo $this->Form->create('Cliente');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Cliente', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('apellidos');
		echo $this->Form->input('identificacion');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Cliente.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Cliente.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Clientes', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Usuarios', true)), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Usuario', true)), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Equipos', true)), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>