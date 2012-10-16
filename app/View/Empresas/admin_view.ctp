<?php //debug($servicios); ?>
<div class="clientes view">
<h2><span style="color:black;"><?php echo __('Cliente: ');?> </span><?php echo $empresa['Empresa']['nombre']; ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Identificación'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['identificacion']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email General'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['correo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contacto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['contacto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Teléfono'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['telefono']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Empresa', true), array('action' => 'edit', $empresa['Empresa']['id'])); ?> </li>		
	</ul>
</div>
<div class="related">
		<?php
			if(
				isset($servicios[1])
				&& isset($this -> params['pass'][1])
				&& $this -> params['pass'][1] == 'mantenimientos'
			): //if($type=="mantenimientos"): //***************MANTENIMIENTOS?>

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
					
					<?php if($contrato["estado_id"]== 6 || $contrato["estado_id"]== 7){
								echo $this->Html->link("Ver Comentarios",array("controller"=>"contratos","action"=>"comentarios",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));
							}else{
								echo $this->Html->link("Anular",array("controller"=>"contratos","action"=>"anularCotizacion",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));
							}?>
					<?php  echo $this->Html->link(__('Eliminar contrato', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
					
				</td>
			</tr>
		<?php 
			endif;
		endforeach; ?>
		
		
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
			foreach ($empresa['Contrato'] as $contrato):
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
				
				<td class="actions">
					<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
					<?php echo $this->Html->link(__('Ver', true), array('controller' => 'contratos', 'action' => 'view', $contrato['id'])); ?>
					<?php echo $this->Html->link(__('Modificar', true), array('controller' => 'contratos', 'action' => 'edit', $contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
					<?php if($contrato["estado_id"]< 3)echo $this->Html->link("Subir cotización PDF",array("controller"=>"contratos","action"=>"subirCotizacion",$contrato['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
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
		endforeach; ?>
		</table>
		<?php endif; //if sin contrato?>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Cotizar Mantenimiento', true), array('controller' => 'contratos', 'action' => 'add',$empresa["Empresa"]["id"]));?> </li>
		</ul>
	</div>
<?php endif;?>
<?php
	if(
		isset($servicios[2])
		&& isset($this -> params['pass'][1])
		&& $this -> params['pass'][1] == 'proyectos'
	): //if($type=="proyectos"):?>
	<!--  COTIZACION DE PROYECTOS -->
	<?php if (!empty($empresa['Proyecto'])):?>
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
		
		foreach ($empresa['Proyecto'] as $proyecto):
		 $date1 = strtotime($today);
		       $date2 = strtotime($proyecto["created"]);
		       
			     $a=getdate($date1);
			     $b=getdate($date2);
			  
			     $date1_new = mktime( 12, 0, 0, $a['mon'], $a['mday'], $a['year'] );
		         $date2_new = mktime( 12, 0, 0, $b['mon'], $b['mday'], $b['year'] ); 
		         $days = round( abs( $date1_new - $date2_new ) / 86400 );  

		if($proyecto['estado_proyecto_id']<3 || $proyecto['estado_proyecto_id']==8 || $proyecto['estado_proyecto_id']==9){
				$alarmaPublicacion=false;
		
				if($proyecto["publicacion_para_omega"]) $alarmaPublicacion=true;

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
			<td><?php echo $this -> Form -> input("estado",array("id"=>"estadoProyecto","modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosCotizacion,"selected"=>$proyecto["estado_proyecto_id"],"disabled"=>true));?></td>
			
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
	<?php } endforeach; ?>
	</table>
	
	
	<!-- PROYECTOS EN EJECUCION -->
		<div style="clear:both;"></div>
	<h3><?php echo __('Planeación y Prestación de Servicio');?></h3>

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
		foreach ($empresa['Proyecto'] as $proyecto):
		if($proyecto['estado_proyecto_id']>=3&&$proyecto['estado_proyecto_id']<6){
			$alarmaPublicacion=false;
			if($proyecto["publicacion_para_omega"]) $alarmaPublicacion=true;		
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
			<td><?php echo $this -> Form->input("estado",array("id"=>"estadoProyectoC","modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosEjecucion,"selected"=>$proyecto["estado_proyecto_id"]));?></td>
			
			<td class="actions">
				<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
				<?php echo $this->Html->link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto['id'])); ?>
				<?php echo $this->Html->link(__('Editar', true), array('controller' => 'proyectos', 'action' => 'edit', $proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>				
				<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
				<?php if($proyecto["estado_proyecto_id"]== 1)echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Iniciar Ejecución",array("controller"=>"proyectos","action"=>"ingresarCc",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>				
			</td>
		</tr>
	<?php } endforeach; ?>
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
		foreach ($empresa['Proyecto'] as $proyecto) {
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
			<td><?php echo $this -> Form->input("estado",array("id"=>"estadoProyectoC","modelId"=>$proyecto["id"],"label"=>false,"options"=>$estadosProyectosEjecucion,"selected"=>$proyecto["estado_proyecto_id"]));?></td>
			
			<td class="actions">
				<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
				<?php echo $this->Html->link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto['id'])); ?>
				<?php echo $this->Html->link(__('Editar', true), array('controller' => 'proyectos', 'action' => 'edit', $proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $contrato['id'])); ?>
				<?php if($proyecto["estado_proyecto_id"]== 1)echo $this->Html->link("Subir cotización PDF",array("controller"=>"proyectos","action"=>"subirCotizacion",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
				<?php if($proyecto["estado_proyecto_id"]== 2)echo $this->Html->link("Iniciar Ejecución",array("controller"=>"proyectos","action"=>"ingresarCc",$proyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
			</td>
		</tr>
	<?php } } ?>
	</table>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Creación De Proyecto', true), array('controller' => 'proyectos', 'action' => 'add',$empresa["Empresa"]["id"]));?> </li>
		</ul>
	</div>	
</div>
<?php endif;?>
<div style="display:none">
	<div id="usuario" usuarioId="<?php echo $this -> Session->read("Auth.Usuario.id");?>"></div>
</div>
<script>


var server="/";

$(document).ready(function(){
	//$(".postventa").hide();
	
	$(".post").toggle(
		function(){
			$(".postventa").show();
		},
		function(){
			$(".postventa").hide();
		}	
	);
	$("#estadoProyectoC").change(function(){
			var select=($("#estadoProyectoC option:selected").val());
			$.post(server+"proyectos/AJAX_cambiarEstado",{"id":$(this).attr("modelId"),"estado_proyecto_id":select},function(data){
				if(data=="NO"){
					alert("No se pudo Actualizar el estado por favor intentelo de nuevo");
					}else{
						alert(data);
					}
				});
		});	
});
$.each($(".equipo"), function(i, val){
	$.post(server+"equipos/AJAX_verificarVisitas",{"equipoId":$(val).attr("equipoId"),"usuarioId":"<?php echo $this -> Session->read('Auth.Usuario.id');?>"},function(data){
		if(parseInt(data)>0){
			$(val).before("<img src='"+server+"img/alerta.gif' >");
		}else{
			$(val).before("<img src='"+server+"img/ninguno.gif' >");
		}
		//$(val).before(data);
	});	
});

</script>
