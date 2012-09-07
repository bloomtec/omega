<table cellpadding="0" cellspacing="0" style="width:600px";>
	<tr>			
			<th>Cliente</th>
			<th>Solicitud</th>
			<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($solicitudes as $solicitud):
	
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style="width:100px;"><?php echo $solicitud['Cliente']['nombre']; ?>&nbsp;</td>
		<td style="width:300px;"><?php echo $solicitud['Solicitud']['texto_solicitud']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Borrar', true), array('action' => 'borrarSolicitud', $solicitud['Solicitud']['id'],$solicitud['Cliente']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $solicitud['Solicitud']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('Cotizar %s', true), __('Proyecto ', true)), array('controller' => 'proyectos', 'action' => 'add2',$solicitud["Cliente"]["id"]));?> </li>
		</ul>
	</div>