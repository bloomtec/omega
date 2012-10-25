<div class="usuarios index">
	<h2><?php __('Usuarios'); ?></h2>
	<table>
		<?php echo $this -> Form -> create('Usuario'); ?>
		<tr>
			<th>Rol</th>
			<th>Estado</th>
			<th></th>
			<?php if($filtro) : ?>
			<th></th>
			<?php endif; ?>
		</tr>
		<tr>
			<td><?php echo $this -> Form -> input('rol_id', array('label' => false, 'empty' => 'Seleccione...')); ?></td>
			<td><?php echo $this -> Form -> input('activo', array('label' => false)); ?></td>
			<td><?php echo $this -> Form -> end('Filtrar'); ?></td>
			<?php if($filtro) : ?>
			<td class="actions"><?php echo $this -> Form -> postLink(__('Quitar Filtro'), array('action' => 'removeFilter'), null, null); ?></td>
			<?php endif; ?>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this -> Paginator -> sort('nombre'); ?></th>
			<th><?php echo $this -> Paginator -> sort('apellido'); ?></th>
			<th><?php echo $this -> Paginator -> sort('nombre_de_usuario'); ?></th>
			<th><?php echo $this -> Paginator -> sort('correo'); ?></th>
			<th><?php echo $this -> Paginator -> sort('rol_id'); ?></th>
			<th><?php echo $this -> Paginator -> sort('activo'); ?></th>
			<th class="actions"><?php __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuarios as $usuario):
			$class = null;
			if ($i++ % 2 == 0) { $class = ' class="altrow"'; }
	?>
	<tr<?php echo $class; ?>>
		<td><?php echo $usuario['Usuario']['nombre']; ?>&nbsp;</td>
		<td><?php echo $usuario['Usuario']['apellido']; ?>&nbsp;</td>
		<td><?php echo $usuario['Usuario']['nombre_de_usuario']; ?>&nbsp;</td>
		<td><?php echo $usuario['Usuario']['correo']; ?>&nbsp;</td>
		<td><?php echo $usuario['Rol']['nombre']; ?>&nbsp;</td>
		<td><?php if($usuario['Usuario']['activo']) { echo '<input type="checkbox" disabled="true" checked="checked" />'; } else { echo '<input type="checkbox" disabled="true" />'; } ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Ver', true), array('action' => 'view', $usuario['Usuario']['id'])); ?>
			<?php echo $this -> Html -> link(__('Editar', true), array('action' => 'edit', $usuario['Usuario']['id'])); ?>
			<?php
				if($usuario['Usuario']['activo']) {
					echo $this -> Form -> postLink(__('Desactivar'), array('action' => 'disable', $usuario['Usuario']['id']), null, __('¿Seguro desea desactivar el usuario %s?', $usuario['Usuario']['nombre_de_usuario']));
				} else {
					echo $this -> Form -> postLink(__('Activar'), array('action' => 'enable', $usuario['Usuario']['id']), null, __('¿Seguro desea activar el usuario %s?', $usuario['Usuario']['nombre_de_usuario']));
				}
			?>
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
		<li><?php echo $this -> Html -> link(__('Nuevo Usuario'), array('action' => 'add')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nueva Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
	</ul>
</div>