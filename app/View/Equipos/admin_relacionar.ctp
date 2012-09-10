<div class="equipos form">
<?php // debug($contratosCompleto);?>
<?php echo $this->Form->create('Equipo');?>

	<fieldset>
 		<legend><?php echo __('Añadir Equipo'); ?> al contrato <?php echo $contratos[$contratoId];?></legend>
	<?php
	$i=0;
		foreach ($contratosCompleto as $contrato){
			$equipos=array();
				foreach($contrato["Equipo"] as $equipo){
					if(!isset($equiposDelContrato[$equipo["id"]])){
						$equipos[$equipo["id"]]=$equipo["referencia"];
					}
				}
			if($equipos){
				echo "<div class='bloqueContrato'>";
					echo $this->Form->label($contrato["Contrato"]["centro_de_costo"]."-".$contrato["Contrato"]["nombre"]);
					echo $this->Form->input("Equipos.".$contrato["Contrato"]["id"],array("multiple"=>"checkbox","options"=>$equipos,"div"=>"equiposDeContrato","label"=>false));
				echo "</div>";
			}
	
			
		}
		//echo $this->Form->input('referencia');
		//echo $this->Form->input('descripcion');
		//echo $this->Form->input('ficha_tecnica');
		//echo $this->Form->input('proxima_revision');
		//echo $this->Form->input('mensajes_pendientes');
		echo $this->Form->input('Contrato.Contrato.0',array("type"=>"hidden","value"=>$contratoId));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar', true));?>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Volver'), array('controller' => 'contratos','action' => 'view',$contratoId));?></li>
		
	</ul>
</div>
<script>
	$(document).ready(function(){
		$('input[type="checkbox"]').change(function(){
			var value=$(this).val();
			var cheked=$(this).attr("checked");
				if(cheked){
					$('input[type="checkbox"][value="'+value+'"]').attr("checked",true);
					}else{
						$('input[type="checkbox"][value="'+value+'"]').attr("checked",false);
				}
		});
	});
</script>