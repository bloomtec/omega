<div class="equipos faces admin">
	<div class="marcoEquipo">
		<div class="lineaSuperior">
			<div class="info">
				<span style="color:#e10000">
					<?php echo $proyecto['Proyecto']["nombre"];?>
				</span>
				<?php echo $this -> Html -> link("volver", array("controller"=>"empresas","action"=>"view",$proyecto["Proyecto"]["empresa_id"],"proyectos"),array("style"=>"font-size:10px;vertical-align:top;"));?>
			</div>
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
					<th class="actions"><?php echo __('Acciones');?></th>
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
										echo $this->Html->link("ver PDF",array("controller"=>"subproyectos","action"=>"verPresupuesto", $subproyecto['id'])); 
										}else{
											
										}
								?>&nbsp;
							</td>
							<td>
								<?php if($subproyecto['cronograma_path']){
										echo $this->Html->link("ver PDF",array("controller"=>"subproyectos","action"=>"verCronograma", $subproyecto['id'])); 
										}else{
											
										}
								?>&nbsp;
							</td>
							<td><?php echo $subproyecto["estado"];?></td>
							<td class="actions">
								<?php // echo $this->Html->link(__('View', true), array("controller"=>"subproyectos",'action' => 'view', $subproyecto['id'])); ?>
								<?php if($subproyecto["estado"]!="Anulado" && $subproyecto["estado"]!="Rechazado") echo $this->Html->link(__('Editar', true), array("controller"=>"subproyectos",'action' => 'edit', $subproyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
								<?php if($subproyecto["estado"]!="Anulado" && $subproyecto["estado"]!="Rechazado") echo $this->Html->link(__('anular', true), array("controller"=>"subproyectos",'action' => 'anularCotizacion', $subproyecto['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox"));?>
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
							<td>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link(__('Revisar', true), array('controller'=>'solicitudProyectos','action' => 'view', $solicitud['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"thickbox")); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
					
		
				<div style="clear:both;"></div>
				<table>
					<?php echo $this -> Form -> create('Proyecto'); ?>
					<?php echo $this -> Form -> hidden('id', array('value' => $proyecto['Proyecto']['id'])); ?>
					<?php echo $this -> Form -> hidden('control_ejecucion', array('autocomplete' => 'off')); ?>
					<tbody id="ServiceDataTBody">
						<tr>
							<td>
								<label style="float:left; margin-right:10px; margin-top:5px;">CONTROL DE EJECUCIÓN</label>
								<div id="upload_control_ejecucion" path="/files" controller="proyectos" action="AJAX_subirControlEjecucion" model_id="<?php echo $proyecto['Proyecto']['id']; ?>"></div>
							</td>
							<td class="uploaded" style="max-width: 150px;"><?php //echo $this -> Form -> end('SUBIR'); ?></td>
						</tr>
						<?php if(!empty($proyecto['Proyecto']['cronograma'])) : ?>
						<tr><td>Cronograma</td><td id="CronogramaView"><?php echo $this -> Html -> link($this -> Html -> image('/img/Calendario.png', array('title' => 'Ver Cronograma', 'alt' => 'Ver Cronograma', 'height' => '25')), array("controller" => "proyectos", "action" => "verCronograma", $proyecto['Proyecto']['id']), array('escape' => false)); ?></td></tr>
						<?php endif; ?>
						<?php if(!empty($proyecto['Proyecto']['control_ejecucion'])) : ?>
						<tr id="ControlViewRow"><td>Control De Ejecución</td><td id="ControlView"><?php echo $this -> Html -> link($this -> Html -> image('/img/Calendario.png', array('title' => 'Ver Control De Ejecución', 'alt' => 'Ver Cronograma', 'height' => '25')), array("controller" => "proyectos", "action" => "verControlEjecucion", $proyecto['Proyecto']['id']), array('escape' => false)); ?></td></tr>
						<?php endif; ?>
					</tbody>
				</table>
				<div class="pestana3">Bitácora</div>
				<div class="comentarios eventos">
					<?php echo $this->element("eventsproyecto",array("eventos"=>$eventos,"modelo"=>"EventosServicio","omega"=>true));?>
					<div style="clear:both;"></div>
				</div>	
				<div style="clear:both;"></div>
				<!--		
				<div class="textAreaTitulo pestana3">Bitácora</div>
				<?php if($proyecto["Proyecto"]["desarrollo"]&&$proyecto["Proyecto"]["desarrollo"]!="") $value=$proyecto["Proyecto"]["desarrollo"]; else $value="Descripción de actividades u observaciones de la ejecucion del proyecto";?>
				<textarea id=desarrollo disabled="disabled" name="data[actividad]" modelId="<?php echo $proyecto["Proyecto"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>
				
					<div class="textArearBotones">
						<div class="textAreaBoton editar">editar</div>
						<div class="textAreaBoton guardarDesarrollo guardar" modelId="<?php echo $proyecto["Proyecto"]["id"];?>">guardar</div>
						<div class="textAreaBoton cancelar" valor="<?php echo $value?>">cancelar</div>
					</div>
				-->
				</div>
			
			<div class="panel_lateral">
				<?php echo $this -> Html -> link('CATEGORÍAS ARCHIVO', array('controller' => 'categorias_archivos', 'action' => 'index'), array("class"=>"boton", 'target' => '_BLANK')); ?>
				<?php echo $this->Html->link("VER ARCHIVOS (".count($proyecto["Archivo"]).")",array("controller"=>"archivoProyectos","action"=>"index",$proyecto["Proyecto"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link("SUBIR ARCHIVOS",array("controller"=>"archivoProyectos","action"=>"add",$proyecto["Proyecto"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link('AÑADIR SUB PROYECTO', array("controller"=>"subproyectos",'action' => 'add', $proyecto['Proyecto']['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array('style' => 'font-size:12px;', "class"=>"boton thickbox"));?>
				<?php echo $this->Html->link('LISTA DE CORREOS', array("controller"=>"proyectos",'action' => 'listaCorreo',$proyecto['Proyecto']['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
			</div>
				<div style="clear:both;"></div>
			<br />
				<?php //debug($comentariosPrivados); ?>
				<div class="pestana3">Chat con cliente</div>
				<div class="comentarios publicos">
					<?php echo $this->element("commentsproyecto",array("observacionesPublicas"=>$comentariosPublicos,"modelo"=>"Publico"));?>
					<div style="clear:both;"></div>
				</div>
				<div style="border:3px dashed #E10000;">
				<div class="pestana3 ">Chat interno</div>
				<div class="comentarios privados" style="margin-top:0;">
					<?php echo $this->element("commentsproyecto",array("observacionesPrivadas"=>$comentariosPrivados,"modelo"=>"Privado"));?>
					<div style="clear:both;"></div>
				</div>			
			</div>
	</div>


	<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $this->Session->read("Auth.User.id");?>"></div>
		<div id="equipo" proyectoId="<?php echo $proyecto["Proyecto"]["id"];?>"></div>
	</div>
<script> //SCRIPT para Registrar la ultima visita al equipo del usuario
var server="/";
$.post(server+"proyectos/quitarPulicacionParaOmega",{"id":"<?php echo $proyecto["Proyecto"]["id"];?>"},function(data){
	
});
$(window).unload(function() {
	$.post(server+"proyectos/quitarPulicacionParaOmega",{"id":"<?php echo $proyecto["Proyecto"]["id"];?>"},function(data){
		
	});

});
$(function(){
		$('.historial').scrollTop(10000);

	});
</script>