<div class="usuarios view">
<h2><?php  echo __('Usuario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Empresa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($usuario['Empresa']['nombre'], array('controller' => 'empresas', 'action' => 'view', $usuario['Empresa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rol'); ?></dt>
		<dd>
			<?php echo $this->Html->link($usuario['Rol']['nombre'], array('controller' => 'roles', 'action' => 'view', $usuario['Rol']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre Usuario'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['nombre_usuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contraseña'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['contraseña']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apellido'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['apellido']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Correo'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['correo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Primer Login'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['primer_login']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Usuario'), array('action' => 'edit', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Usuario'), array('action' => 'delete', $usuario['Usuario']['id']), null, __('Are you sure you want to delete # %s?', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('controller' => 'empresas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('controller' => 'empresas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rol'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Servicios'); ?></h3>
	<?php if (!empty($usuario['Servicio'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['Servicio'] as $servicio): ?>
		<tr>
			<td><?php echo $servicio['id']; ?></td>
			<td><?php echo $servicio['nombre']; ?></td>
			<td><?php echo $servicio['created']; ?></td>
			<td><?php echo $servicio['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'servicios', 'action' => 'view', $servicio['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'servicios', 'action' => 'edit', $servicio['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'servicios', 'action' => 'delete', $servicio['id']), null, __('Are you sure you want to delete # %s?', $servicio['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
