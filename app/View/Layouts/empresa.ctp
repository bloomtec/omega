<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this -> Html -> charset(); ?>
		<title>
			<?php __('ZONA OMEGA'); ?>
			<?php echo $title_for_layout; ?>
		</title>
		<?php
		echo $this -> Html -> meta('icon');

		echo $this -> Html -> css('cake.generic');
		echo $this -> Html -> css('thickbox');
		echo $this -> Html -> css('cake.generic');
		echo $this -> Html -> css('superfish');
		echo $this -> Html -> script('jquery.min');
		echo $this -> Html -> script("jquery.tools.min");
		echo $this -> Html -> script('jquery.uploadify.v2.1.4.min');
		echo $this -> Html -> script("swfobject");
		echo $this -> Html -> script("thickbox");
		echo $this -> Html -> script("common");
		echo $this -> Html -> script("upload");
		echo $this -> Html -> script('superfish');

		echo $scripts_for_layout;
		?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div class="wrap">
					<div class="llave"><?php echo $this -> Html -> link($this -> Html -> image("llave.png", array("alt" => "Volver al inicio")), array("controller" => "empresas"), array('escape' => false)); ?></div>
					<div class="titulo" style="font-size:21px; text-decoration:none; font-style:italic">ESTIMADO CLIENTE,<br /> Gracias por emplear nuestra herramienta<span style="font-weight:bold; font-style:italic"> SICLOM &infin; </div>
					<div class="logo">
						<?php echo $this -> Html -> image("logo.png"); ?>
						<br />
						<br />
						<?php if($this -> action != "login") echo $this -> element('menu');?>
					</div>
					
				</div>
			</div>
			<div id="content">
				<?php echo $this -> Session -> flash(); ?>
	
				<?php echo $content_for_layout; ?>
	
			</div>
			<div id="footer">
				<?php echo $this -> Html -> link("developed by: " . $this -> Html -> image("bloom_negro.png", array("height" => 12)), 'http://www.bloomweb.co', array('style' => 'margin-right: 40px;', 'target' => '_blank', 'escape' => false)); ?>
			</div>
		</div>
		<?php echo $this -> element('sql_dump'); ?>
	</body>
</html>