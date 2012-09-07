<div class="proyectos index">
	<h2><?php __('Proyectos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('cliente_id');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('centro_de_costo');?></th>
			<th><?php echo $this->Paginator->sort('descripcion');?></th>
			<th><?php echo $this->Paginator->sort('ficha_tecnica');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($proyectos as $proyecto):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $proyecto['Proyecto']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($proyecto['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $proyecto['Cliente']['id'])); ?>
		</td>
		<td><?php echo $proyecto['Proyecto']['nombre']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['centro_de_costo']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['descripcion']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['ficha_tecnica']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $proyecto['Proyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $proyecto['Proyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $proyecto['Proyecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proyecto['Proyecto']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('action' => 'add')); ?></li>
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