<div class="historial contenedorEventos" nombre="<?php echo $session->read("Auth.Usuario.nombre");?>">
<?php 

foreach($eventos as $evento):?>
	<div class="observacion" id="evento">
		<div class="encabezado"> <div class="fecha"> <?php echo $evento["Evento"]["created"];?></div></div>
		<div class="cuerpo"><?php echo $evento["Evento"]["texto"];?></div>
	</div>
<?php 
endforeach;


?>
</div>
<div class="addComentario">
<?php 
	echo $form->create("Evento",array("action"=>"AJAX_add","id"=>"formularioEvento"));
	echo $form->input("contratos_equipo_id",array('type'=>'hidden',"value"=>$contratoEquipo["ContratosEquipo"]["id"],"id"=>"EventoContratoEquipo"));
	if($omega) echo $form->textArea("observacion",array("id"=>"textoEvento"));
	if($omega) echo $form->end("Agregar"); else echo $form->end();
	//debug($observacionesPublicas);
?>
</div>
