<div class="archivoProyectos index">
	<h2><?php __('Archivo Proyectos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>	
		<th><?php echo $this -> Paginator -> sort('proyecto_id', 'Proyecto'); ?></th>
		<th><?php echo $this -> Paginator -> sort('ruta'); ?></th>
		<th class="actions"><?php __('Actions'); ?></th>
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
		<td><?php echo $archivoProyecto['Archivo']['ruta']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Descargar', true), array('action' => 'verArchivo', $archivoProyecto['Archivo']['id'])); ?>
			
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
