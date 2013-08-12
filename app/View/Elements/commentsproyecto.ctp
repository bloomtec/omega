<div class="historial" nombre="<?php echo $this -> Session -> read("Auth.User.nombre"); ?>">
<?php
if($modelo=="Publico") {
	foreach($observacionesPublicas as $observacion) :
	//debug($observacion);
?>
	<div class="observacion <?php echo $observacion["Usuario"]["rol"] ?>">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["nombre_de_usuario"]; ?>:</div>  <div class="fecha"> <?php echo $observacion["Observacion"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $observacion["Observacion"]["texto"]; ?></div>

	</div>
<?php
	endforeach;
	} else {
		foreach($observacionesPrivadas as $observacion) :
?>
	<div class="observacion privada">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["nombre_de_usuario"]; ?>:</div>  <div class="fecha"> <?php echo $observacion["Observacion"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $observacion["Observacion"]["texto"]; ?></div>
	</div>
<?php
		endforeach;
	}
?>
</div>
<div class="addComentario" style="position: relative">
<?php
	//echo $this -> Form -> create("comentario" . $modelo, array("action" => "AJAX_add"));
	echo $this -> Form -> create("Observacion", array("action" => "AJAX_addComentario".$modelo));
	echo $this -> Form -> input("usuario_id", array('type' => 'hidden', "value" => $this -> Session -> read("Auth.User.id")));
	echo $this -> Form -> input("proyecto_id", array('type' => 'hidden', "value" => $proyecto["Proyecto"]["id"]));
	if($modelo == "Publico" && (isset($this -> params['prefix']) && $this -> params['prefix'] == 'admin')) {
		echo $this -> Form -> textArea(
			"observacion",
			array(
				"id" => "observacion",
				"placeholder" => "Verifique su ortografía y redacción , recuerde que todo lo que se escriba aquí será revisado por el cliente."
			)
		);
	} else {
		echo $this -> Form -> textArea(
			"observacion",
			array(
				"id" => "observacion"
			)
		);
	}
echo '<div class="comments_overlay" style="width:100%;height: 32px; background: #000000; opacity: 0.3; position:absolute; color:white; text-align: center; display:none;"> Enviando... </div>';

echo $this -> Form -> end("AGREGAR");
	//debug($observacionesPublicas);
?>
</div>