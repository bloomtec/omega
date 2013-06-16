<div class="clientes view">
<h2><span style="color:black;"><?php echo __('Empresa: ');?> </span><?php echo $empresa['Empresa']['nombre']; ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Identificación'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['identificacion']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email General'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['correo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contacto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['contacto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Teléfono'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $empresa['Empresa']['telefono']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Empresa', true), array('action' => 'edit', $empresa['Empresa']['id'])); ?> </li>		
	</ul>
</div>
<div class="related">
<?php
	// MANTENIMIENTOS
	if(
		isset($servicios[1])
		&& isset($this -> params['pass'][1])
		&& $this -> params['pass'][1] == 'mantenimientos'
	) {
		$serviciosPrestados = $empresa['Proyecto'];
		foreach ($serviciosPrestados as $key => $servicioPrestado) {
			if($servicioPrestado['servicio_id'] != 1) {
				unset($serviciosPrestados[$key]);
			}
		}
		echo $this -> element('empresas/mantenimientos', 'estadosContratosEjecucion');
	}
	// PROYECTOS
	if(
		isset($servicios[2])
		&& isset($this -> params['pass'][1])
		&& $this -> params['pass'][1] == 'proyectos'
	) {
		$serviciosPrestados = $empresa['Proyecto'];
		foreach ($serviciosPrestados as $key => $servicioPrestado) {
			if($servicioPrestado['servicio_id'] != 2) {
				unset($serviciosPrestados[$key]);
			}
		}
		echo $this -> element('empresas/proyectos', array('serviciosPrestados' => $serviciosPrestados));
	}
	// CALIDAD DE AIRE
	if(
		isset($servicios[3])
		&& isset($this -> params['pass'][1])
		&& $this -> params['pass'][1] == 'calidad'
	) {
		$serviciosPrestados = $empresa['Proyecto'];
		foreach ($serviciosPrestados as $key => $servicioPrestado) {
			if($servicioPrestado['servicio_id'] != 3) {
				unset($serviciosPrestados[$key]);
			}
		}
		echo $this -> element('empresas/calidad', array('serviciosPrestados' => $serviciosPrestados));
	}
	// INGENIERÍA
	if(
		isset($servicios[4])
		&& isset($this -> params['pass'][1])
		&& $this -> params['pass'][1] == 'ingenieria'
	) {
		$serviciosPrestados = $empresa['Proyecto'];
		foreach ($serviciosPrestados as $key => $servicioPrestado) {
			if($servicioPrestado['servicio_id'] != 4) {
				unset($serviciosPrestados[$key]);
			}
		}
		echo $this -> element('empresas/ingenieria', array('serviciosPrestados' => $serviciosPrestados));
	}
?>
</div>
<div style="display:none">
	<div id="usuario" usuarioId="<?php echo $this -> Session->read("Auth.User.id");?>"></div>
</div>
<script>
	var server="/";
	$(document).ready(function(){
		//$(".postventa").hide();		
		$(".post").toggle(
			function(){
				$(".postventa").show();
			},
			function(){
				$(".postventa").hide();
			}	
		);
		$(".cambioEstadoProyectoC").change(function() {
			$.post(server+"proyectos/AJAX_cambiarEstado",{"id":$(this).attr("modelId"),"estado_proyecto_id":$(this).val()},function(data){
				if(data=="NO"){
					alert("No se pudo Actualizar el estado por favor intentelo de nuevo");
				}else{
					alert(data);
				}
			});
		});	
	});
	$.each($(".equipo"), function(i, val){
		$.post(server+"equipos/AJAX_verificarVisitas",{"equipoId":$(val).attr("equipoId"),"usuarioId":"<?php echo $this -> Session->read('Auth.User.id');?>"},function(data){
			if(parseInt(data)>0){
				$(val).before("<img src='"+server+"img/alerta.gif' >");
			}else{
				$(val).before("<img src='"+server+"img/ninguno.gif' >");
			}
			//$(val).before(data);
		});	
	});
</script>