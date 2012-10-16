<div class="login">
	<div class="wrapper">
		<p>
			Ingrese su correo eléctronico.
		</p>
	<?php
		   echo $this -> Session->flash('auth');
		   echo $this -> Form->create('Usuario', array('action' => 'recordar'));
		    echo $this -> Form->input('email',array("label"=>"email"));
		    echo $this -> Form->end('Acceder');
		?>
	</div>

</div>