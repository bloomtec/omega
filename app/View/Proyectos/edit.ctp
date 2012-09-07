<div class="proyectos form">
<?php echo $this->Form->create('Proyecto');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Proyecto', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('cliente_id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('centro_de_costo');
		echo $this->Form->input('descripcion');
		echo $this->Form->input('ficha_tecnica');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Proyecto.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Proyecto.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Clientes', true)), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Cliente', true)), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Comentario Privados', true)), array('controller' => 'comentario_privados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Comentario Privado', true)), array('controller' => 'comentario_privados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Comentario Publicos', true)), array('controller' => 'comentario_publicos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Comentario Publico', true)), array('controller' => 'comentario_publicos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Emails', true)), array('controller' => 'emails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Email', true)), array('controller' => 'emails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Subproyectos', true)), array('controller' => 'subproyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Subproyecto', true)), array('controller' => 'subproyectos', 'action' => 'add')); ?> </li>
	</ul>
</div>