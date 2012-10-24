<?php //debug($this -> Session -> read('Auth')); ?>
<div class="historial" nombre="<?php echo $this -> Session -> read("Auth.User.nombre"); ?>">
<?php 
if($modelo=="Publica") {
foreach($observacionesPublicas as $observacion):?>
	<div class="observacion <?php echo $observacion["Usuario"]["rol"]; ?>">
		<div class="encabezado"><div class="nombre"><?php echo $observacion["Usuario"]["nombre_de_usuario"]; ?>:</div>  <div class="fecha"> <?php echo $observacion["Observacion"]["created"]; ?></div></div>
		<div class="cuerpo"><?php echo $observacion["Observacion"]["texto"]; ?></div>
	</div>
	<?php
		endforeach;
		} else {
		foreach($observacionesPrivadas as $observacion):
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
<div class="addComentario">
<?php
	echo $this -> Form -> create("Observacion", array("action" => "AJAX_addObservacion".$modelo));
	echo $this -> Form -> input("usuario_id", array('type' => 'hidden', "value" => $usuario_id));
	echo $this -> Form -> input("contratos_equipo_id", array('type' => 'hidden', "value" => $contratoEquipo["ContratosEquipo"]["id"]));
	//echo $this -> Form -> textArea("observacion", array("id" => "observacion"));
	if($modelo == "Publica" && (isset($this -> params['prefix']) && $this -> params['prefix'] == 'admin')) {
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
	echo $this -> Form -> end("AGREGAR");
?>
</div>