<div class="equipos index">
	<h2><?php __('Equipos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('referencia');?></th>
			<th><?php echo $this->Paginator->sort('descripcion');?></th>
			<th><?php echo $this->Paginator->sort('ficha_tecnica');?></th>
			<th><?php echo $this->Paginator->sort('proxima_revision');?></th>
			<th><?php echo $this->Paginator->sort('mensajes_pendientes');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($equipos as $equipo):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $equipo['Equipo']['id']; ?>&nbsp;</td>
		<td><?php echo $equipo['Equipo']['referencia']; ?>&nbsp;</td>
		<td><?php echo $equipo['Equipo']['descripcion']; ?>&nbsp;</td>
		<td><?php echo $equipo['Equipo']['ficha_tecnica']; ?>&nbsp;</td>
		<td><?php echo $equipo['Equipo']['proxima_revision']; ?>&nbsp;</td>
		<td><?php echo $equipo['Equipo']['mensajes_pendientes']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $equipo['Equipo']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $equipo['Equipo']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $equipo['Equipo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $equipo['Equipo']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Equipo', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Archivos', true)), array('controller' => 'archivos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Archivo', true)), array('controller' => 'archivos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Contratos', true)), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Contrato', true)), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>