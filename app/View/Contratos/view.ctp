<div class="contratos view">
<h2><span style="color:black;"><?php echo __('Contrato: ');?></span> <?php echo $contrato['Contrato']['centro_de_costo']; ?><span style="color:black; font-size:12px;"> (centro de costo)</span></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Empresa'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Empresa']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Contrato']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Tipo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Tipo']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Estado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contrato['Estado']['nombre']; ?>
			&nbsp;
		</dd>
		<?php if($contrato['Contrato']['cotizacion']):?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Cotizacion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link("Ver",array("controller"=>"contratos","action"=>"verCotizacion",$contrato['Contrato']['id']),array("target"=>"_blank")) ?>
			&nbsp;
		</dd>
		<?php endif;?>
	</dl>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array("controller"=>"empresas", 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Equipos Relacionados');?></h3>
	<?php if (!empty($contrato['Equipo'])):?>
	<table>
		<?php echo $this -> Form -> create('Contrato'); ?>
		<tr><th>Código</th><th>Categoría Equipo</th><th></th></tr>
		<tr>
			<td><?php echo $this -> Form -> input('codigo', array('label' => false)); ?></td>
			<td><?php echo $this -> Form -> input('categorias_equipo_id', array('label' => false, 'empty' => 'Seleccione...')); ?></td>
			<td><?php echo $this -> Form -> end('Buscar Equipo'); ?></td>
		</tr>
	</table>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Alertas'); ?></th>
			<th><?php echo $this -> paginator -> sort('codigo', 'Código'); ?></th>
			<th><?php echo $this -> paginator -> sort('descripcion', 'Descripción'); ?></th>
			<th><?php echo $this -> paginator -> sort('categorias_equipo_id', 'Categoría'); ?></th>
			<th><?php echo __('Ficha Tecnica'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
		</tr>
		<?php
			$i = 0;
			//foreach ($contrato['Equipo'] as $equipo):
			foreach ($equipos as $equipo):
				$alarmaPublicacion=false;
				if($equipo['Contrato'][0]["ContratosEquipo"]["tiene_publicacion_omega"]) $alarmaPublicacion=true;
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				//debug($equipo);
		?>
		<tr<?php echo $class;?>>
			<td style="width:180px;">
				<?php echo $this->element("alertasContratos",array("alertas"=>array(),"cliente"=>true,"publicaciones"=>$alarmaPublicacion))?>
			</td>
			<td><?php echo $equipo['Equipo']['codigo'];?></td>
			<td><?php echo $equipo['Equipo']['descripcion'];?></td>
			<td><?php if(isset($equipo['CategoriasEquipo']['nombre'])) echo $equipo['CategoriasEquipo']['nombre'];?></td>
			<td><?php if($equipo['Equipo']['ficha_tecnica']&&$equipo['Equipo']['ficha_tecnica']!="") echo $this->Html->link("Ver Ficha",array("controller"=>"equipos","action"=>"verFicha",$equipo['Equipo']['id']), array('target'=>'_BLANK'));?></td>
			<td class="actions">
				<?php 
					if ($contrato['Tipo']['id']==1 ){
						echo $this->Html->link(__('Ver'), array('controller' => 'equipos', 'action' => 'view', $equipo['Equipo']['id'],$contrato['Contrato']['id'],"mantenimiento"));
					}else{
						echo $this->Html->link(__('Ver'), array('controller' => 'equipos', 'action' => 'view', $equipo['Equipo']['id'],$contrato['Contrato']['id'],"reparacion"));
					}
				 ?>				
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<p>
	<?php echo $this -> Paginator -> counter(array('format' => __('Página {:page} de {:pages}. Mostrando {:current} registros de un total de {:count}. Inicia con el  {:start} y termina con el {:end}'))); ?>
</p>
<div class="paging">
	<?php
	echo $this -> Paginator -> first('<< ', array(), null, array('class' => 'prev disabled'));
	echo $this -> Paginator -> prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
	echo $this -> Paginator -> numbers(array('separator' => ''));
	echo $this -> Paginator -> next(__('siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	echo $this -> Paginator -> last(' >>', array(), null, array('class' => 'next disabled'));
	?>
</div>
</div>
<div style="display:none">
		<div id="usuario" usuarioId="<?php echo $this->Session->read("Auth.User.id");?>"></div>		
</div>
<script>
var server="/";
$.each($(".equipo"), function(i, val){
	$.post(server+"equipos/AJAX_verificarVisitas",{"contrato_id":<?php echo $contrato['Contrato']["id"];?>,"usuarioId":"<?php echo $this->Session->read('Auth.User.id');?>"},function(data){
		if(parseInt(data)>0){
			$(val).before("<img src='"+server+"img/alerta.gif' >");
		}else{
			$(val).before("<img src='"+server+"img/ninguno.gif' >");
			}
		//$(val).before(data);
	});	
});
</script>