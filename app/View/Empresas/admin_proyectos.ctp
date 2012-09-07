<div class="clientes index">
	<h2><?php __('Empresas');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Alertas</th>
			<th><?php echo $this -> paginator -> sort('Empresa.nombre', 'Nombre/Razón Social'); ?></th>
			<th><?php echo $this -> paginator -> sort('Empresa.identificacion', 'Identificación'); ?></th>
			<th><?php echo $this -> paginator -> sort('Empresa.correo', 'Correo'); ?></th>
			<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($empresas as $empresa) :
			$alarmaPublicacion=false;
			$alarmaPublicacion2=false;
			foreach($empresa['Empresa']["Proyecto"] as $proyecto) {
				if($proyecto["publicacion_para_omega"]) $alarmaPublicacion=true;
				$alarmaPublicacion2=$this->requestAction("/proyectos/tieneAlarmaEmpresa/".$proyecto["id"]);				
			}
			$alarmaPublicacion=($alarmaPublicacion||$alarmaPublicacion2);	
			$solicitudes=false;
			if(!empty($empresa["Solicitud"])) { $solicitudes=true; }
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class;?>>
		<td style="width:180px;">
			<?php echo $this->element("alertasContratos",array("alertas"=>array(),"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
			</td>
		<td><?php echo $empresa['Empresa']['nombre']; ?>&nbsp;</td>
		
		<td><?php echo $empresa['Empresa']['identificacion']; ?>&nbsp;</td>
		<td><?php echo $empresa['Empresa']['correo']; ?>&nbsp;</td>
		<td class="actions">
			<?php if($solicitudes) echo $this->Html->link("Solicitudes",array("controller"=>"clientes","action"=>"solicitudes",$empresa["Empresa"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox importante"));?>
			<?php echo $this->Html->link(__('Ver', true), array('action' => 'view', $empresa['Empresa']['id'],"proyectos")); ?>
			<?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $empresa['Empresa']['id'])); ?>
			<?php echo $this->Html->link(__('Borrar', true), array('action' => 'delete', $empresa['Empresa']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $empresa['Empresa']['id'])); ?>
		</td>
	</tr>
	<?php 

	endforeach; ?>
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
		<li><?php echo $this->Html->link(__('Nueva Empresa', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>