<?php 
if(!isset($flash)){
	echo $form->create("Contrato",array("action"=>"iniciarDesarrollo"));
	echo $form->input("id",array("value"=>$contrato,"type"=>"hidden"));
	echo $form->input("fecha_inicio_desarrollo");
	echo $form->end("Iniciar Desarrollo");
}else{
	echo "Se ha comenzado el desarrollo del contrato, en la opcion 'Ver' se listan todos los equipos que pertenecen a este contrato.";
}
?>