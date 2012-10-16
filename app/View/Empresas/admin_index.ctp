<!--<div style="float:left">
	<?php echo $this -> Html -> image("mantenimientos.jpg", array("alt" => "Mantenimientos", 'url' => array('controller' => 'empresas', 'action' => 'mantenimientos'))); ?>
</div>
<div style="float:left">
	<?php echo $this -> Html -> image("proyectos.jpg", array("alt" => "Proyectos", 'url' => array('controller' => 'empresas', 'action' => 'proyectos'))); ?>
</div>
<div style="float:left">
	<?php echo $this -> Html -> image("crearusuarios.jpg", array("alt" => "Proyectos", 'url' => array('controller' => 'empresas', 'action' => 'todos'))); ?>
</div>-->
<div class="empresas index">
	<h2><?php echo __('Empresas'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Alertas</th>
		<th><?php echo $this -> paginator -> sort('Empresa.nombre', 'Nombre/Razón Social'); ?></th>
		<th><?php echo $this -> paginator -> sort('Empresa.identificacion', 'Identificación'); ?></th>
		<th><?php echo $this -> paginator -> sort('Empresa.correo', 'Correo'); ?></th>
		<th class="actions"><?php echo __('Servicios'); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($empresas as $empresa) :
			//debug($empresa);
			$servicios = $this -> requestAction('/empresas/getServicios/' . $empresa['Empresa']['id']);
			//debug($servicios);
			$alarmaPublicacion=false;
			$alarmaPublicacion2=false;
			foreach( $empresa["Contrato"] as $contrato) {
				$alarmaPublicacion=$this->requestAction("/contratos/tienePublicacionEmpresa/".$contrato["id"]);
				$alarmaPublicacion2=$this->requestAction("/contratos/tieneAlarmaEmpresa/".$contrato["id"]);
			}
			$alarmaPublicacion = ($alarmaPublicacion || $alarmaPublicacion2);
			$solicitudes = false;
			if(!empty($empresa["Solicitud"])) { $solicitudes=true; }
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class; ?>>
		<td style="width:180px;">
			<?php echo $this->element("alertasContratos",array("alertas"=>array(),"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php echo $empresa['Empresa']['nombre']; ?>&nbsp;</td>
		
		<td><?php echo $empresa['Empresa']['identificacion']; ?>&nbsp;</td>
		<td><?php echo $empresa['Empresa']['correo']; ?>&nbsp;</td>
		<td class="actions">
			<?php
				if(key_exists(1, $servicios)) {
					echo $this -> Html -> link(__('Mantenimiento', true), array('action' => 'view', $empresa['Empresa']['id'], "mantenimientos"));
				}
			?>
			<?php
				if(key_exists(2, $servicios)) {
					echo $this->Html->link(__('Proyectos', true), array('action' => 'view', $empresa['Empresa']['id'],"proyectos"));
					if($solicitudes) {
						 echo $this -> Html -> link("Solicitudes",array("controller"=>"empresas","action"=>"solicitudes",$empresa["Empresa"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox importante"));
					}
				}
			?>
		</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Añadir Usuario', true), array('action' => 'add_usuarios', $empresa['Empresa']['id'])); ?>
			<?php echo $this -> Html -> link(__('Editar', true), array('action' => 'edit', $empresa['Empresa']['id'])); ?>
			<?php echo $this -> Html -> link(__('Borrar', true), array('action' => 'delete', $empresa['Empresa']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $empresa['Empresa']['id'])); ?>
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
		<li><?php echo $this -> Html -> link(__('Nueva Empresa', true), array('action' => 'add')); ?></li>
		<li><?php echo $this -> Html -> link(__('Listar Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this -> Html -> link(__('Nuevo Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		
	</ul>
</div>