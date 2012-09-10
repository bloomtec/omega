<?php
	if($tipoContrato!="mantenimiento") {
		if($contratoEquipo["ContratosEquipo"]["fase_id"]==1):?>
	<div class="equipos faces admin">
	
	<h3><span style="color:black">Mantenimiento</span></h3>
		<div class="marcoEquipo">
			
			
			<div class="lineaSuperior">
				<div class="info"><span style="color:#e10000"><?php echo $contrato['Empresa']["nombre"];?></span><span style="color:#a5a5a4"><?php echo $this->Html->link(" - ".$equipo['Equipo']["referencia"],array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"text-decoration:none;color:#a5a5a4 "));?></span> <?php echo $this->Html->link("volver",array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"font-size:10px;vertical-align:top;"));?></div>
				<div class="accionesFicha">
					<?php if($equipo["Equipo"]["ficha_tecnica"]) echo $this->Html->link("VER FICHA TECNICA",array("controller"=>"equipos","action"=>"verFicha",$equipo["Equipo"]["id"]),array("class"=>"boton","target"=>"_blank"));?>
					
				</div>
			</div>
			<div style="clear:both;"></div>			
			<div class=panelInformativo>
				
				<div class="areaInformativa">
				<div class="textAreaTitulo pestana3">DIAGNOSTICO</div>
				<?php if($contratoEquipo["ContratosEquipo"]["diagnostico"]&&$contratoEquipo["ContratosEquipo"]["diagnostico"]!="") $value=$contratoEquipo["ContratosEquipo"]["diagnostico"]; else $value="El cliente debe aprobar Cotizaci�n";?>
				<textarea id=diagnostico disabled="disabled" name="data[actividad]" modelId="<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				

				</div>
	
				<div style="clear:both;"></div>
			
				<div class="pestana3">Comentarios / Observaciones</div>
				<div class="comentarios publicos">
				
					<?php echo $this->element("comments",array("observacionesPublicas"=>$observacionesPublicas,"modelo"=>"Publica"));?>
					<div style="clear:both;"></div>
				</div>
	
			</div>
			
			
	
			
			<div class="panel_lateral">
				<?php echo $this->Html->link("VER ARCHIVOS (".count($equipo["Archivo"]).")",array("controller"=>"archivos","action"=>"index",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link("SUBIR ARCHIVOS",array("controller"=>"archivos","action"=>"add",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				
				<?php if($contratoEquipo["ContratosEquipo"]["fase_id"]==1):?>
				
				<div style="clear:both;" ></div>
				<?php endif;?>
			</div>
			<div class="panel_lateral down">
			<div class="centro_costo"><?php echo $contrato["Contrato"]["centro_de_costo"];?></div>
			<div class="centro_costo_label">Cod. centro de costo</div>
				<div style="clear:both;" ></div>
			</div>
	
		
		
		</div>
	</div>
	<?php 
	
	endif;
	
	if($contratoEquipo["ContratosEquipo"]["fase_id"]==2):?>
	<div class="equipos faces admin">
	
	<h3><span style="color:black">Mantenimiento</span>  </h3>
		<div class="marcoEquipo">
			
			
			<div class="lineaSuperior">
				<div class="info"><span style="color:#e10000"><?php echo $contrato['Empresa']["nombre"];?></span><span style="color:#a5a5a4"><?php echo $this->Html->link(" - ".$equipo['Equipo']["referencia"],array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"text-decoration:none;color:#a5a5a4 "));?></span> <?php echo $this->Html->link("volver",array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"font-size:10px;vertical-align:top;"));?></div>
				<div class="accionesFicha">
				
					<?php if($equipo["Equipo"]["ficha_tecnica"]) echo $this->Html->link("VER FICHA TECNICA",array("controller"=>"equipos","action"=>"verFicha",$equipo["Equipo"]["id"]),array("class"=>"boton","target"=>"_blank"));?>
					
				</div>
			</div>
			<div style="clear:both;"></div>
			
			
			<div class=panelInformativo>
				
				<div class="areaInformativa">
				<div class="textAreaTitulo pestana3">DIAGNOSTICO</div>
				<?php if($contratoEquipo["ContratosEquipo"]["diagnostico"]&&$contratoEquipo["ContratosEquipo"]["diagnostico"]!="") $value=$contratoEquipo["ContratosEquipo"]["diagnostico"]; else $value="El cliente debe aprobar Cotizaci�n";?>
				<textarea id=diagnostico disabled="disabled" name="data[actividad]" modelId="<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				
			
				</div>
	
				<div style="clear:both;"></div>
			
				<div class="pestana3">Comentarios / Observaciones</div>
				<div class="comentarios publicos">
				
					<?php echo $this->element("comments",array("observacionesPublicas"=>$observacionesPublicas,"modelo"=>"Publica"));?>
					<div style="clear:both;"></div>
				</div>
				
			</div>
			
			
	
			
			<div class="panel_lateral">
				<?php echo $this->Html->link("VER ARCHIVOS (".count($equipo["Archivo"]).")",array("controller"=>"archivos","action"=>"index",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link("SUBIR ARCHIVOS",array("controller"=>"archivos","action"=>"add",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<div class="fecha_inicip"><?php echo $this->element("calendar",array("date"=>$contratoEquipo["ContratosEquipo"]["inicio_desarrollo"],"titulo"=>"Fecha Inicio Desarrollo"));?></div>
		
			</div>
			<div class="panel_lateral down">
			<div class="centro_costo"><?php echo $contrato["Contrato"]["centro_de_costo"];?></div>
			<div class="centro_costo_label">Cod. centro de costo</div>
				<div style="clear:both;" ></div>
			
			</div>
	
		
		
		</div>
	</div>
	<?php 
	
	endif;
	
	if($contratoEquipo["ContratosEquipo"]["fase_id"]==3):?>
	<div class="equipos faces admin">
	
	<h3><span style="color:black">Mantenimiento</span>   </h3>
		<div class="marcoEquipo">
			
			
			<div class="lineaSuperior">
				<div class="info"><span style="color:#e10000"><?php echo $contrato['Empresa']["nombre"];?></span><span style="color:#a5a5a4"><?php echo $this->Html->link(" - ".$equipo['Equipo']["referencia"],array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"text-decoration:none;color:#a5a5a4 "));?></span> <?php echo $this->Html->link("volver",array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"font-size:10px;vertical-align:top;"));?></div>
				<div class="accionesFicha">
				
					<?php if($equipo["Equipo"]["ficha_tecnica"]) echo $this->Html->link("VER FICHA TECNICA",array("controller"=>"equipos","action"=>"verFicha",$equipo["Equipo"]["id"]),array("class"=>"boton","target"=>"_blank"));?>
					
				</div>
			</div>
			<div style="clear:both;"></div>
			
			
			<div class=panelInformativo>
				
				<div class="areaInformativa" style="width:295px; float:left;">
				<div class="textAreaTitulo pestana3">Actividad Concluida</div>
				<?php if($contratoEquipo["ContratosEquipo"]["actividades_concluida"]&&$contratoEquipo["ContratosEquipo"]["actividades_concluida"]!="") $value=$contratoEquipo["ContratosEquipo"]["actividades_concluida"]; else $value="Descripción de reparaciones o actividades realizadas y entregadas satisfactoriamente";?>
				<textarea style="width:300px;" id=diagnostico disabled="disabled" name="data[actividad]" modelId="<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				
					
				</div>
				<div class="areaInformativa" style="width:295px; float:left;">
				<div class="textAreaTitulo pestana3">Observaciones</div>
				<?php if($contratoEquipo["ContratosEquipo"]["observaciones_finales"]&&$contratoEquipo["ContratosEquipo"]["observaciones_finales"]!="") $value=$contratoEquipo["ContratosEquipo"]["observaciones_finales"]; else $value="Comentarios de proximas revisiones o ajustes";?>
				<textarea style="width:300px;" id=diagnostico disabled="disabled" name="data[actividad]" modelId="<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>" valor="<?php echo $value?>"><?php echo $value?></textarea>	
				
					
				</div>	
				<div style="clear:both;"></div>
			
				<div class="pestana3">Comentarios / Observaciones</div>
				<div class="comentarios publicos">
				
					<?php echo $this->element("comments",array("observacionesPublicas"=>$observacionesPublicas,"modelo"=>"Publica"));?>
					<div style="clear:both;"></div>
				</div>
				
			</div>
			
			
	
			
			<div class="panel_lateral">
				<?php echo $this->Html->link("VER ARCHIVOS (".count($equipo["Archivo"]).")",array("controller"=>"archivos","action"=>"index",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link("SUBIR ARCHIVOS",array("controller"=>"archivos","action"=>"add",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<div class="fecha_inicip"><?php echo $this->element("calendar",array("date"=>$contratoEquipo["ContratosEquipo"]["fecha_finalizacion"],"titulo"=>"Fecha Finalización"));?></div>
				<?php //debug($contratoEquipo["ContratosEquipo"]);?>
			</div>
			<div class="panel_lateral down">
			<div class="centro_costo"><?php echo $contrato["Contrato"]["centro_de_costo"];?></div>
			<div class="centro_costo_label">Cod. centro de costo</div>
				<div style="clear:both;" ></div>
			<?php if($contratoEquipo["ContratosEquipo"]["fase_id"]==2) echo $this->Html->link("FINALIZAR",array("controller"=>"equipos","action"=>"finalizar",$equipo["Equipo"]["id"],$tipoContrato),array("class"=>"boton"));?>
			
			</div>
	
		
		
		</div>
	</div>
	<?php 
	
	endif;
		


}else{ // Si el contrato es de mantenimiento?>
	<div class="equipos faces admin">
	
	<h3><span style="color:black">Mantenimiento</span> </h3>
		<div class="marcoEquipo">
			
			
			<div class="lineaSuperior">
				<div class="info"><span style="color:#e10000"><?php echo $contrato['Empresa']["nombre"];?></span><span style="color:#a5a5a4"><?php echo $this->Html->link(" - ".$equipo['Equipo']["codigo"],array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"text-decoration:none;color:#a5a5a4 "));?></span> <?php echo $this->Html->link("volver",array("controller"=>"contratos","action"=>"view",$contrato["Contrato"]["id"]),array("style"=>"font-size:10px;vertical-align:top;"));?></div>
				<div class="accionesFicha">
				
					<?php if($equipo["Equipo"]["ficha_tecnica"]) echo $this->Html->link("VER FICHA TECNICA",array("controller"=>"equipos","action"=>"verFicha",$equipo["Equipo"]["id"]),array("class"=>"boton","target"=>"_blank"));?>
					
				</div>
			</div>
			<div style="clear:both;"></div>
			
			
			<div class=panelInformativo>
				<br />
				<div class="pestana3">Eventos Realizados</div>
				<div class="comentarios eventos">
				
					<?php echo $this->element("events",array("eventos"=>$eventos,"modelo"=>"Eventos","omega"=>false));?>
					<div style="clear:both;"></div>
				</div>
	
				<div style="clear:both;"></div>
				<br />
				<br />
				<br />
			
				<div class="pestana3">Comentarios / Observaciones</div>
				<div class="comentarios publicos">
				
					<?php echo $this->element("comments",array("observacionesPublicas"=>$observacionesPublicas,"modelo"=>"Publica"));?>
					<div style="clear:both;"></div>
				</div>

			</div>
			<div class="panel_lateral">
				<?php echo $this->Html->link("VER ARCHIVOS (".count($equipo["Archivo"]).")",array("controller"=>"archivos","action"=>"index",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
				<?php echo $this->Html->link("SUBIR ARCHIVOS",array("controller"=>"archivos","action"=>"add",$equipo["Equipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?>
					
			</div>
			<div class="panel_lateral down">
			<div class="centro_costo"><?php echo $contrato["Contrato"]["centro_de_costo"];?></div>
			<div class="centro_costo_label">Cod. centro de costo</div>
			<?php 
				if($contratoEquipo["ContratosEquipo"]["fase_id"]==2){
						if($contratoEquipo["ContratosEquipo"]["proxima_revision"]) echo '<div class="fecha_inicip">'.$this->element("calendar",array("date"=>$contratoEquipo["ContratosEquipo"]["proxima_revision"],"titulo"=>"Proxima Revisión")).'</div>';
					//	 echo $this->Html->link("PROXIMA REVISION",array("controller"=>"equipos","action"=>"addProximaRevision",$contratoEquipo["ContratosEquipo"]["id"],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));
					} 
			?>
				<div style="clear:both;" ></div>
			</div>
	
		
		
		</div>
	</div>
<?php }?>

	<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $this->Session->read("Auth.Usuario.id");?>"></div>
		<div id="equipo" equipoId="<?php echo $equipo["Equipo"]["id"];?>"></div>
	</div>
<script> //SCRIPT para Registrar la ultima visita al equipo del usuario
var server="/omega/";
$.post(server+"equipos/AJAX_registrarVisita",{"contratos_equipo_id":"<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>","usuarioId":"<?php echo $this->Session->read('Auth.User.id');?>"},function(data){
	
});
$(window).unload(function() {
	$.post(server+"equipos/AJAX_registrarVisita",{"contratos_equipo_id":"<?php echo $contratoEquipo["ContratosEquipo"]["id"];?>","usuarioId":"<?php echo $this->Session->read('Auth.User.id');?>"},function(data){
		
	});;
});
</script>