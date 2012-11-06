<div class="add" style="margin-left:10px;">
	<?php
	echo $this -> Form -> create("Proyecto", array("action" => "solicitarProyecto"));
	echo $this -> Form -> input("empresa_id", array("type" => "hidden", "value" => $empresaId));
	echo $this -> Form -> input("texto_solicitud", array("type" => "texarea", "label" => "Solicitud de Proyectos"));
	echo $this -> Form -> end("Enviar");
	?>
</div>