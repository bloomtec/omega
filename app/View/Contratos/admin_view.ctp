<div class="contratos view">
<h2><span style="color:black;"><?php  __('Contrato: ');?></span> <?php echo $contrato['Contrato']['centro_de_costo']; ?><span style="color:black; font-size:12px;"> (centro de costo)</span></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cliente'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Cliente']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Contrato']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tipo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Tipo']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Estado']['nombre']; ?>
			&nbsp;
		</dd>
		<?php if($contrato['Contrato']['cotizacion']):?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cotización'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link("Ver",array("controller"=>"contratos","action"=>"verCotizacion",$contrato['Contrato']['id']),array("target"=>"_blank")) ?>
			&nbsp;
		</dd>
		<?php endif;?>
	
	
	
	
	
	</dl>
</div>
<div class="actions">
	<h3><?php __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Volver', true), __('Contratos', true)), array("controller"=>"clientes",'action' => 'view',$contrato['Contrato']['cliente_id'],"mantenimientos")); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Editar %s', true), __('Contrato', true)), array('action' => 'edit', $contrato['Contrato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('borrar %s', true), __('Contrato', true)), array('action' => 'delete', $contrato['Contrato']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contrato['Contrato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Lista de Correo', true), __('Contratos', true)), array("controller"=>"contratos",'action' => 'listaCorreo',$contrato['Contrato']['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?></li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Equipos Relacionados', true), __('Equipos', true));?></h3>
	<?php if (!empty($contrato['Equipo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Alertas'); ?></th>
		<th><?php __('Codigo Equipo'); ?></th>
		<th><?php __('Referencia'); ?></th>
		<th><?php __('Ficha Tecnica'); ?></th>
		
		<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contrato['Equipo'] as $equipo):
		$alarmaPublicacion=false;
		
				if($equipo["ContratosEquipo"]["tiene_publicacion_empresa"]) $alarmaPublicacion=true;
			
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td style="width:180px;">
				<?php echo $this->element("alertasContratos",array("alertas"=>array(),"cliente"=>false,"publicaciones"=>$alarmaPublicacion))?>
			</td>
			<td><?php echo $equipo['id'];?></td>
			<td><?php echo $equipo['referencia'];?></td>
			<td><?php if($equipo['ficha_tecnica']&&$equipo['ficha_tecnica']!="") echo $html->link("Ver Ficha",array("controller"=>"equipos","action"=>"verFicha",$equipo['id']));?></td>
	
			<td class="actions">
				<?php 
					if ($contrato['Tipo']['id']==1 ){
						echo $this->Html->link(__('Ver', true), array('controller' => 'equipos', 'action' => 'view', $equipo['id'],$contrato['Contrato']['id'],"mantenimiento"));
					}else{
						echo $this->Html->link(__('Ver', true), array('controller' => 'equipos', 'action' => 'view', $equipo['id'],$contrato['Contrato']['id'],"reparacion"));
					}
				 ?>
				<?php echo $this->Html->link(__('Editar', true), array('controller' => 'equipos', 'action' => 'edit', $equipo['id'],$contrato['Contrato']['id'])); ?>
				<?php echo $this->Html->link(__('Borrar', true), array('controller' => 'equipos', 'action' => 'delete', $equipo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $equipo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('Nuevo %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'add',$contrato["Contrato"]["id"]));?> </li>
			<li><?php echo $this->Html->link(sprintf(__('Relacionar %s', true), __('Equipo', true)), array('controller' => 'equipos', 'action' => 'relacionar',$contrato["Contrato"]["id"]));?> </li>
		
		</ul>
	</div>
</div>
<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $session->read("Auth.Usuario.id");?>"></div>
		
	</div>
<script>
var server="/omega/";
$.each($(".equipo"), function(i, val){
	$.post(server+"equipos/AJAX_verificarVisitas",{"equipoId":$(val).attr("equipoId"),"usuarioId":"<?php echo $session->read('Auth.Usuario.id');?>"},function(data){
		if(parseInt(data)>0){
			$(val).before("<img src='"+server+"img/alerta.gif' >");
		}else{
			$(val).before("<img src='"+server+"img/ninguno.gif' >");
			}
		//$(val).before(data);
	});	
});

</script>
