<h2>Por favor Seleccione el Archivo a subir</h2>
<?php //debug(substr($this -> params['pass'][0], 0, 1)); ?>
<div id="upload" path='/files' message="La Ficha Tecnica ha sido subida con exito" controller="equipos" action="AJAX_subirFicha" modelId="<?php echo substr($this -> params['pass'][0], 0, 1); ?>"></div>
<div class="uploaded"></div>