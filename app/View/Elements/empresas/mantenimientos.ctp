<h3><?php echo __('Cotizaciones de Mantenimiento');?></h3>
<?php if (!empty($empresa['Contrato'])):?>
<table cellpadding = "0" cellspacing = "0">
	<tr>		
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Contrato'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Tipo'); ?></th>
		<th><?php echo __('Estado'); ?></th>			
		<th class="actions"><?php echo __('Acciones');?></th>
	</tr>
<?php
	$i = 0;
	foreach ($empresa['Contrato'] as $contrato):
		if($contrato["estado_id"]< 4||$contrato["estado_id"]==6 ||$contrato["estado_id"]==7):

	$alarmaPublicacion=false;
		foreach( $contrato["Equipo"] as $equipito){
			if($equipito["ContratosEquipo"]["tiene_publicacion_empresa"]) $alarmaPublicacion=true;
		}
	
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
	<tr<?php echo $class;?>>
		<td style="width:180px;">
		<?php echo $this->element("alertasContratos",array("alertas"=>$contrato["Alarma"],"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php  echo $contrato['centro_de_costo']; ?></td>
		<td><?php  echo $contrato['nombre']; ?></td>
		<td><?php echo $contrato['Tipo']["nombre"];?></td>
		<td><?php echo $contrato['Estado']["nombre"];?></td>
		<td class="actions">
		<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
		<?php echo $this->Html->link(__('Ver', true), array('controller' => 'contratos', 'action' => 'view', $contrato['id'])); ?>
		<?php if($contrato["estado_id"]< 3)echo $this->Html->link("Subir cotización PDF",array("controller"=>"contratos","action"=>"subirCotizacion",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
		<?php if($contrato["estado_id"]== 3)echo $this->Html->link("Ingresar C. C.",array("controller"=>"contratos","action"=>"ingresarCc",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
		<?php if($contrato["estado_id"]== 3 && $contrato["centro_de_costo"] && $contrato["centro_de_costo"]!="")echo $this->Html->link("Iniciar desarrollo",array("controller"=>"contratos","action"=>"iniciarDesarrollo",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
		<?php if($contrato["estado_id"]== 4)echo $this->Html->link(__('Finalizar Contrato', true), array('controller' => 'contratos', 'action' => 'finalizar', $contrato['id']), null, sprintf(__('Esta seguro que desea finalizar el contrato? Esto hará que todos sus equipos pasen al estado finalizado', true), $contrato['id']));?>
		<?php
			if($contrato["estado_id"]== 6 || $contrato["estado_id"]== 7) {
				echo $this->Html->link("Ver Comentarios",array("controller"=>"contratos","action"=>"comentarios",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));
			} else {
				echo $this->Html->link("Anular",array("controller"=>"contratos","action"=>"anularCotizacion",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));
			}
		?>
		<?php if($this -> Session -> read('Auth.User.rol_id') == 1) echo $this->Html->link(__('Eliminar contrato', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
		</td>
	</tr>
	<?php 
		endif;
		endforeach;
	?>
</table>
<div style="clear:both;"></div>
<h3><?php echo __('Contratos de Mantenimiento'); ?></h3>
<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Contrato'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Tipo'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php echo __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($empresa['Contrato'] as $contrato) :
			if($contrato["estado_id"]>= 4 && $contrato["estado_id"]!=6 && $contrato["estado_id"]!=7):
			$alarmaPublicacion=false;
			foreach( $contrato["Equipo"] as $equipito){
				if($equipito["ContratosEquipo"]["tiene_publicacion_empresa"]) $alarmaPublicacion=true;
			}			
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td style="width:180px;">
			<?php echo $this->element("alertasContratos",array("alertas"=>$contrato["Alarma"],"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
			</td>
			<td><?php  echo $contrato['centro_de_costo']; ?></td>
			<td><?php  echo $contrato['nombre']; ?></td>
			<td><?php echo $contrato['Tipo']["nombre"];?></td>
			<td><?php echo $contrato['Estado']["nombre"];?></td>
			<td id="AccionesContratosMantenimiento" class="actions" style="max-width:490px;">
				<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
				<?php echo $this->Html->link(__('Ver', true), array('controller' => 'contratos', 'action' => 'view', $contrato['id'])); ?>
				<?php echo $this->Html->link(__('Modificar', true), array('controller' => 'contratos', 'action' => 'edit', $contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($contrato["estado_id"]< 5)echo $this->Html->link("Subir cotización PDF",array("controller"=>"contratos","action"=>"subirCotizacion",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($contrato["estado_id"]== 3)echo $this->Html->link("Ingresar C. C. / Modificar",array("controller"=>"contratos","action"=>"ingresarCc",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($contrato["estado_id"]== 3 && $contrato["centro_de_costo"] && $contrato["centro_de_costo"]!="")echo $this->Html->link("Iniciar desarrollo",array("controller"=>"contratos","action"=>"iniciarDesarrollo",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($contrato["estado_id"]== 4)echo $this->Html->link(__('Finalizar Contrato', true), array('controller' => 'contratos', 'action' => 'finalizar', $contrato['id']), null, sprintf(__('Esta seguro que desea finalizar el contrato? Esto hará que todos sus equipos pasen al estado finalizado', true), $contrato['id']));?>
				<?php echo $this->Html->link("Ver Comentarios",array("controller"=>"contratos","action"=>"comentarios",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php  echo $this->Html->link(__('Eliminar contrato', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
				<?php if($contrato["tipo_id"]==1 && $contrato["estado_id"]!=8) echo $this->Html->link("Suspender",array("controller"=>"contratos","action"=>"suspenderContrato",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($contrato["tipo_id"]==1 && $contrato["estado_id"]==8) echo $this->Html->link("Reactivar",array("controller"=>"contratos","action"=>"reactivarContrato",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			</td>
		</tr>
	<?php 
		endif;
		endforeach;
	?>
</table>
<?php endif; //if sin contrato?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Cotizar Mantenimiento', true), array('controller' => 'contratos', 'action' => 'add',$empresa["Empresa"]["id"]));?> </li>
	</ul>
</div>