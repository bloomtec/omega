$(document).ready(function() {
	
	var server = '/'
	var path = '/files';
	var message = $('#upload').attr('message');
	var controller = $('#upload').attr('controller');
	var action = $('#upload').attr('action');
	var id = $('#upload').attr('modelId');
	
	$('#upload').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'fileDesc' : 'Documentos PDF (*.pdf)',
		'fileExt' : '*.pdf',
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var path = "/files";
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			var category = $('#categoria_archivo_id option:selected').val();
			//var name=path+"/"+c.name;

			if (controller && action) {
				$.post(server + controller + "/" + action, {
					"id" : id,
					"path" : name,
					"category" : category
				}, function(data) {
					if (data != "NO") {
						$(".uploaded").html(data);
					}
				});
			} else {
				$(".uploaded").html(message);
			}

		}
	});
	
	//SUBIR CONTROL DE EJECUCIÓN
	$('#upload_control_ejecucion').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var path = "/files";
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			//var name=path+"/"+c.name;
			$("#ProyectoControlEjecucion").val(name);
			$.post(server + $('#upload_control_ejecucion').attr('controller') + "/" + $('#upload_control_ejecucion').attr('action'), {
				"id" : $('#upload_control_ejecucion').attr('model_id'),
				"path" : name
			}, function(data) {
				if (data != "NO") {
					$(".uploaded").html(data);
				}
				$('#ControlViewRow').remove();
				$('#ServiceDataTBody').append(
					'<tr id="ControlViewRow"><td>Control De Ejecución</td><td id="ControlView"><a href="/admin/proyectos/verControlEjecucion/' + $('#upload_control_ejecucion').attr('model_id') + '"><img height="25" alt="Ver Cronograma" title="Ver Control De Ejecución" src="/img/Calendario.png"></a></td></tr>'
				);
			});
		}
	});
	
	//SUBIR COTIZACIÓN
	$('#cotizacion').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var path = $('#cotizacion').attr('path');
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			//var name=path+"/"+c.name;
			$("#ProyectoCotizacion").val(name);
			$("#ProyectoCotizacion1").val(name);
			$(".uploaded").html("Se ha subido con exito la cotización");
			$(".uploadedCotizacion").html("Se ha subido con exito la cotización");
		}
	});
	
	//SUBIR CRONOGRAMA PROYECTO
	$('#procrono').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var path = $('#procrono').attr('path');
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			//var name=path+"/"+c.name;
			$("#ProyectoCronograma").val(name);
			$("#ProyectoCronograma").val(name);
			$(".uploaded").html("Se ha subido con exito el cronograma");
			$(".uploadedCronograma").html("Se ha subido con exito el cronograma");
		}
	});

	//SUBIR CRONOGRAMA
	var path = $('#cronograma').attr('path');

	$('#cronograma').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			//var name=path+"/"+c.name;
			$("#SubproyectoCronogramaPath").val(name);
			$("#SubproyectoCronogramaPath1").val(name);
			$(".uploaded").html("Se ha subido con exito el cronograma");

		}
	});

	//SUBIR PRESUPUESTO
	var path = $('#presupuesto').attr('path');

	$('#presupuesto').uploadify({
		'uploader' : server + 'swf/uploadify.swf',
		'script' : server + 'uploadify.php',
		'folder' : server + 'app/webroot' + path,
		'width' : 109,
		'height' : 32,
		'auto' : true,
		'cancelImg' : server + 'img/cancel.png',
		'onComplete' : function(a, b, c, d) {
			var file = d.split("/");
			var name = path + "/" + file[(file.length - 1)];
			//var name=path+"/"+c.name;
			$("#SubproyectoPresupuestoPath").val(name);
			$("#SubproyectoPresupuestoPath1").val(name);
			$(".uploaded").html("Se ha subido con exito el presupuesto");

		}
	});
});
