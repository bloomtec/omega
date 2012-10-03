<div class="subproyectos index">
	<h2><?php __('Subproyectos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('proyecto_id');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('presupuesto_path');?></th>
			<th><?php echo $this->Paginator->sort('cronograma_path');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($subproyectos as $subproyecto):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $subproyecto['Subproyecto']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($subproyecto['Proyecto']['nombre'], array('controller' => 'proyectos', 'action' => 'view', $subproyecto['Proyecto']['id'])); ?>
		</td>
		<td><?php echo $subproyecto['Subproyecto']['nombre']; ?>&nbsp;</td>
		<td><?php echo $subproyecto['Subproyecto']['presupuesto_path']; ?>&nbsp;</td>
		<td><?php echo $subproyecto['Subproyecto']['cronograma_path']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $subproyecto['Subproyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $subproyecto['Subproyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $subproyecto['Subproyecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subproyecto['Subproyecto']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Subproyecto', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
	</ul>
</div>