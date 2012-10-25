<table>
	<?php echo $this -> Form -> create('Filtro'); ?>
	<tr>
		<th>Categorías</th>
		<th></th>
		<?php if($filtro) : ?>
		<th></th>
		<?php endif; ?>
	</tr>
	<tr>
		<td><?php echo $this -> Form -> input('categorias_archivo_id', array('label' => false)); ?></td>
		<td><?php echo $this -> Form -> end('Filtrar'); ?></td>
		<?php if($filtro) : ?>
		<td class="actions">
			<?php
				if(isset($equipoId)) {
					echo $this -> Form -> postLink(__('Quitar Filtro'), array('action' => 'removeFilter', $equipoId), null, null);					
				} elseif(isset($proyectoId)) {
					echo $this -> Form -> postLink(__('Quitar Filtro'), array('action' => 'removeFilter', $proyectoId), null, null);
				}
				
			?>
		</td>
		<?php endif; ?>
	</tr>
</table>