<div class="categoriasEquipos index">
	<h2><?php echo __('Categorias Equipos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('empresa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($categoriasEquipos as $categoriasEquipo): ?>
	<tr>
		<td><?php echo h($categoriasEquipo['CategoriasEquipo']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($categoriasEquipo['Empresa']['nombre'], array('controller' => 'empresas', 'action' => 'view', $categoriasEquipo['Empresa']['id'])); ?>
		</td>
		<td><?php echo h($categoriasEquipo['CategoriasEquipo']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($categoriasEquipo['CategoriasEquipo']['created']); ?>&nbsp;</td>
		<td><?php echo h($categoriasEquipo['CategoriasEquipo']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $categoriasEquipo['CategoriasEquipo']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $categoriasEquipo['CategoriasEquipo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $categoriasEquipo['CategoriasEquipo']['id']), null, __('Are you sure you want to delete # %s?', $categoriasEquipo['CategoriasEquipo']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Categorias Equipo'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
