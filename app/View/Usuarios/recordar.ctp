<div class="login">
	<div class="wrapper">
		<p>
			Ingrese su correo eléctronico.
		</p>
	<?php
		   echo $session->flash('auth');
		   echo $form->create('Usuario', array('action' => 'recordar'));
		    echo $form->input('email',array("label"=>"email"));
		    echo $form->end('Acceder');
		?>
	</div>

</div>