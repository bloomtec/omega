$(document).ready(function() {
	var server = '/omega/'
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