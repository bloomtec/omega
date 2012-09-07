
<?php 
 $dias = Array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
 $meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Nombre","Diciembre");
	$date=getdate(strtotime($date));	
	//debug($date);
 $mes=$meses[$date["mon"]-1];
 $dia=$dias[$date["wday"]-1];
?>
<div class="calendario">
	<div class="mes"><?php echo $mes;?></div>
	<div class="dia"><?php echo $date["mday"];?></div>
	<div class="ano"><?php echo $date["year"];?></div>
	<div class="titulo"><?php echo $titulo;?></div>
</div>
