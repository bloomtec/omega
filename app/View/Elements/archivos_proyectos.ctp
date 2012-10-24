<div class="archivoProyectos">
	<h2><?php echo __('Archivos Proyectos'); ?></h2>
	<?php echo $this -> element('filtro_archivos'); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this -> Paginator -> sort('proyecto_id', 'Proyecto'); ?></th>
		<th><?php echo $this -> Paginator -> sort('categorias_archivo_id'); ?></th>
		<th><?php echo $this -> Paginator -> sort('ruta'); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($archivoProyectos as $archivoProyecto):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class; ?>>
		<td>
			<?php echo $this -> Html -> link($archivoProyecto['Proyecto']['nombre'], array('controller' => 'proyectos', 'action' => 'view', $archivoProyecto['Proyecto']['id'])); ?>
		</td>
		<td>
			<?php echo $archivoProyecto['CategoriasArchivo']['nombre']; ?>
			&nbsp;
		</td>
		<td><?php echo $archivoProyecto['Archivo']['ruta']; ?>&nbsp;</td>
		<td class="actions">
		<?php echo $this -> Html -> link(__('Descargar', true), array('action' => 'verArchivo', $archivoProyecto['Archivo']['id'])); ?>
			<?php echo $this -> Html -> link(__('Borrar', true), array('action' => 'delete', $archivoProyecto['Archivo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $archivoProyecto['Archivo']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Nuevo Archivo'), array('action' => 'add')); ?></li>
	</ul>
</div>