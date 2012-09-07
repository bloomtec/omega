<div class="equipos faces admin">
	<div class="marcoEquipo">
		<div class="lineaSuperior">
			<div class="info"> <span style="color:#e10000"><?php echo $proyecto['Proyecto']["nombre"];?> </span> <?php echo $html->link("volver",array("controller"=>"clientes","action"=>"index"),array("style"=>"font-size:10px;vertical-align:top;"));?></div>
			
		</div>
		<div style="clear:both;"></div>
		<div class=panelInformativo>
		<br />
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>Subproyecto</th>
					<th>Presupuesto</th>
					<th>Cronograma</th>
					<th>Estado</th>
					<th class="actions"><?php __('Acciones');?></th>
				</tr>
					<?php
						$i = 0;
						foreach ($proyecto["Subproyecto"] as $subproyecto):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class;?>>

							<td><?php echo $subproyecto['nombre']; ?>&nbsp;</td>
							<td>
								<?php if($subproyecto['presupuesto_path']){
										echo $html->link("ver PDF",array("controller"=>"subproyectos","action"=>"verPresupuesto", $subproyecto['id'])); 
										}else{
											
										}
								?>&nbsp;
							</td>
							<td>
								<?php if($subproyecto['cronograma_path']){
										echo $html->link("ver PDF",array("controller"=>"subproyectos","action"=>"verCronograma", $subproyecto['id'])); 
										}else{
											
										}
								?>&nbsp;
							</td>
							<td><?php echo $subproyecto["estado"];?></td>
							<td class="actions">
								<?php if(!$subproyecto['aprobado'] && $subproyecto['presupuesto_path'] && $subproyecto["estado"]!="Rechazado" && $subproyecto["estado"]!="Anulado") echo $this->Html->link("Aprobar",array("controller"=>"subproyectos","action"=>"aprobarCotizacion",$subproyecto["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox")); ?>
								<?php if(!$subproyecto['aprobado'] && $subproyecto['presupuesto_path'] && $subproyecto["estado"]!="Rechazado" && $subproyecto["estado"]!="Anulado") echo $this->Html->link("Rechazar",array("controller"=>"subproyectos","action"=>"rechazarCotizacion",$subproyecto["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox")); ?>
							</td>
						</tr>
					<?php endforeach; 
					
					foreach ($proyecto["SolicitudProyecto"] as $solicitud):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class;?>>

							<td><span style="color:#e10000">Solicitud Nueva&nbsp;</span></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link(__('Revisar', true), array('controller'=>'solicitudProyectos','action' => 'view', $solicitud['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox")); ?>
								
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
				
					
			<div style="clear:both;"></div>
			<div style="clear:both;"></div>
			<div class="textAreaTitulo pestana3">Desarrollo Omega</div>
			<?php if($proyecto["Proyecto"]["desarrollo"]&&$proyecto["Proyecto"]["desarrollo"]!="") $value=$proyecto["Proyecto"]["desarrollo"]; else $value="Descripción de actividades u observaciones de la ejecucion del proyecto";?>
			<textarea id=desarrollo disabled="disabled" name="data[actividad]" modelId="<?php echo $proyecto["Proyecto"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				
		</div>
		
		<div class="panel_lateral">
				<?php echo $html->link("VER ARCHIVOS (".count($proyecto["ArchivoProyecto"]).")",array("controller"=>"archivoProyectos","action"=>"index",$proyecto["Proyecto"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $html->link("SUBIR ARCHIVOS",array("controller"=>"archivoProyectos","action"=>"add",$proyecto["Proyecto"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $html->link("SOLICITAR ADICIONAL",array("controller"=>"proyectos","action"=>"solicitudAdicional",$proyecto["Proyecto"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
					
		</div>
		<div style="clear:both;"></div>
		<br />
		<div class="pestana3">Comentarios / Observaciones</div>
		<div class="comentarios publicos">
			<?php echo $this->element("commentsproyecto",array("observacionesPublicas"=>$comentariosPublicos,"modelo"=>"Publicos"));?>
			<div style="clear:both;"></div>
		</div>			
	</div>
</div>


	<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $session->read("Auth.Usuario.id");?>"></div>
		<div id="equipo" proyectoId="<?php echo $proyecto["Proyecto"]["id"];?>"></div>
	</div>
<script> //SCRIPT para Registrar la ultima visita al equipo del usuario
var server="/omega/";
$.post(server+"proyectos/quitarPulicacionParaCliente",{"id":"<?php echo $proyecto["Proyecto"]["id"];?>"},function(data){
	
});
$(window).unload(function() {
	$.post(server+"proyectos/quitarPulicacionParaCliente",{"id":"<?php echo $proyecto["Proyecto"]["id"];?>"},function(data){
		
	});
});


</script>