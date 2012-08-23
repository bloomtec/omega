<div class="login">
	<div class="wrapper">
		<div class="titulo">
			ACCESO a <span class="bold">Empleados de OMEGA</span>
		</div>
		<p>
			Ingrese su nombre de usuario y su contraseña asignada para acceder a la plataforma de clientes y proyectos Omega Ingenieros.
		</p>
		<?php
		echo $this -> Session -> flash('auth');
		echo $this -> Form -> create('Usuario', array('action' => 'login'));
		echo $this -> Form -> input('username', array("label" => "Nombre de Usuario"));
		echo $this -> Form -> input('password', array("label" => "Contraseña"));
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