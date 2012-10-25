<div>
	<h2><?php echo __('Archivos'); ?></h2>
	<?php echo $this -> element('filtro_archivos'); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Nombre</th>
		<th>Tipo</th>
		<th><?php echo $this -> Paginator -> sort('Equipo.codigo', 'Código Equipo'); ?></th>
		<th><?php echo $this -> Paginator -> sort('categorias_archivo_id'); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($archivos as $archivo):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$partesPath=explode("/",$archivo['Archivo']['ruta']);
		$nombrePartido=explode(".",$partesPath[2]);
	?>
	<tr<?php echo $class; ?>>
	
		<td><?php echo $nombrePartido[0]; ?>&nbsp;</td>
		<td><?php echo $nombrePartido[1]; ?>&nbsp;</td>
		<td>
			<?php echo $archivo['Equipo']['codigo']; ?>
			&nbsp;
		</td>
		<td>
			<?php echo $archivo['CategoriasArchivo']['nombre']; ?>
			&nbsp;
		</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Ver', true), array('action' => 'verArchivo', $archivo['Archivo']['id']), array("target" => "_blank")); ?>
			<?php echo $this -> Html -> link(__('Borrar', true), array('action' => 'delete', $archivo['Archivo']['id'], $archivo['Equipo']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $archivo['Archivo']['id'])); ?>
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
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Subir Archivo'), array('action' => 'add', $equipoId)); ?></li>	
	</ul>
</div>