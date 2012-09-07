<div class="historial" nombre="<?php echo $session->read("Auth.Usuario.nombre");?>">
<?php 
if($modelo=="Publicos"){
	
foreach($observacionesPublicas as $observacion):
//debug($observacion);?>
	<div class="observacion <?php echo$observacion["Usuario"]["role"] ?>">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["username"];?>:</div>  <div class="fecha"> <?php echo $observacion["ComentarioPublico"]["created"];?></div></div>
		<div class="cuerpo"><?php echo $observacion["ComentarioPublico"]["comentario"];?></div>

	</div>
<?php 
endforeach;
}else{
foreach($observacionesPrivadas as $observacion):?>
<div class="observacion privada">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["username"];?>:</div>  <div class="fecha"> <?php echo $observacion["ComentarioPrivado"]["created"];?></div></div>
		<div class="cuerpo"><?php echo $observacion["ComentarioPrivado"]["comentario"];?></div>
	</div>
<?php 
endforeach;
}

?>
</div>
<div class="addComentario">
<?php 
	echo $form->create("comentario".$modelo,array("action"=>"AJAX_add"));
	echo $form->input("usuario_id",array('type'=>'hidden',"value"=>$session->read("Auth.Usuario.id")));
	echo $form->input("proyecto_id",array('type'=>'hidden',"value"=>$proyecto["Proyecto"]["id"]));
	echo $form->textArea("observacion",array("id"=>"observacion"));
	echo $form->end("Agregar");
	//debug($observacionesPublicas);
?>
</div>
