<div class="add" style="margin-left:10px;">

<?php 
	echo $form->create("Proyecto",array("action"=>"solicitarProyecto"));
	echo $form->input("cliente_id",array("type"=>"hidden","value"=>$clienteId));
	echo $form->input("texto_solicitud",array("type"=>"texarea","label"=>"Solicitud de Proyectos"));
	echo $form->end("Enviar");

?>
</div>