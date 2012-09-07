<div class="aprobar">
Aprobar la cotización significa que usted está de acuerdo con todos los terminos. 
<br />
<br />
<p>
	Por favor, digite el código de verificación y oprima el botón Aprobar Cotización.
</p>
<br />
<div class="verificacion"><?php echo $verificacion?></div>
<?php echo $form->create("Proyecto",array("controller"=>"proyectos","action"=>"confirmarAprobacion"));?>
<?php echo $form->input("verificacion",array("id"=>"inputVerificacion","label"=>false,"div"=>"verificacionInput"));?>
<?php echo $form->input("id",array("value"=>$proyectoId,"label"=>false,"div"=>"verificacionInput"));?>
<div style="clear:both"></div>
<br />
<?php echo $form->input("comentarios",array("id"=>"inputVerificacion","label"=>"Comentarios"));?>
<?php echo $form->end("Aprobar Cotización",array("class"=>"boton"));?>
<?php 
	//echo $html->link("Aprobar Cotización",array("controller"=>"contratos","action"=>"confirmarAprobacion",$contratoId,$this->Form->value('Contrato.comentarios')),array("class"=>"boton","style"=>"margin-left:40px;"));
	
?>
</div>
<script>
$(document).ready(function(){
	$("form").submit(function(){
		var numero=parseInt($("div.verificacion").text());
		var input=parseInt($("input#inputVerificacion").val());
		if(numero==input){
			return true;
			alert(input);
			}else{
				alert("Codigo de Verificación no valido");
				return false;
				}
	});
	
});