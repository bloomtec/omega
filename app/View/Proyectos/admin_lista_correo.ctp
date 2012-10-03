<div class="correos">
<h2><?php echo __('Lista de Correos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>

			<th>Nombre</th>
			<th>Email</th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($correos as $correo):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class; ?>>
		<td><?php echo $correo['nombre']; ?>&nbsp;</td>
		<td><?php echo $correo['correo']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this -> Html -> link(__('Borrar', true), array('controller' => 'proyectos', 'action' => 'borrarCorreo', $correo['id'], $proyectoId), null, sprintf(__('Esta seguro que quiere eliminar el correo?', true), $correo['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
<div class="actions">
	<h3><?php __('Añadir correo'); ?></h3>
	<?php
		echo $this -> Form -> create("Proyecto", array("action" => "crearCorreo", "id" => "crearCorreoForm"));
		echo $this -> Form -> input("proyecto_id", array("type" => "hidden", "value" => $proyectoId));
		echo $this -> Form -> input("nombre", array("id" => "inputNombre"));
		echo $this -> Form -> input("correo", array("id" => "inputEmail", 'type' => 'email'));
		echo $this -> Form -> end("Guardar");
	?>

</div>
