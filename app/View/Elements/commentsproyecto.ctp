<div class="historial" nombre="<?php echo $this -> Session -> read("Auth.User.nombre"); ?>">
<?php 
if($modelo=="Publico") {
	foreach($observacionesPublicas as $observacion) :
	//debug($observacion);
?>
	<div class="observacion <?php echo $observacion["Usuario"]["role"] ?>">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["nombre_de_usuario"]; ?>:</div>  <div class="fecha"> <?php echo $observacion["Observacion"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $observacion["Observacion"]["comentario"]; ?></div>

	</div>
<?php
	endforeach;
	} else {
		foreach($observacionesPrivadas as $observacion) :
?>
	<div class="observacion privada">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["username"]; ?>:</div>  <div class="fecha"> <?php echo $observacion["Observacion"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $observacion["Observacion"]["texto"]; ?></div>
	</div>
<?php
		endforeach;
	}
?>
</div>
<div class="addComentario">
<?php
	echo $this -> Form -> create("comentario" . $modelo, array("action" => "AJAX_add"));
	echo $this -> Form -> input("usuario_id", array('type' => 'hidden', "value" => $this -> Session -> read("Auth.User.id")));
	echo $this -> Form -> input("proyecto_id", array('type' => 'hidden', "value" => $proyecto["Proyecto"]["id"]));
	echo $this -> Form -> textArea("observacion", array("id" => "observacion"));
	echo $this -> Form -> end("Agregar");
	//debug($observacionesPublicas);
?>
</div>