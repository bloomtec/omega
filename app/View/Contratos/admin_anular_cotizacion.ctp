<div class="aprobar">

<br />
<br />
<p>
	Por favor, digite el código de verificación y oprima el botón Aular Cotización.
</p>
<br />
<div class="verificacion"><?php echo $verificacion?></div>
<?php echo $this -> Form -> create("Contrato", array("controller" => "contratos", "action" => "confirmarAnulacion")); ?>
<?php echo $this -> Form -> input("verificacion", array("id" => "inputVerificacion", "label" => false, "div" => "verificacionInput")); ?>
<?php echo $this -> Form -> input("id", array("value" => $contratoId, "label" => false, "div" => "verificacionInput")); ?>
<div style="clear:both"></div>
<br />
<?php echo $this -> Form -> input("comentarios", array("id" => "inputVerificacion", "label" => "Comentarios")); ?>
<?php echo $this -> Form -> input('Email.body', array('label' => 'Mensaje Personalizado Para El Correo', 'type' => 'textarea')); ?>
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
</script>