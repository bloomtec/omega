<div class="contenedorAlerta">
	<div class="campana">
	<?php 
	$alertasValidas=array();
		if($cliente){
			foreach($alertas as $alerta){
				if($alerta["para_empresa"]) $alertasValidas[]=$alerta;
				
			}
		}else{
			foreach($alertas as $alerta){
				if(!$alerta["para_empresa"]) $alertasValidas[]=$alerta;
				
			}
		}
		//
		if($alertasValidas||$publicaciones){
			//Pone campana roja
			echo $this -> Html->image("alerta.gif");
		}else{
			//Pone campana gris
			echo $this -> Html->image("ninguno.gif");
		}
	?>
	
	</div>
	<div class="alarmas">
	 	<?php if($publicaciones):?>
	 	<div class="renglon_alerta""><div class="texto_alerta">Hay Publicaciones</div></div>
	 	<?php endif;?>
		<?php foreach($alertasValidas as $alerta):?>
			<div class="renglon_alerta" id="<?php echo $alerta["id"]?>"><div class="texto_alerta"><?php echo $alerta["texto"]?></div><div class="eliminarAlarma" id="<?php echo $alerta["id"]?>">X</div></div>
		<?php endforeach; ?>		
	</div>
</div>
<script>
$(document).ready(function(){
	var server="/";
	$(".eliminarAlarma").click(function(){
		var alarmaId=$(this).attr("id");
		$.post(server+"contratos/AJAX_eliminarAlarma",{"alarmaId":alarmaId},function(data){
				if(data=="SI"){
					$("#"+alarmaId).remove();

				}
			});
		});
});
</script>