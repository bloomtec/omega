<div class="contratos form">
	<?php echo $this->Form->create('Contrato');?>
	<fieldset>
 		<legend><?php echo __('Añadir Contrato'); ?></legend>
		<?php
			//echo $this->Form->input('cliente',array("type"=>"text","disabled"=>true,"class"=>"clienteNombre"));
			//echo $this->Form->input('cliente_id',array("class"=>"clienteId","showEmpty"=>true,"after"=>'<div class="buscarEmpresa modalInput" rel="#yesno">Buscar</div>'));		
		?>	
		<?php
			echo $this->Form->input('empresa_id',array("type"=>"hidden","value"=>$empresaId));
			echo $this->Form->input('nombre');
			echo $this->Form->input('tipo_id');
			echo $this->Form->input('estado_id',array("type"=>"hidden","value"=>1));
			//echo $this->Form->input('centro_de_costo');
			//echo $this->Form->input('fecha_inicio_desarrollo');
			//echo $this->Form->input('fecha_finalizado');
			//echo $this->Form->input('diagnostico');
			//echo $this->Form->input('cotizacion');
			//echo $this->Form->input('Equipo');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Guardar', true));?>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array("controller"=>"empresas",'action' => 'view',$empresaId,"mantenimientos"));?></li>
	</ul>
</div>
<div class="modal" id="yesno">
	<h2>Seleccione el Empresa propietario del Equipo <button class="close"> Cerrar </button></h2>
	<div class="filtros">
		<div class="filtro">
			<label>Identificacion</label>
			<input class="identificacion" type="text"/>
		</div>
		<div class="filtro">
			<label>Razon Social / Nombre</label>
			<input class="nombre" type="text"/>
		</div>
	</div>
	<p>
		<?php foreach($empresasAll as $empresa):?>
		<div class="cliente" id="<?php echo $empresa["Empresa"]["id"];?>" nombre="<?php echo $empresa["Empresa"]["nombre"];?>"> 
			<div class="label"> Razon Social:</div><div class="filtroNombre"><?php echo $empresa["Empresa"]["nombre"]?></div>
			<div class="label"> Identificación:</div><div class="filtroIdentificacion"><?php echo $empresa["Empresa"]["identificacion"]?></div>
		</div>
		<?php endforeach;?>
	</p>

	<!-- yes/no buttons -->
	
</div>