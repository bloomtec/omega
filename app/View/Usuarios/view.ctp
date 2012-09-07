<div class="usuarios view">
<h2><?php  __('Usuario');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['role']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Usuario', true)), array('action' => 'edit', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Usuario', true)), array('action' => 'delete', $usuario['Usuario']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Usuarios', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Usuario', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Clientes', true)), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Cliente', true)), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Observacion Privadas', true)), array('controller' => 'observacion_privadas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Observacion Privada', true)), array('controller' => 'observacion_privadas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Observacion Publicas', true)), array('controller' => 'observacion_publicas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Observacion Publica', true)), array('controller' => 'observacion_publicas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Clientes', true));?></h3>
	<?php if (!empty($usuario['Cliente'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Apellidos'); ?></th>
		<th><?php __('Nit/cc'); ?></th>
		<th><?php __('Email'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['Cliente'] as $cliente):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $cliente['id'];?></td>
			<td><?php echo $cliente['usuario_id'];?></td>
			<td><?php echo $cliente['nombre'];?></td>
			<td><?php echo $cliente['apellidos'];?></td>
			<td><?php echo $cliente['nit/cc'];?></td>
			<td><?php echo $cliente['email'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'clientes', 'action' => 'view', $cliente['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'clientes', 'action' => 'edit', $cliente['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'clientes', 'action' => 'delete', $cliente['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cliente['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Cliente', true)), array('controller' => 'clientes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Observacion Privadas', true));?></h3>
	<?php if (!empty($usuario['ObservacionPrivada'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Equipo Id'); ?></th>
		<th><?php __('Observacion'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['ObservacionPrivada'] as $observacionPrivada):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $observacionPrivada['id'];?></td>
			<td><?php echo $observacionPrivada['usuario_id'];?></td>
			<td><?php echo $observacionPrivada['equipo_id'];?></td>
			<td><?php echo $observacionPrivada['observacion'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'observacion_privadas', 'action' => 'view', $observacionPrivada['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'observacion_privadas', 'action' => 'edit', $observacionPrivada['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'observacion_privadas', 'action' => 'delete', $observacionPrivada['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $observacionPrivada['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Observacion Privada', true)), array('controller' => 'observacion_privadas', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Observacion Publicas', true));?></h3>
	<?php if (!empty($usuario['ObservacionPublica'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Equipo Id'); ?></th>
		<th><?php __('Observacion'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['ObservacionPublica'] as $observacionPublica):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $observacionPublica['id'];?></td>
			<td><?php echo $observacionPublica['usuario_id'];?></td>
			<td><?php echo $observacionPublica['equipo_id'];?></td>
			<td><?php echo $observacionPublica['observacion'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'observacion_publicas', 'action' => 'view', $observacionPublica['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'observacion_publicas', 'action' => 'edit', $observacionPublica['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'observacion_publicas', 'action' => 'delete', $observacionPublica['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $observacionPublica['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Observacion Publica', true)), array('controller' => 'observacion_publicas', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
