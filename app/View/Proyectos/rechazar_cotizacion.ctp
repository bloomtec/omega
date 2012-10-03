<div class="aprobar">
	<table cellpadding="0" cellspacing="0">
		<tr><td>Fecha De Entrega</td><td><?php echo $proyecto['Proyecto']['fecha_de_entrega']; ?></td></tr>
		<tr><td>Fecha De Inicio</td><td><?php echo $proyecto['Proyecto']['fecha_de_inicio']; ?></td></tr>
		<tr><td>Cotización</td><td><?php echo $this -> Html -> link("Ver Cotización", array("controller" => "proyectos", "action" => "verCotizacion", $proyecto['Proyecto']['id'])); ?></td></tr>
		<tr><td>Cronograma</td><td><?php echo $this -> Html -> link($this -> Html -> image('/img/Calendario.png', array('title' => 'Ver Cronograma', 'alt' => 'Ver Cronograma', 'height' => '25')), array("controller" => "proyectos", "action" => "verCronograma", $proyecto['Proyecto']['id']), array('escape' => false)); ?></td></tr>
		<tr><td>Responsable Comercial</td><td><?php echo $proyecto['Proyecto']['responsable_comercial']; ?></td></tr>
		<tr><td>Descripción</td><td><?php echo $proyecto['Proyecto']['descripcion']; ?></td></tr>
		<tr><td>Comentarios</td><td><?php echo $proyecto['Proyecto']['comentarios']; ?></td></tr>
	</table>
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