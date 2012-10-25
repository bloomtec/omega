
<div class="equipos form">
<?php if(!$mensaje){?>
<?php echo $this->Form->create('Equipo',array("action"=>"addProximaRevision"));?>
	<fieldset>
 		<legend>Proxima Revisión</legend>
	<?php
		echo $this->Form->hidden('ContratosEquipo.id',array("value"=>$contratoEquipoId));
	
	?>
	
	<?php
		echo $this->Form->input('ContratosEquipo.proxima_revision',array('type'=>'datetime'));
	
	?>
	</fieldset>

<?php echo $this->Form->end(__('Guardar', true));?>
<?php }else{?>
	Se ha introducido la fecha de la proxima revisión del Equipo.
<?php } ?> 
</div>
