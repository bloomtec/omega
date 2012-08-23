<div class="empresas index">
	<h2><?php echo __('Empresas'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('identificacion'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('contacto'); ?></th>
			<th><?php echo $this->Paginator->sort('telefono'); ?></th>
			<th><?php echo $this->Paginator->sort('tiene_alerta'); ?></th>
			<th><?php echo $this->Paginator->sort('tiene_publicacion_empresa'); ?></th>
			<th><?php echo $this->Paginator->sort('tiene_publicacion_omega'); ?></th>
			<th><?php echo $this->Paginator->sort('tiene_solicitud'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($empresas as $empresa): ?>
	<tr>
		<td><?php echo h($empresa['Empresa']['id']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['identificacion']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['email']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['contacto']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['telefono']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['tiene_alerta']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['tiene_publicacion_empresa']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['tiene_publicacion_omega']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['tiene_solicitud']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['created']); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $empresa['Empresa']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $empresa['Empresa']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $empresa['Empresa']['id']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Empresa'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
