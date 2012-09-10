<div class="equipos form">
<?php echo $this->Form->create('Equipo');?>
	<fieldset>
 		<legend><?php echo __('Modificar Equipo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this -> Form -> input('categorias_equipo_id', array('empty' => 'Seleccione...'));
		//echo $this->Form->input('referencia');
		echo $this -> Form -> input('codigo', array('label' => 'Código'));
		echo $this->Form->input('descripcion', array('label' => 'Descripción'));
		//echo $this->Form->input('ficha_tecnica');
	//	echo $this->Form->input('proxima_revision');
	//	echo $this->Form->input('mensajes_pendientes');
		//echo $this->Form->input('Contrato');
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Guardar', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Aciones'); ?></h3>
	<ul>
		<li><?php echo $this -> Html->link("Volver",array("controller"=>"contratos","action"=>"view",$contrato));?></li>	
	</ul>
</div>