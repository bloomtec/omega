<div class="aprobar">
	<br />
	<br />
	<p>
		Ayúdenos a mejorar. Por favor indíquenos el motivo del rechazo de la cotización	
	</p>
	<br />
	<div class="verificacion"><?php echo $verificacion?></div>
	<?php echo $this -> Form -> create("Proyecto", array("controller" => "proyectos", "action" => "confirmarRechazo")); ?>
	<?php echo $this -> Form -> input("verificacion", array("id" => "inputVerificacion", "label" => false, "div" => "verificacionInput")); ?>
	<?php echo $this -> Form -> input("id", array("value" => $proyectoId, "label" => false, "div" => "verificacionInput")); ?>
	<div style="clear:both"></div>
	<br />
	<?php echo $this -> Form -> input("comentarios", array("id" => "inputVerificacion", "label" => "Comentarios")); ?>
	<p>
		<!--  Por favor, digite el código de verificación y oprima el botón Rechazar Cotización.-->
	</p>
	<?php echo $this -> Form -> end("Rechazar Cotización", array("class" => "boton")); ?>
</div>
<script>
	$(document).ready(function() {
		$("form").submit(function() {
			var numero = parseInt($("div.verificacion").text());
			var input = parseInt($("input#inputVerificacion").val());
			if (numero == input) {
				return true;
				alert(input);
			} else {
				alert("Codigo de Verificación no valido");
				return false;
			}
		});

	}); 
</script>