<div class="categoriasEquipos view">
<h2><?php  echo __('Categorias Equipo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoriasEquipo['CategoriasEquipo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($categoriasEquipo['Empresa']['nombre'], array('controller' => 'empresas', 'action' => 'view', $categoriasEquipo['Empresa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($categoriasEquipo['CategoriasEquipo']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($categoriasEquipo['CategoriasEquipo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($categoriasEquipo['CategoriasEquipo']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Categorias Equipo'), array('action' => 'edit', $categoriasEquipo['CategoriasEquipo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Categorias Equipo'), array('action' => 'delete', $categoriasEquipo['CategoriasEquipo']['id']), null, __('Are you sure you want to delete # %s?', $categoriasEquipo['CategoriasEquipo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categorias Equipos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categorias Equipo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Equipos'); ?></h3>
	<?php if (!empty($categoriasEquipo['Equipo'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Categorias Equipo Id'); ?></th>
		<th><?php echo __('Referencia'); ?></th>
		<th><?php echo __('Descripcion'); ?></th>
		<th><?php echo __('Ficha Tecnica'); ?></th>
		<th><?php echo __('Mensajes Pendientes'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($categoriasEquipo['Equipo'] as $equipo): ?>
		<tr>
			<td><?php echo $equipo['id']; ?></td>
			<td><?php echo $equipo['categorias_equipo_id']; ?></td>
			<td><?php echo $equipo['referencia']; ?></td>
			<td><?php echo $equipo['descripcion']; ?></td>
			<td><?php echo $equipo['ficha_tecnica']; ?></td>
			<td><?php echo $equipo['mensajes_pendientes']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'equipos', 'action' => 'view', $equipo['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'equipos', 'action' => 'edit', $equipo['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'equipos', 'action' => 'delete', $equipo['id']), null, __('Are you sure you want to delete # %s?', $equipo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
