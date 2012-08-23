<div class="empresas form">
<?php echo $this->Form->create('Empresa'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Empresa'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('identificacion');
		echo $this->Form->input('email');
		echo $this->Form->input('contacto');
		echo $this->Form->input('telefono');
		echo $this->Form->input('tiene_alerta');
		echo $this->Form->input('tiene_publicacion_empresa');
		echo $this->Form->input('tiene_publicacion_omega');
		echo $this->Form->input('tiene_solicitud');
		echo $this->Form->input('Servicio');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Empresa.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Empresa.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
