<div class="solicitudProyectos form">
<?php echo $this->Form->create('SolicitudProyecto');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Solicitud Proyecto', true)); ?></legend>
	<?php
		echo $this->Form->input('proyecto_id');
		echo $this->Form->input('texto_solicitud');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Solicitud Proyectos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
	</ul>
</div>