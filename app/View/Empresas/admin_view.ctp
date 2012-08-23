<div class="empresas view">
<h2><?php  echo __('Empresa'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Identificacion'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['identificacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contacto'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['contacto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['telefono']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiene Alerta'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['tiene_alerta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiene Publicacion Empresa'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['tiene_publicacion_empresa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiene Publicacion Omega'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['tiene_publicacion_omega']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiene Solicitud'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['tiene_solicitud']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Empresa'), array('action' => 'edit', $empresa['Empresa']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Empresa'), array('action' => 'delete', $empresa['Empresa']['id']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Usuarios'); ?></h3>
	<?php if (!empty($empresa['Usuario'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Empresa Id'); ?></th>
		<th><?php echo __('Rol Id'); ?></th>
		<th><?php echo __('Nombre Usuario'); ?></th>
		<th><?php echo __('Contraseña'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Apellido'); ?></th>
		<th><?php echo __('Correo'); ?></th>
		<th><?php echo __('Primer Login'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($empresa['Usuario'] as $usuario): ?>
		<tr>
			<td><?php echo $usuario['id']; ?></td>
			<td><?php echo $usuario['empresa_id']; ?></td>
			<td><?php echo $usuario['rol_id']; ?></td>
			<td><?php echo $usuario['nombre_usuario']; ?></td>
			<td><?php echo $usuario['contraseña']; ?></td>
			<td><?php echo $usuario['nombre']; ?></td>
			<td><?php echo $usuario['apellido']; ?></td>
			<td><?php echo $usuario['correo']; ?></td>
			<td><?php echo $usuario['primer_login']; ?></td>
			<td><?php echo $usuario['created']; ?></td>
			<td><?php echo $usuario['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'usuarios', 'action' => 'view', $usuario['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'usuarios', 'action' => 'edit', $usuario['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), null, __('Are you sure you want to delete # %s?', $usuario['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Servicios'); ?></h3>
	<?php if (!empty($empresa['Servicio'])): ?>
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
		foreach ($empresa['Servicio'] as $servicio): ?>
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
