<?php
	$servicios = array(
		'proyectos' => 2,
		'calidad' => 3,
		'ingenieria' => 4
	);
	$servicio_id = $servicios[$this -> params['pass'][1]];
	$titulo = 'Creación De Proyecto';
	if($servicio_id == 3) {
		$titulo .= ' De Calidad De Aire';
	} elseif($servicio_id == 4) {
		$titulo .= ' De Ingeniería';
	}
?>
<div class="proyectos form">
<?php echo $this -> Form -> create('Proyecto'); ?>
	<fieldset>
 		<legend><?php echo __($titulo); ?></legend>
		<?php
		echo $this -> Form -> hidden('servicio_id', array('value' => $servicio_id));
		echo $this -> Form -> hidden('empresa_id', array("value" => $empresaId));
		echo $this -> Form -> input('estado_proyecto_id', array("type" => "hidden", "value" => 1));
		echo $this -> Form -> input('nombre');
		//echo $this->Form->input('centro_de_costo');
		echo $this -> Form -> input('fecha_de_inicio');
		echo $this -> Form -> hidden('cotizacion', array('autocomplete' => 'off'));
		echo $this -> Form -> hidden('cronograma', array('autocomplete' => 'off'));
		?>
		<label style="float:left; margin-right:10px; margin-top:5px;">Cotización: </label>
		<div id="cotizacion" path='/files'></div>
		<div class="uploaded"></div>
		<label style="float:left; margin-right:10px; margin-top:5px;">Cronograma: </label>
		<div id="procrono" path='/files' ></div>
		<div class="uploadedCronograma"></div>
		<?php
		echo $this -> Form -> input('responsable_comercial');
		echo $this -> Form -> input('correo_comercial');
		echo $this -> Form -> input('centro_de_costo');
		$usuarios = $this -> requestAction("/usuarios/getOmega");
		echo $this -> Form -> input('supervisor', array("type" => "select", "options" => $usuarios, 'empty' => 'Seleccione Supervisor...'));
		echo $this -> Form -> input('encargado', array("type" => "select", "options" => $usuarios, "label" => "Ingeniero", 'empty' => 'Seleccione Ingeniero...'));
		echo $this -> Form -> input('descripcion', array("label" => "Descripción"));
		echo $this -> Form -> input('correos', array('label' => 'Correos (Formato: Nombre &lt;correo&gt;, Nombre 2 &lt;correo 2&gt;, ...)</code>', 'type' => 'textarea'));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar', true)); ?>
	<div class="actions" style="display: inherit;">
		<!--<h3><?php echo __('Acciones'); ?></h3>-->
		<ul>		
			<li>
				<?php
					//echo $this -> Html -> link("Volver", array('controller' => 'empresas', 'action' => 'view', $empresaId));
				?>
				<a href="<?php echo $referer; ?>">Volver</a>
			</li>
		</ul>
	</div>
</div>