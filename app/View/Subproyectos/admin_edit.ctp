<div>
	<?php echo $this->Form->create('Subproyecto');?>
	<fieldset>
 		<legend><?php echo __('Editar sub proyecto'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('nombre');
			echo $this->Form->input('presupuesto_path',array("type"=>"hidden"));
			echo $this->Form->input('cronograma_path',array("type"=>"hidden"));
			echo $this->Form->input('presupuesto_path1',array("disabled"=>true,"value"=>$this->data["Subproyecto"]["presupuesto_path"]));
			echo $this->Form->input('cronograma_path1',array("disabled"=>true,"value"=>$this->data["Subproyecto"]["cronograma_path"]));		
		?>
		<label style="float:left; margin-right:10px; margin-top:5px;">Presupuesto: </label>
		<div id="presupuesto" path='/files'></div>
		<div class="uploadedPresupuesto"></div>
		<label style="float:left; margin-right:10px; margin-top:5px;">Cronograma: </label>
		<div id="cronograma" path='/files' ></div>
		<div class="uploadedCronograma"></div>
	</fieldset>
	<?php echo $this->Form->end(__('Guardar', true));?>
</div>
