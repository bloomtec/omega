<div class="aprobar">
<br />
<br />
<p>
	Por favor digite el codigo de verificación y oprima el boton Anular Cotización.
</p>
<br />
<div class="verificacion"><?php echo $verificacion?></div>
<?php echo $this -> Form -> create("Proyecto", array("controller" => "proyectos", "action" => "confirmarAnulacion")); ?>
<?php echo $this -> Form -> input("verificacion", array("id" => "inputVerificacion", "label" => false, "div" => "verificacionInput")); ?>
<?php echo $this -> Form -> input("id", array("value" => $proyectoId, "label" => false, "div" => "verificacionInput")); ?>
<div style="clear:both"></div>
<br />
<?php echo $this -> Form -> input("comentarios", array("id" => "inputVerificacion", "label" => "Comentarios")); ?>
<?php echo $this -> Form -> end("Anular Cotización", array("class" => "boton")); ?>
<?php
	//echo $html->link("Aprobar Cotización",array("controller"=>"contratos","action"=>"confirmarAprobacion",$contratoId,$this->Form->value('Contrato.comentarios')),array("class"=>"boton","style"=>"margin-left:40px;"));
?>
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
