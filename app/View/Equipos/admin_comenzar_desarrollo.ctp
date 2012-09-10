<div class="equipos form">_
<?php if(!$mensaje){?>
<?php echo $this->Form->create('Equipo',array("action"=>"comenzarDesarrollo"));?>
	<fieldset>
 		<legend>Añadir Equipo</legend>
	<?php
		echo $this->Form->input('ContratosEquipo.id',array("value"=>$contratoEquipoId));
	
	?>
	
	<?php
		echo $this->Form->input('ContratosEquipo.inicio_desarrollo');
	
	?>
	</fieldset>

<?php echo $this->Form->end(__('Guardar', true));?>
<?php }else{?>
Se ha introducido la fecha del inicio del desarrollo.
<?php } ?> 
</div>