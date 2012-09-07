<div class="correos">
<h2><?php __('Lista de Correos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>

			<th>Nombre</th>
			<th>Email</th>
			<th class="actions"><?php __('Acciones');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($correos as $correo):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $correo['nombre']; ?>&nbsp;</td>
		<td><?php echo $correo['email']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Borrar', true), array('controller'=>'contratos','action' => 'borrarCorreo', $correo['id'],$contratoId), null, sprintf(__('Esta seguro que quiere eliminar el correo?', true), $correo['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
<div class="actions">
	<h3><?php __('Añadir correo'); ?></h3>
	<?php 
		echo $form->create("Contrato",array("action"=>"crearCorreo","id"=>"crearCorreoForm"));
		echo $form->input("contrato_id",array("type"=>"hidden","value"=>$contratoId));
		echo $form->input("nombre",array("id"=>"inputNombre"));
		echo $form->input("email",array("id"=>"inputEmail"));
		echo $form->end("Guardar");
	?>

</div>
