<div class="historial contenedorEventos" nombre="<?php echo $this -> Session -> read("Auth.User.nombre"); ?>">
<?php foreach($eventos as $evento): ?>
	<div class="observacion" id="evento">
		<div class="encabezado"> <div class="fecha"> <?php echo $evento["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $evento["texto"]; ?></div>
	</div>
<?php endforeach; ?>
</div>
<div class="addComentario">
<?php
	echo $this -> Form -> create("EventosServicio", array("action" => "AJAX_add", "id" => "formularioEventosServicios"));
	echo $this -> Form -> hidden("modelo", array("value" => "Proyecto"));
	echo $this -> Form -> hidden("llave_foranea", array("value" => $proyecto["Proyecto"]["id"]));
	echo $this -> Form -> hidden("usuario", array("value" => $this -> Session -> read("Auth.User.nombre") . " " . $this -> Session -> read("Auth.User.apellido")));
	if ($omega)
		echo $this -> Form -> textArea("observacion", array("id" => "textoEvento", 'placeholder' => 'Verifique su ortografía y redacción, recuerde que todo lo que se escriba aquí será revisado por el cliente.'));
	if ($omega)
		echo $this -> Form -> end("AGREGAR");
	else
		echo $this -> Form -> end();
	//debug($observacionesPublicas);
?>
</div>