<div class="index">
<?php echo $this->Form->create('Proyecto'); ?>
	<fieldset>
 		<legend>Solicitud Adicional</legend>
	<?php
		echo $this->Form->input('SolicitudProyecto.proyecto_id',array("type"=>"hidden","value"=>$proyectoId));
		echo $this->Form->input('SolicitudProyecto.texto_solicitud',array("type"=>"textArea","label"=>false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Solicitar', true));?>
</div>