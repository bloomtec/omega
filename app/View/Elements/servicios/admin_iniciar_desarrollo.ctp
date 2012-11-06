<?php 
if(!isset($flash)){
	echo $this -> Form->create("Contrato",array("action"=>"iniciarDesarrollo"));
	echo $this -> Form->input("id",array("value"=>$contrato,"type"=>"hidden"));
	echo $this -> Form->input("fecha_inicio_desarrollo");
	echo $this -> Form->end("Iniciar Desarrollo");
}else{
	echo "Se ha comenzado el desarrollo del contrato, en la opcion 'Ver' se listan todos los equipos que pertenecen a este contrato.";
}
?>