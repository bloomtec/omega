$(document).ready(function() {
	var server='/omega/'
	var path=$('#upload_input').attr('path');
	var message=$('#upload_input').attr('message');
	var controller=$('#upload_input').attr('controller');
	var action=$('#upload_input').attr('action');
	var id=$('#upload_input').attr('modelId');
	
	$('#upload_input').uploadify({
	'uploader': server+'swf/uploadify.swf',
	'script':  server+'uploadify.php',
	'folder':  server+'app/webroot'+path,
	'width' : 109,
	'height': 32,
	'auto': true,
	'cancelImg': server+'img/cancel.png',
	'onComplete': function(a,b,c,d){
		var file=d.split("/");
		var name=path+"/"+file[(file.length-1)];
		//var name=path+"/"+c.name;
		
		if(controller&&action){
			$.post(server+controller+"/"+action,{"id":id,"path":name},function(data){
				
				if(data!="NO"){
					$("#path").val(name);
				}
			});
		}else{
			$(".uploaded").html(message);
		}
	
		
		
	}
	});
});