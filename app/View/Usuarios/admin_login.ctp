<div class="login">
	<div class="wrapper">
		<div class="titulo">
			ACCESO a <span class="bold">Empleados de OMEGA</span>
		</div>
		<p>
			SICLOM &infin; un compromiso de ¡TODOS!.
		</p>
		<?php
		echo $this -> Session -> flash('auth');
		echo $this -> Form -> create('Usuario', array('action' => 'login'));
		echo $this -> Form -> input('nombre_de_usuario', array('required' => 'required'));
		echo $this -> Form -> input('contraseña', array('type' => 'password', 'required' => 'required'));
		echo $this -> Form -> end('Acceder');
		?>
	</div>
	<ul>
		<li>
			<?php echo $this -> Html -> link("Regresar al HOME", "http://www.omegaingenieros.com"); ?>
			<?php echo $this -> Html -> link("Recordar", array("action" => "recordar")); ?>
		</li>
	</ul>
</div>