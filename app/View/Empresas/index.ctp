<?php if(!$this -> Session -> read("Auth.User.primer_login")) { ?>
<div class="equipos">
	<?php if(in_array(1, $servicios_usuario)): ?>
	<h2><?php echo __('Cotizaciones de Mantenimiento: ' . $empresa['Empresa']['nombre']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Alertas</th>
		<th>C.C. Contrato</th>
		<th>Nombre</th>
		<th>Tipo</th>
		<th>Estado</th>
		<th class="actions"><?php __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contratos as $contrato):
		if(($contrato["Contrato"]["estado_id"]<4 ||$contrato["Contrato"]["estado_id"]==6 ||$contrato["Contrato"]["estado_id"]==7)&&$contrato["Contrato"]["estado_id"]!=8) {
			$alarmaPublicacion=false;
			foreach( $contrato["Equipo"] as $equipito){
				if($equipito["ContratosEquipo"]["tiene_publicacion_omega"]) $alarmaPublicacion=true;
			}
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class; ?>>
		<td style="width:180px;">
		<?php echo $this -> element("alertasContratos", array("alertas" => $contrato["Alarma"], "cliente" => true, "publicaciones" => $alarmaPublicacion)); ?>
		</td>
		<td><?php echo $contrato["Contrato"]['centro_de_costo']; ?>&nbsp;</td>
		<td><?php echo $contrato["Contrato"]['nombre']; ?>&nbsp;</td>
		<td><?php echo $contrato['Tipo']["nombre"]; ?>&nbsp;</td>
		<td><?php echo $contrato['Estado']["nombre"]; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Ver', true), array("controller" => "contratos", 'action' => 'view', $contrato["Contrato"]['id'])); ?>
			
			<?php
				if ($contrato['Estado']["id"] == 2)
					echo $this -> Html -> link("Aprobar Cotización", array("controller" => "contratos", "action" => "aprobarCotizacion", $contrato["Contrato"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
			?>
			<?php
				if ($contrato['Estado']["id"] == 2)
					echo $this -> Html -> link("Rechazar Cotización", array("controller" => "contratos", "action" => "rechazarCotizacion", $contrato["Contrato"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
			?>
			
			<?php
				if ($contrato['Estado']["id"] >= 2 && $contrato['Contrato']["cotizacion"] != "" && $contrato['Contrato']["cotizacion"])
					echo $this -> Html -> link("Ver Cotización", array("controller" => "contratos", "action" => "verCotizacion", $contrato["Contrato"]['id']), array("target" => "_blank"));
			?>
			<?php
				if ($contrato["Contrato"]["estado_id"] == 6 || $contrato["Contrato"]["estado_id"] == 7) {
					echo $this -> Html -> link("Ver Comentarios", array("controller" => "contratos", "action" => "comentarios", $contrato['Contrato']['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
				}
			?>
			<?php //echo $this->Html->link(__('Delete', true), array('action' => 'delete', $equipo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $equipo['id'])); ?>
		</td>
	</tr>
	<?php
		}
		endforeach;
	?>
	</table>
	<br />
	<br />
	<br />
	<h2><?php echo __('Contratos de Mantenimiento: ' . $empresa['Empresa']['nombre']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Alertas</th>
		<th> C.C. Contrato</th>
		<th>Nombre</th>
		<th>Tipo</th>
		<th>Estado</th>
		<th class="actions"><?php __('Acciones'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contratos as $contrato):
	if($contrato["Contrato"]["estado_id"]>=4 && $contrato["Contrato"]["estado_id"]!=6 && $contrato["Contrato"]["estado_id"]!=7 && $contrato["Contrato"]["estado_id"]!=8){
	$alarmaPublicacion=false;
			foreach( $contrato["Equipo"] as $equipito){
				if($equipito["ContratosEquipo"]["tiene_publicacion_omega"]) $alarmaPublicacion=true;
			}
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class; ?>>

		<td style="width:180px;">
		<?php echo $this->element("alertasContratos",array("alertas"=>$contrato["Alarma"],"cliente"=>true,"publicaciones"=>$alarmaPublicacion))?>
		</td>
		<td><?php echo $contrato["Contrato"]['centro_de_costo']; ?>&nbsp;</td>
		<td><?php echo $contrato["Contrato"]['nombre']; ?>&nbsp;</td>
		<td><?php echo $contrato['Tipo']["nombre"]; ?>&nbsp;</td>
		<td><?php echo $contrato['Estado']["nombre"]; ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this -> Html -> link(__('Ver', true), array("controller" => "contratos", 'action' => 'view', $contrato["Contrato"]['id'])); ?>
			
			<?php
				if ($contrato['Estado']["id"] == 2)
					echo $this -> Html -> link("Aprobar Cotización", array("controller" => "contratos", "action" => "aprobarCotizacion", $contrato["Contrato"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
			?>
			<?php
				if ($contrato['Estado']["id"] >= 2 && $contrato['Contrato']["cotizacion"] != "" && $contrato['Contrato']["cotizacion"])
					echo $this -> Html -> link("Ver Cotización", array("controller" => "contratos", "action" => "verCotizacion", $contrato["Contrato"]['id']), array("target" => "_blank"));
			?>
			<?php //echo $this->Html->link(__('Delete', true), array('action' => 'delete', $equipo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $equipo['id'])); ?>
		</td>
	</tr>
	<?php
		}
		endforeach;
	?>
	
	</table>
<?php endif; ?>

<?php if(in_array(2, $servicios_usuario)): ?>	
	<!-- COTIZACIONES DE PROYECTOS -->
	<div style="clear:both;"></div>
	<?php if(!empty($proyectos)): ?>
	<h3><?php echo __('Desarrollo de Negocios'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Proyecto'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>		
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		$today=date("Y-m-d	",strtotime("now"));
		foreach ($proyectos as $proyecto):
			$date1 = strtotime($today);
			$date2 = strtotime($proyecto["Proyecto"]["created"]);
			$a=getdate($date1);
			$b=getdate($date2);
			$date1_new = mktime( 12, 0, 0, $a['mon'], $a['mday'], $a['year'] );
			$date2_new = mktime( 12, 0, 0, $b['mon'], $b['mday'], $b['year'] );
			$days = round( abs( $date1_new - $date2_new ) / 86400 );
			if($proyecto['EstadoProyecto']["id"]<3 || $proyecto['EstadoProyecto']["id"]==8 || $proyecto['EstadoProyecto']["id"]==9) {
				$alarmaPublicacion=false;
				if($proyecto["Proyecto"]["publicacion_para_empresa"]) $alarmaPublicacion=true;
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				if(($days<=$proyecto["Proyecto"]['validez'])) {
					$class = ' class="rechazado"';
				}
	?>
	<tr<?php echo $class; ?>>	
		<td style="width:180px;">
			<?php echo $this -> element("alertasProyectos", array("alertas"=>$proyecto["Alarma"], "cliente"=>true, "publicaciones"=>$alarmaPublicacion)); ?>
		</td>
		<td><?php  echo $proyecto["Proyecto"]['centro_de_costo']; ?></td>
		<td><?php  echo $proyecto["Proyecto"]['nombre']; ?></td>
		<td><?php echo $this -> Form -> input("estado", array("id" => "estadoProyecto", "modelId" => $proyecto["Proyecto"]["id"], "label" => false, "options" => $estadosProyectosCotizacion, "selected" => $proyecto["Proyecto"]["estado_proyecto_id"], "disabled" => "true")); ?></td>
		
		<td class="actions">
			<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
			<?php echo $this -> Html -> link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto["Proyecto"]['id'])); ?>
			<?php
				if ($proyecto["Proyecto"]["cotizacion"])
					echo $this -> Html -> link(__('Ver cotizacion', true), array('controller' => 'proyectos', 'action' => 'verCotizacion', $proyecto["Proyecto"]['id']));
			?>
			<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $proyecto['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $proyecto['id'])); ?>
			<?php
				if ($proyecto["Proyecto"]["estado_proyecto_id"] == 1 && $proyecto["Proyecto"]["cotizacion"] && ($days <= $proyecto["Proyecto"]['validez']))
					echo $this -> Html -> link("Aprobar Cotización", array("controller" => "proyectos", "action" => "aprobarCotizacion", $proyecto["Proyecto"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
			?>
			<?php
				if ($proyecto["Proyecto"]["estado_proyecto_id"] == 1 && $proyecto["Proyecto"]["cotizacion"] && ($days <= $proyecto["Proyecto"]['validez']))
					echo $this -> Html -> link("Rechazar Cotización", array("controller" => "proyectos", "action" => "rechazarCotizacion", $proyecto["Proyecto"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
			?>	
			</td>
		</tr>
	<?php } endforeach; ?>
	</table>
	<div style="clear:both;"></div>
	<h3><?php echo __('Planeación y Prestación de Servicio'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
		<tr>	
			<th><?php __('Alertas'); ?></th>
			<th><?php __('C.C. Proyecto'); ?></th>
			<th><?php __('Nombre'); ?></th>
			<th><?php __('Estado'); ?></th>
			<th class="actions"><?php __('Acciones'); ?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($proyectos as $proyecto):
				if($proyecto['EstadoProyecto']["id"]>=3 && $proyecto['EstadoProyecto']["id"]<6) {
					$alarmaPublicacion=false;
					if($proyecto["Proyecto"]["publicacion_para_empresa"]) $alarmaPublicacion=true;
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		?>
		<tr<?php echo $class; ?>>
			<td style="width:180px;">
			<?php echo $this->element("alertasProyectos",array("alertas"=>$proyecto["AlarmaProyecto"],"cliente"=>true,"publicaciones"=>$alarmaPublicacion))?>
			</td>
			<td><?php  echo $proyecto["Proyecto"]['centro_de_costo']; ?></td>
			<td><?php  echo $proyecto["Proyecto"]['nombre']; ?></td>
			<td><?php echo $this -> Form -> input("estado", array("id" => "estadoProyecto", "modelId" => $proyecto["Proyecto"]["id"], "label" => false, "options" => $estadosProyectosEjecucion, "selected" => $proyecto["Proyecto"]["estado_proyecto_id"], "disabled" => "true")); ?></td>
			<td class="actions">
				<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
				<?php echo $this -> Html -> link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto["Proyecto"]['id'])); ?>
				<?php
					if ($proyecto["Proyecto"]["cotizacion"])
						echo $this -> Html -> link(__('Ver cotizacion', true), array('controller' => 'proyectos', 'action' => 'verCotizacion', $proyecto["Proyecto"]['id']));
				?>
				<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $proyecto['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $proyecto['id'])); ?>
				<?php
					if ($proyecto["Proyecto"]["estado_proyecto_id"] == 1 && $proyecto["Proyecto"]["cotizacion"])
						echo $this -> Html -> link("Aprobar Cotizacion", array("controller" => "proyectos", "action" => "aprobarCotizacion", $proyecto["Proyecto"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
				?>
				
			</td>
		</tr>
	<?php } endforeach; ?>
	</table>
	<div style="clear:both;"></div>
	<h3><?php echo __('Post Venta'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Alertas'); ?></th>
		<th><?php echo __('C.C. Proyecto'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php __('Acciones'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($proyectos as $proyecto):
			if($proyecto['EstadoProyecto']["id"]==7 || $proyecto['EstadoProyecto']["id"]==6) {
				$alarmaPublicacion=false;
				if($proyecto["Proyecto"]["publicacion_para_empresa"]) $alarmaPublicacion=true;		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
		<tr<?php echo $class; ?>>
			<td style="width:180px;">
			<?php echo $this->element("alertasProyectos",array("alertas"=>$proyecto["AlarmaProyecto"],"cliente"=>true,"publicaciones"=>$alarmaPublicacion))?>
			</td>
			<td><?php  echo $proyecto["Proyecto"]['centro_de_costo']; ?></td>
			<td><?php  echo $proyecto["Proyecto"]['nombre']; ?></td>
			<td><?php echo $this -> Form -> input("estado", array("id" => "estadoProyecto", "modelId" => $proyecto["Proyecto"]["id"], "label" => false, "options" => $estadosProyectosEjecucion, "selected" => $proyecto["Proyecto"]["estado_proyecto_id"], "disabled" => "true")); ?></td>
			<td class="actions">
				<?php // if(isset($equipo["Ciclo"][count($equipo["Ciclo"])-1])&&$equipo["Ciclo"][count($equipo["Ciclo"])-1]["estado_id"]==5) echo $this->Html->link(__('Nuevo Ciclo', true), array('controller' => 'equipos', 'action' => 'addCiclo', $equipo['id'],$empresa['Empresa']["id"])); ?>
				<?php echo $this -> Html -> link(__('Ver', true), array('controller' => 'proyectos', 'action' => 'view', $proyecto["Proyecto"]['id'])); ?>
				<?php
					if ($proyecto["Proyecto"]["cotizacion"])
						echo $this -> Html -> link(__('Ver cotizacion', true), array('controller' => 'proyectos', 'action' => 'verCotizacion', $proyecto["Proyecto"]['id']));
				?>
				<?php  //echo $this->Html->link(__('Borrar', true), array('controller' => 'contratos', 'action' => 'delete', $proyecto['id']), null, sprintf(__('Esta seguro que desea eliminar el contrato?', true), $proyecto['id'])); ?>
				<?php
					if ($proyecto["Proyecto"]["estado_proyecto_id"] == 1 && $proyecto["Proyecto"]["cotizacion"])
						echo $this -> Html -> link("Aprobar Cotizacion", array("controller" => "proyectos", "action" => "aprobarCotizacion", $proyecto["Proyecto"]['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
				?>				
			</td>
		</tr>
	<?php } endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?php echo $this -> Html -> link(__('Solicitar Proyecto'), array('controller' => 'proyectos', 'action' => 'solicitarProyecto', $empresa["Empresa"]["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox")); ?> </li>
		</ul>
	</div>
<?php endif; ?>
</div>
	<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $this -> Session -> read("Auth.Usuario.id"); ?>"></div>
	</div>
<?php } else { ?>
<h3>Por favor cambie su contraseña</h3>
<div class="cambio_form" style="width:400px; margin:0 auto; height:300px; overflow:hidden;">
<?php
	echo $this -> Form -> create("Empresa", array("action" => "cambiarPassword"));
	echo $this -> Form -> input("nombre_de_usuario", array("disabled" => true, "value" => $this -> Session -> read("Auth.User.nombre_de_usuario")));
	echo $this -> Form -> input("usuario_id", array("type" => "hidden", "value" => $this -> Session -> read("Auth.User.id")));
	echo $this -> Form -> input("contraseña", array("label" => "Nueva Contraseña", 'type' => 'password'));
	echo $this -> Form -> input("verificar_contraseña", array("label" => "Nueva Contraseña", 'type' => 'password'));
	echo $this -> Form -> submit("guardar");
	}
?>
</div>
<!--<div class="verificarMensajes"></div><div style="display:none;" class="equipo" equipoId="<?php echo $proyecto["Proyecto"]["id"]; ?>"></div>-->
<script>
	var server="/";
	$.each($(".equipo"), function(i, val){
		$.post(server+"equipos/AJAX_verificarVisitas",{"equipoId":$(val).attr("equipoId"),"usuarioId":"<?php echo $this -> Session -> read('Auth.User.id'); ?>"},function(data){
		if(parseInt(data)>0){
			$(val).before("<img src='"+server+"img/alerta.gif' >");
		} else {
			$(val).before("<img src='"+server+"img/ninguno.gif' >");
		}
		});
	});
</script>