<div class="archivos index">
	<h2><?php __('Archivos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('tipo');?></th>
			<th><?php echo $this->Paginator->sort('equipo_id');?></th>
			<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($archivos as $archivo):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$partesPath=explode("/",$archivo['Archivo']['path']);
		$nombrePartido=explode(".",$partesPath[2]);
	?>
	<tr<?php echo $class;?>>
	
		<td><?php echo $nombrePartido[0]; ?>&nbsp;</td>
		<td><?php echo $nombrePartido[1]; ?>&nbsp;</td>
		<td>
			<?php echo $archivo['Equipo']['referencia']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver', true), array('action' => 'verArchivo', $archivo['Archivo']['id']),array("target"=>"_blank")); ?>
			<?php echo $this->Html->link(__('Borrar', true), array('action' => 'borrar', $archivo['Archivo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $archivo['Archivo']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% de %pages%, mostrando %current% registros de  %count% totales', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('siguiente', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Subir %s', true), __('Archivo', true)), array('action' => 'add',$equipoId)); ?></li>
	
	</ul>
</div>