<div class="historial contenedorEventos" nombre="<?php echo $this -> Session -> read("Auth.User.nombre"); ?>">
<?php foreach($eventos as $evento): ?>
	<div class="observacion" id="evento">
		<div class="encabezado"> <div class="fecha"> <?php echo $evento["Evento"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $evento["Evento"]["texto"]; ?></div>
	</div>
<?php
		endforeach;
	?>
</div>
<div class="addComentario">
<?php
	echo $this -> Form -> create("Evento", array("action" => "AJAX_add", "id" => "formularioEvento"));
	echo $this -> Form -> input("contratos_equipo_id", array('type' => 'hidden', "value" => $contratoEquipo["ContratosEquipo"]["id"], "id" => "EventoContratoEquipo"));
	if ($omega)
		echo $this -> Form -> textArea("observacion", array("id" => "textoEvento", 'placeholder' => 'Verifique su ortografía y redacción, recuerde que todo lo que se escriba aquí será revisado por el cliente.'));
	if ($omega)
		echo $this -> Form -> end("AGREGAR");
	else
		echo $this -> Form -> end();
	//debug($observacionesPublicas);
?>
</div>