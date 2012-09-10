<div class="guardar_cc">
	<?php
		if (!isset($flash)) {
			echo $this -> Form -> create("Contrato", array("action" => "ingresarCc"));
			echo $this -> Form -> input("id", array("value" => $contrato, "type" => "hidden"));
			echo $this -> Form -> input("centro_de_costo", array("id" => "centro_de_costo"));
			echo $this -> Form -> input("centro_de_costo2", array("id" => "centro_de_costo2", "label" => "Confirmar"));
			echo $this -> Form -> input("fecha_inicio_desarrollo");
			echo $this -> Form -> end("Guardar");
		} else {
			echo "Se ha guardado el centro de costo, ya puede iniciar el desarrollo";
		}
	?>
</div>
<script>
	$(document).ready(function() {
		$("form").submit(function() {

			var cc = ($("#centro_de_costo").val());
			var confirmacion = ($("#centro_de_costo2").val());
			if (cc == confirmacion) {

				return true;

			} else {
				alert("Verifique el centro de costo. Recuerde que el campo confirmacion debe ser igual al campo centro de costo");
				return false;
			}
		});

	});
</script>
