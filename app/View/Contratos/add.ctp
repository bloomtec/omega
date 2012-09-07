<div class="contratos form">
<?php echo $this->Form->create('Contrato');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Contrato', true)); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('tipo_id');
		echo $this->Form->input('estado_id');
		echo $this->Form->input('centro_de_costo');
		echo $this->Form->input('fecha_inicio_desarrollo');
		echo $this->Form->input('fecha_finalizado');
		echo $this->Form->input('diagnostico');
		echo $this->Form->input('cotizacion');
		echo $this->Form->input('Equipo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Contratos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tipos', true)), array('controller' => 'tipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Tipo', true)), array('controller' => 'tipos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Estados', true)), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Estado', true)), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Equipos', true)), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>