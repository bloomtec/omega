<div class="equipos faces admin">
	<div class="marcoEquipo">
		<div class="lineaSuperior">
			<div class="info">
				<span style="color:#e10000">
					<?php echo $proyecto['Proyecto']["nombre"]; ?>
				</span>
				<?php echo $this -> Html -> link("volver", array("controller" => "empresas", "action" => "index"), array("style" => "font-size:10px;vertical-align:top;")); ?>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class=panelInformativo>
		<br />
			<table cellpadding="0" cellspacing="0">
				<tr><td>Fecha De Entrega</td><td><?php echo $proyecto['Proyecto']['fecha_de_entrega']; ?></td></tr>
				<tr><td>Fecha De Inicio</td><td><?php echo $proyecto['Proyecto']['fecha_de_inicio']; ?></td></tr>
				<tr><td>Cotización</td><td><?php echo $this -> Html -> link("Ver Cotización", array("controller" => "proyectos", "action" => "verCotizacion", $proyecto['Proyecto']['id'])); ?></td></tr>
				<tr><td>Cronograma</td><td><?php echo $this -> Html -> link($this -> Html -> image('/img/Calendario.png', array('title' => 'Ver Cronograma', 'alt' => 'Ver Cronograma', 'height' => '25')), array("controller" => "proyectos", "action" => "verCronograma", $proyecto['Proyecto']['id']), array('escape' => false)); ?></td></tr>
				<tr><td>Responsable Comercial</td><td><?php echo $proyecto['Proyecto']['responsable_comercial']; ?></td></tr>
				<tr><td>Descripción</td><td><?php echo $proyecto['Proyecto']['descripcion']; ?></td></tr>
				<tr><td>Comentarios</td><td><?php echo $proyecto['Proyecto']['comentarios']; ?></td></tr>
			</table>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>Subproyecto</th>
					<th>Presupuesto</th>
					<th>Cronograma</th>
					<th>Estado</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
				</tr>
					<?php
						$i = 0;
						foreach ($proyecto["Subproyecto"] as $subproyecto):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class; ?>>

							<td><?php echo $subproyecto['nombre']; ?>&nbsp;</td>
							<td>
								<?php
								if ($subproyecto['presupuesto_path']) {
									echo $this -> Html -> link("ver PDF", array("controller" => "subproyectos", "action" => "verPresupuesto", $subproyecto['id']));
								} else {

								}
								?>&nbsp;
							</td>
							<td>
								<?php
								if ($subproyecto['cronograma_path']) {
									echo $this -> Html -> link("ver PDF", array("controller" => "subproyectos", "action" => "verCronograma", $subproyecto['id']));
								} else {

								}
								?>&nbsp;
							</td>
							<td><?php echo $subproyecto["estado"]; ?></td>
							<td class="actions">
								<?php
								if (!$subproyecto['aprobado'] && $subproyecto['presupuesto_path'] && $subproyecto["estado"] != "Rechazado" && $subproyecto["estado"] != "Anulado")
									echo $this -> Html -> link("Aprobar", array("controller" => "subproyectos", "action" => "aprobarCotizacion", $subproyecto["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
								?>
								<?php
									if (!$subproyecto['aprobado'] && $subproyecto['presupuesto_path'] && $subproyecto["estado"] != "Rechazado" && $subproyecto["estado"] != "Anulado")
										echo $this -> Html -> link("Rechazar", array("controller" => "subproyectos", "action" => "rechazarCotizacion", $subproyecto["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox"));
								?>
							</td>
						</tr>
					<?php endforeach;

							foreach ($proyecto["SolicitudProyecto"] as $solicitud):
							$class = null;
							if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class; ?>>

							<td><span style="color:#e10000">Solicitud Nueva&nbsp;</span></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="actions">
								<?php echo $this -> Html -> link(__('Revisar', true), array('controller' => 'solicitudProyectos', 'action' => 'view', $solicitud['id'], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "thickbox")); ?>
								
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
				
					
			<div style="clear:both;"></div>
			<div style="clear:both;"></div>
			<div class="textAreaTitulo pestana3">Bitácora</div>
			<?php
				if ($proyecto["Proyecto"]["desarrollo"] && $proyecto["Proyecto"]["desarrollo"] != "")
					$value = $proyecto["Proyecto"]["desarrollo"];
				else
					$value = "Descripción de actividades u observaciones de la ejecucion del proyecto";
			?>
			<textarea id=desarrollo disabled="disabled" name="data[actividad]" modelId="<?php echo $proyecto["Proyecto"]["id"]; ?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				
		</div>
		
		<div class="panel_lateral">
				<?php echo $this -> Html -> link("VER ARCHIVOS (" . count($proyecto["Archivo"]) . ")", array("controller" => "archivoProyectos", "action" => "index", $proyecto["Proyecto"]["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "boton thickbox")); ?>
				<?php echo $this -> Html -> link("SUBIR ARCHIVOS", array("controller" => "archivoProyectos", "action" => "add", $proyecto["Proyecto"]["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "boton thickbox")); ?>
				<?php echo $this -> Html -> link("SOLICITAR ADICIONAL", array("controller" => "proyectos", "action" => "solicitudAdicional", $proyecto["Proyecto"]["id"], "?KeepThis=true&TB_iframe=true&height=400&width=600"), array("class" => "boton thickbox")); ?>	
		</div>
		<div style="clear:both;"></div>
		<br />
		<div class="pestana3">Chat</div>
		<div class="comentarios publicos">
			<?php echo $this -> element("commentsproyecto", array("observacionesPublicas" => $comentariosPublicos, "modelo" => "Publico")); ?>
			<div style="clear:both;"></div>
		</div>			
	</div>
</div>
<div style="display:none">
	<div id="usuario" usuarioId="<?php echo $this  -> Session -> read("Auth.User.id"); ?>"></div>
	<div id="equipo" proyectoId="<?php echo $proyecto["Proyecto"]["id"]; ?>"></div>
</div>
<script> //SCRIPT para Registrar la ultima visita al equipo del usuario
	var server="/";
	$.post(server+"proyectos/quitarPulicacionParaCliente",{"id":"<?php echo $proyecto["Proyecto"]["id"]; ?>"},function(data){
		
	});
	$(window).unload(function() {
		$.post(server+"proyectos/quitarPulicacionParaCliente",{"id":"<?php echo $proyecto["Proyecto"]["id"]; ?>"},function(data){
			
		});
	});
	$(function(){
		$('.historial').scrollTop(10000);
		
	});
</script>