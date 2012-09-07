<div class="historial" nombre="<?php echo $session->read("Auth.Usuario.nombre");?>">
<?php 
if($modelo=="Publicas"){
foreach($observacionesPublicas as $observacion):?>
	<div class="observacion <?php echo$observacion["Usuario"]["role"] ?>">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["username"];?>:</div>  <div class="fecha"> <?php echo $observacion["ObservacionPublica"]["created"];?></div></div>
		<div class="cuerpo"><?php echo $observacion["ObservacionPublica"]["observacion"];?></div>
	</div>
<?php 
endforeach;
}else{
foreach($observacionesPrivadas as $observacion):?>
<div class="observacion privada">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["username"];?>:</div>  <div class="fecha"> <?php echo $observacion["ObservacionPrivada"]["created"];?></div></div>
		<div class="cuerpo"><?php echo $observacion["ObservacionPrivada"]["observacion"];?></div>
	</div>
<?php 
endforeach;
}

?>
</div>
<div class="addComentario">
<?php 
	echo $form->create("observacion".$modelo,array("action"=>"AJAX_add"));
	echo $form->input("usuario_id",array('type'=>'hidden',"value"=>$session->read("Auth.Usuario.id")));
	echo $form->input("contratos_equipo_id",array('type'=>'hidden',"value"=>$contratoEquipo["ContratosEquipo"]["id"]));
	echo $form->textArea("observacion",array("id"=>"observacion"));
	echo $form->end("Agregar");
	//debug($observacionesPublicas);
?>
</div>
