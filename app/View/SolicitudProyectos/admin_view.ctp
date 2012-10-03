<div>
<h2><?php echo __('Solicitud Proyecto');?></h2>
	<dl style="width:100%;"><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Proyecto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($solicitudProyecto['Proyecto']['nombre'], array('controller' => 'proyectos', 'action' => 'view', $solicitudProyecto['Proyecto']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Texto Solicitud'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $solicitudProyecto['SolicitudProyecto']['texto_solicitud']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Añadir Sub Proyecto'), array("controller"=>"subproyectos",'action' => 'add', $solicitudProyecto['Proyecto']['id'],$solicitudProyecto['SolicitudProyecto']['id'])); ?> </li>
		
	</ul>
</div>
