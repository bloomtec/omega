<!--  COTIZACION DE PROYECTOS -->
<?php
	if (!empty($serviciosPrestados)) : //debug($serviciosPrestados);
?>
<div style="clear:both;"></div>
<h3><?php echo __('Desarrollo de Negocios'); ?></h3>
<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Proyecto'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php echo __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		$today=date("Y-m-d	",strtotime("now"));
		foreach ($serviciosPrestados as $proyecto) :
			$date1 = strtotime($today);
			$date2 = strtotime($proyecto["created"]);
			$a=getdate($date1);
			$b=getdate($date2);
			$date1_new = mktime( 12, 0, 0, $a['mon'], $a['mday'], $a['year'] );
			$date2_new = mktime( 12, 0, 0, $b['mon'], $b['mday'], $b['year'] );
			$days = round( abs( $date1_new - $date2_new ) / 86400 );  
			if($proyecto['estado_proyecto_id']<3 || $proyecto['estado_proyecto_id']==8 || $proyecto['estado_proyecto_id']==9) {
				$alarmaPublicacion=false;		
				if($proyecto["publicacion_para_omega"]) {
					$alarmaPublicacion=true;
				}
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
	<tr<?php echo $class;?>>
		<td style="width:180px;">
		<?php echo $this->element("alertasProyectos",array("alertas"=>$proyecto["Alarma"],"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php  echo $proyecto['centro_de_costo']; ?></td>
		<td><?php  echo $proyecto['nombre']; ?></td>
		<td><?php echo $this -> Form -> input("estado",array("class" => "cambioEstadoProyecto", "modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosCotizacion,"selected"=>$proyecto["estado_proyecto_id"],"disabled"=>true));?></td>
		<td class="actions">
			<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
			<?php echo $this->Html->link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto['id'])); ?>
			<?php  echo $this->Html->link(__('Borrar', true), array('controller' => 'proyectos', 'action' => 'delete', $proyecto['id']), null, sprintf(__('Esta seguro que desea eliminar el proyecto?', true), $proyecto['id'])); ?>
			<?php //if($proyecto["estado_proyecto_id"]== 1 && $days<=$proyecto['validez'])echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 1)echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Iniciar Ejecución",array("controller"=>"proyectos","action"=>"ingresarCc",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Anular",array("controller"=>"proyectos","action"=>"anularCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 2 || $proyecto["estado_proyecto_id"]== 9)echo $this->Html->link("Comentarios",array("controller"=>"proyectos","action"=>"comentarios",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
		</td>
	</tr>
	<?php
			}
			endforeach;
	?>
</table>
	
<!-- PROYECTOS EN EJECUCION -->
<div style="clear:both;"></div>
<h3><?php echo __('Prestación de Servicio');?></h3>
<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Proyecto'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php echo __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($serviciosPrestados as $proyecto) :
			if($proyecto['estado_proyecto_id']>=3&&$proyecto['estado_proyecto_id']<6) {
				$alarmaPublicacion=false;
				if($proyecto["publicacion_para_omega"]) {
					$alarmaPublicacion=true;
				}		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
	<tr<?php echo $class;?>>		
		<td style="width:180px;">
		<?php echo $this->element("alertasProyectos",array("alertas"=>$proyecto["Alarma"],"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php  echo $proyecto['centro_de_costo']; ?></td>
		<td><?php  echo $proyecto['nombre']; ?></td>
		<td><?php echo $this -> Form->input("estado",array("class" => "cambioEstadoProyectoC","modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosEjecucion,"selected"=>$proyecto["estado_proyecto_id"]));?></td>
		<td class="actions">
			<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
			<?php echo $this->Html->link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto['id'])); ?>
			<?php echo $this->Html->link(__('Editar', true), array('controller' => 'proyectos', 'action' => 'edit', $proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>				
			<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
			<?php if($proyecto["estado_proyecto_id"]== 1)echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Iniciar Ejecución",array("controller"=>"proyectos","action"=>"ingresarCc",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>				
		</td>
	</tr>
	<?php
			}
			endforeach;
	?>
</table>
<?php endif; ?>
<!-- PROYECTOS CANCELADOS O FINALIZADOS -->
<div style="clear:both;"></div>
<h3 class="post"><?php echo __('Post Venta');?></h3>
<table cellpadding = "0" cellspacing = "0" class="postventa">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Proyecto'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>		
		<th class="actions"><?php echo __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($serviciosPrestados as $proyecto) {
			if($proyecto['estado_proyecto_id'] == 7 || $proyecto['estado_proyecto_id'] == 6) {
				$alarmaPublicacion=false;
				if($proyecto["publicacion_para_omega"]) $alarmaPublicacion = true;		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
	<tr<?php echo $class;?>>
		<td style="width:180px;">
		<?php echo $this->element("alertasProyectos",array("alertas"=>$proyecto["Alarma"],"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php echo $proyecto['centro_de_costo']; ?></td>
		<td><?php echo $proyecto['nombre']; ?></td>
		<td><?php echo $this -> Form->input("estado",array("class" => "cambioEstadoProyectoC","modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosEjecucion,"selected"=>$proyecto["estado_proyecto_id"]));?></td>
		<td class="actions">
			<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
			<?php echo $this->Html->link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto['id'])); ?>
			<?php echo $this->Html->link(__('Editar', true), array('controller' => 'proyectos', 'action' => 'edit', $proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
			<?php if($proyecto["estado_proyecto_id"]== 1)echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Iniciar Ejecución",array("controller"=>"proyectos","action"=>"ingresarCc",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
		</td>
	</tr>
	<?php
			}
		}
	?>
</table>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Creación De Proyecto', true), array('controller' => 'proyectos', 'action' => 'add',$empresa["Empresa"]["id"], $this -> params['pass'][1]));?> </li>
	</ul>
</div>