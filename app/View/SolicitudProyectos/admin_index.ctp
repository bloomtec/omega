<div class="solicitudProyectos index">
	<h2><?php __('Solicitud Proyectos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('proyecto_id');?></th>
			<th><?php echo $this->Paginator->sort('texto_solicitud');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($solicitudProyectos as $solicitudProyecto):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $solicitudProyecto['SolicitudProyecto']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($solicitudProyecto['Proyecto']['nombre'], array('controller' => 'proyectos', 'action' => 'view', $solicitudProyecto['Proyecto']['id'])); ?>
		</td>
		<td><?php echo $solicitudProyecto['SolicitudProyecto']['texto_solicitud']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $solicitudProyecto['SolicitudProyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $solicitudProyecto['SolicitudProyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $solicitudProyecto['SolicitudProyecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $solicitudProyecto['SolicitudProyecto']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Solicitud Proyecto', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
	</ul>
</div>