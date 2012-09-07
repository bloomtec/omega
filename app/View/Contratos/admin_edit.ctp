<div class="guardar_cc">


<?php 
	if(!isset($flash)){
	echo $form->create("Contrato",array("action"=>"ingresarCc"));
	echo $form->input("id",array("value"=>$contrato,"type"=>"hidden"));
	echo $form->input("nombre");
	echo $form->input("centro_de_costo",array("id"=>"centro_de_costo"));
	echo $form->input("centro_de_costo2",array("id"=>"centro_de_costo2","label"=>"Confirmar"));
	echo $form->input("fecha_inicio_desarrollo");
	echo $form->end("Guardar");
	}else{
		echo "Se ha guardado el centro de costo, ya puede iniciar el desarrollo";
	}
	

?>
<script>


$(document).ready(function(){
	$("form").submit(function(){

		var cc=($("#centro_de_costo").val());
		var confirmacion=($("#centro_de_costo2").val());
		if(cc==confirmacion){
		
			return true;
		
			}else{
				alert("Verifique el centro de costo. Recuerde que el campo confirmacion debe ser igual al campo centro de costo");
				return false;
				}
	});
	
});
</script>
