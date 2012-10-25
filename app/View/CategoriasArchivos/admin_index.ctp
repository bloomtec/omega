<div class="categoriasArchivos index">
	<h2><?php echo __('Categorías Archivos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('nombre'); ?></th>
		<th><?php echo $this->Paginator->sort('created', 'Creada'); ?></th>
		<th><?php echo $this->Paginator->sort('modified', 'Modificada'); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
	foreach ($categoriasArchivos as $categoriasArchivo): ?>
	<tr>
		<td><?php echo h($categoriasArchivo['CategoriasArchivo']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($categoriasArchivo['CategoriasArchivo']['created']); ?>&nbsp;</td>
		<td><?php echo h($categoriasArchivo['CategoriasArchivo']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modificar'), array('action' => 'edit', $categoriasArchivo['CategoriasArchivo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Borrar'), array('action' => 'delete', $categoriasArchivo['CategoriasArchivo']['id']), null, __('¿Seguro desea borrar la categoría %s?', $categoriasArchivo['CategoriasArchivo']['nombre'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
		<?php echo $this -> Paginator -> counter(array('format' => __('Página {:page} de {:pages}. Mostrando {:current} registros de un total de {:count}. Inicia con el  {:start} y termina con el {:end}'))); ?>
	</p>
	<div class="paging">
		<?php
		echo $this -> Paginator -> first('<< ', array(), null, array('class' => 'prev disabled'));
		echo $this -> Paginator -> prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this -> Paginator -> numbers(array('separator' => ''));
		echo $this -> Paginator -> next(__('siguiente') . ' >', array(), null, array('class' => 'next disabled'));
		echo $this -> Paginator -> last(' >>', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nueva Categoría'), array('action' => 'add')); ?></li>
	</ul>
</div>
