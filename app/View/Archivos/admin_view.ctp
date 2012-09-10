<div class="archivos view">
<h2><?php echo __('Archivo'); ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $archivo['Archivo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Path'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $archivo['Archivo']['ruta']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Equipo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($archivo['Equipo']['nombre'], array('controller' => 'equipos', 'action' => 'view', $archivo['Equipo']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Archivo'), array('action' => 'edit', $archivo['Archivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Archivo'), array('action' => 'delete', $archivo['Archivo']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $archivo['Archivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Archivos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Archivo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
