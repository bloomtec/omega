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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Cotización'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this -> Html->link("Ver",array("controller"=>"contratos","action"=>"verCotizacion",$contrato['Contrato']['id']),array("target"=>"_blank")) ?>
			&nbsp;
		</dd>
		<?php endif;?>
	</dl>
</div>
<div class="actions" style="display: inherit;">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array("controller"=>"empresas",'action' => 'view',$contrato['Contrato']['empresa_id'],"mantenimientos")); ?> </li>
		<li><?php echo $this->Html->link(__('Editar Contrato'), array('action' => 'edit', $contrato['Contrato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Borrar Contrato'), array('action' => 'delete', $contrato['Contrato']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contrato['Contrato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista de Correo'), array("controller"=>"contratos",'action' => 'listaCorreo',$contrato['Contrato']['id'],"?KeepThis=true&TB_iframe=true&height=400&width=600"),array("class"=>"boton thickbox"));?></li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Categorías Equipo');?></h3>
	<?php $categorias_equipo = $this -> requestAction('/categorias_equipos/get/' . $contrato['Empresa']['id']); ?>
	<?php //debug($categorias_equipo); ?>
	<?php if (!empty($categorias_equipo)): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Categoría'); ?></th>
		<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($categorias_equipo as $categoria_equipo_id => $categoria_equipo_nombre):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $categoria_equipo_nombre; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Editar', true), array('controller' => 'categorias_equipos', 'action' => 'edit', $contrato['Contrato']['empresa_id'], $contrato['Contrato']['id'], $categoria_equipo_id)); ?>
				<?php echo $this->Html->link(__('Borrar', true), array('controller' => 'categorias_equipos', 'action' => 'delete', $categoria_equipo_id, $contrato['Contrato']['id']), null, sprintf(__('¿Seguro desea eliminar %s?'), $categoria_equipo_nombre)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Nueva Categoria'), array('controller' => 'categorias_equipos', 'action' => 'add', $contrato["Empresa"]["id"], $contrato['Contrato']['id']));?> </li>
		</ul>
	</div>
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
			foreach ($equipos as $key => $equipo):
				$alarmaPublicacion=false;
				if($equipo['Contrato'][0]["tiene_publicacion_empresa"]) $alarmaPublicacion=true;
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
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
					if ($contrato['Tipo']['id']==1 ) {
						echo $this->Html->link(__('Ver', true), array('controller' => 'equipos', 'action' => 'view', $equipo['Equipo']['id'],$contrato['Contrato']['id'],"mantenimiento"));
					} else {
						echo $this->Html->link(__('Ver', true), array('controller' => 'equipos', 'action' => 'view', $equipo['Equipo']['id'],$contrato['Contrato']['id'],"reparacion"));
					}
				?>
				<?php echo $this->Html->link(__('Editar', true), array('controller' => 'equipos', 'action' => 'edit', $equipo['Equipo']['id'],$contrato['Contrato']['id'])); ?>
				<?php //echo $this->Html->link(__('Borrar', true), array('controller' => 'equipos', 'action' => 'delete', $equipo['id']), null, sprintf(__('¿Seguro desea borrar el equipo con código %s?'), $equipo['codigo'])); ?>
				<?php
					if($equipo['Equipo']['activo']) {
						echo $this -> Form -> postLink(__('Desactivar'), array('controller' => 'equipos', 'action' => 'disable', $equipo['Equipo']['id'], $contrato['Contrato']['id']), null, __('¿Seguro desea desactivar el equipo %s?', $equipo['Equipo']['codigo']));
					} else {
						echo $this -> Form -> postLink(__('Activar'), array('controller' => 'equipos', 'action' => 'enable', $equipo['Equipo']['id'], $contrato['Contrato']['id']), null, __('¿Seguro desea activar el equipo %s?', $equipo['Equipo']['codigo']));
					}
					if($this -> requestAction('/equipos/canBeDeleted/' . $equipo['Equipo']['id'] . '/' . $contrato['Contrato']['id'])) {
						echo $this -> Form -> postLink(__('Eliminar'), array('controller' => 'equipos', 'action' => 'eliminarEquipoDeContrato', $equipo['Equipo']['id'], $contrato['Contrato']['id']), null, __('¿Seguro desea eliminar el equipo %s DE ESTE CONTRATO? (El equipo seguirá en el sistema a menos que no exista en otros contratos)', $equipo['Equipo']['codigo']));
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
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Nuevo Equipo'), array('controller' => 'equipos', 'action' => 'add',$contrato["Contrato"]["id"]));?> </li>
			<li><?php echo $this->Html->link(__('Relacionar Equipo'), array('controller' => 'equipos', 'action' => 'relacionar',$contrato["Contrato"]["id"]));?> </li>
		</ul>
	</div>
</div>
<div style="display:none">
	<div id="usuario" usuarioId="<?php echo $this -> Session-> read("Auth.User.id"); ?>"></div>		
</div>
<script>
var server="/";
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