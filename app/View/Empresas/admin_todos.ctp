<?php //debug($empresas); ?>
<div class="clientes index">
	<h2><?php echo __('Empresas'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this -> Paginator -> sort('nombre', 'Nombre/Razón Social'); ?></th>
			<th><?php echo $this -> Paginator -> sort('identificacion', 'Identificación'); ?></th>
			<th><?php echo $this -> Paginator -> sort('correo'); ?></th>
			<th class="actions"><?php __('Acciones'); ?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($empresas as $empresa) :
				$solicitudes = false;
				if(!empty($empresa["Solicitud"])) {
					$solicitudes = true;
				}
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
		<tr<?php echo $class; ?>>
			<td><?php echo $empresa['Empresa']['nombre']; ?>&nbsp;</td>
			<td><?php echo $empresa['Empresa']['identificacion']; ?>&nbsp;</td>
			<td><?php echo $empresa['Empresa']['correo']; ?>&nbsp;</td>
			<td class="actions">
				<?php  echo $this -> Html -> link(__('Añadir Usuario', true), array('action' => 'add_usuarios', $empresa['Empresa']['id'])); ?>
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
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link(__('Nueva Empresa', true), array('action' => 'add')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nuevo Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>