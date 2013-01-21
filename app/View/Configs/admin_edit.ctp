<div class="configs form">
	<?php echo $this -> Form -> create('Config'); ?>
	<fieldset>
		<legend><?php echo __('Configuración Del Backup'); ?></legend>
		<?php
			echo $this -> Form -> input('id');
			echo $this -> Form -> hidden('backup');
		?>
		<div style="float:left; clear:none; width: 45%;">
			<h3>Días de la semana</h3>
			<?php
				echo $this -> Form -> input('lunes', array('type' => 'checkbox'));
				echo $this -> Form -> input('martes', array('type' => 'checkbox'));
				echo $this -> Form -> input('miercoles', array('type' => 'checkbox'));
				echo $this -> Form -> input('jueves', array('type' => 'checkbox'));
				echo $this -> Form -> input('viernes', array('type' => 'checkbox'));
				echo $this -> Form -> input('sabado', array('type' => 'checkbox'));
				echo $this -> Form -> input('domingo', array('type' => 'checkbox'));
			?>
		</div>
		<div style="float:left; clear:none; width: 45%;">
			<h3>Hora del día</h3>
			<?php echo $this -> Form -> input('hora', array('type' => 'select', 'options' => $horas)); ?>
		</div>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar Configuración')); ?>
</div>
<br />
<br />
<div class="configs files form">
	<form>
		<fieldset>
			<legend>Backups Realizados</legend>
			<table>
				<thead>
					<th><?php echo 'Archivo'; //$this -> paginator -> sort('Archivo.filename', 'Archivo'); ?></th>
					<th><?php echo 'Fecha Y Hora'; //$this -> paginator -> sort('Archivo.created', 'Fecha Y Hora'); ?></th>
					<th>Acciones</th>
				</thead>
				<tbody>
					<?php foreach ($archivos as $key => $archivo): ?>
					<tr>
						<td><?php echo $archivo['filename']; ?></td>
						<td><?php echo $archivo['created']; ?></td>
						<td class="actions">
							<?php echo $this -> Html -> link(__('Restaurar', true), array('action' => 'restore', $archivo['filename'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
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
		</fieldset>
	</form>
</div>