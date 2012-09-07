<div class="contratos index">
	<h2><?php __('Contratos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('tipo_id');?></th>
			<th><?php echo $this->Paginator->sort('estado_id');?></th>
			<th><?php echo $this->Paginator->sort('centro_de_costo');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio_desarrollo');?></th>
			<th><?php echo $this->Paginator->sort('fecha_finalizado');?></th>
			<th><?php echo $this->Paginator->sort('diagnostico');?></th>
			<th><?php echo $this->Paginator->sort('cotizacion');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contratos as $contrato):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $contrato['Contrato']['id']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['nombre']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contrato['Tipo']['id'], array('controller' => 'tipos', 'action' => 'view', $contrato['Tipo']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contrato['Estado']['id'], array('controller' => 'estados', 'action' => 'view', $contrato['Estado']['id'])); ?>
		</td>
		<td><?php echo $contrato['Contrato']['centro_de_costo']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['created']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['updated']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['fecha_inicio_desarrollo']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['fecha_finalizado']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['diagnostico']; ?>&nbsp;</td>
		<td><?php echo $contrato['Contrato']['cotizacion']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contrato['Contrato']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contrato['Contrato']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contrato['Contrato']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contrato['Contrato']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Contrato', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tipos', true)), array('controller' => 'tipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Tipo', true)), array('controller' => 'tipos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Estados', true)), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Estado', true)), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Equipos', true)), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>