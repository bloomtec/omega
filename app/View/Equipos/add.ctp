<div class="equipos form">
<?php echo $this->Form->create('Equipo');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Equipo', true)); ?></legend>
	<?php
		echo $this->Form->input('referencia');
		echo $this->Form->input('descripcion');
		echo $this->Form->input('ficha_tecnica');
		echo $this->Form->input('proxima_revision');
		echo $this->Form->input('mensajes_pendientes');
		echo $this->Form->input('Contrato');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Equipos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Archivos', true)), array('controller' => 'archivos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Archivo', true)), array('controller' => 'archivos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Contratos', true)), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Contrato', true)), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>