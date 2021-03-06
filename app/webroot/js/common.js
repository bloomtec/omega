$(document).ready(function() {
	var server = '/'
	//**************** MODAL
	var triggers = $(".modalInput").overlay({

		// some mask tweaks suitable for modal dialogs
		mask : {
			color : '#ebecff',
			loadSpeed : 200,
			opacity : 0.9
		},

		closeOnClick : false
	});
	//----------------------------------------------------------------
	//******************************CAmbio de cliente equipo
	var selescted = $("#EquipoClienteId option:selected").attr("value");
	$(".cliente[id='" + selescted + "']").addClass("seleccionado");
	$("#EquipoClienteId").change(function() {
		$(".cliente").removeClass("seleccionado");
		var selescted = $("#EquipoClienteId option:selected").attr("value");
		$(".cliente[id='" + selescted + "']").addClass("seleccionado");
	});

	$(".cliente").click(function() {
		$(".cliente").removeClass("seleccionado");
		$(this).addClass("seleccionado");
		var option = $("#EquipoClienteId option[value='" + $(this).attr("id") + "']").attr("selected", "true");

	});
	/*$("input.filtroNombre").keyUp(function(){

	});*/

	//*********************________COMENTARIOS__________*********************//

	$(document).ready(function() {
		$("#ObservacionAJAXAddObservacionPublicaForm").submit(function() {
            $overlay = $(this).find(".comments_overlay").show();
			$.post($(this).attr("action"), 
				$(this).serialize(),
				function(data) {
				if (data == "OK") {
					$(".publicos .historial").append('<div class="observacion nueva"><div class="encabezado"><div class="nombre">' + $(".historial").attr("nombre") + '</div><div class="fecha">HOY</div></div> <div class="cuerpo">' + $(".publicos #observacion").val() + '</div></div>');
					$(".publicos #observacion").val("");
					$('.publicos .historial').scrollTop(10000);
                    $overlay.hide();
				} else
					alert(data);
                    $overlay.hide();

			});

			return false;
		});
		$("#ObservacionAJAXAddObservacionPrivadaForm").submit(function() {
            $overlay = $(this).find(".comments_overlay").show();
			$.post($(this).attr("action"), 
				$(this).serialize(), 
				function(data) {
				if (data == "OK") {
					$(".privados .historial").append('<div class="observacion nueva"><div class="encabezado"><div class="nombre">' + $(".historial").attr("nombre") + '</div><div class="fecha">HOY</div></div> <div class="cuerpo">' + $(".privados #observacion").val() + '</div></div>');
					$(".privados #observacion").val("");
					$('.privados .historial').scrollTop(10000);
                    $overlay.hide();

				} else
					alert(data);
                    $overlay.hide();
			});

			return false;
		});

		//****** DE PROYECTOS**//
		
		$("#ObservacionAJAXAddComentarioPublicoForm").submit(function() {
            $overlay = $(this).find(".comments_overlay").show();
			$.post($(this).attr("action"), 
				$(this).serialize(), 
				function(data) {
				if (data == "OK") {
					$(".publicos .historial").append('<div class="observacion nueva"><div class="encabezado"><div class="nombre">' + $(".historial").attr("nombre") + '</div><div class="fecha">HOY</div></div> <div class="cuerpo">' + $(".publicos #observacion").val() + '</div></div>');
					$(".publicos #observacion").val("");
					$('.publicos .historial').scrollTop(10000);
                    $overlay.hide();

				} else
					alert(data);
                    $overlay.hide();
			});

			return false;
		});
		$("#ObservacionAJAXAddComentarioPrivadoForm").submit(function() {
            $overlay = $(this).find(".comments_overlay").show();
			$.post($(this).attr("action"), $(this).serialize(),
				function(data) {
				if (data == "OK") {
					$(".privados .historial").append('<div class="observacion nueva"><div class="encabezado"><div class="nombre">' + $(".historial").attr("nombre") + '</div><div class="fecha">HOY</div></div> <div class="cuerpo">' + $(".privados #observacion").val() + '</div></div>');
					$(".privados #observacion").val("");
					$('.privados .historial').scrollTop(10000);
                    $overlay.hide();

				} else
					alert(data);
                    $overlay.hide();
			});

			return false;
		});
	});
	//**************************************____AÑADIR EVENTOS___*****************
	$("#formularioEventosServicios").submit(function() {
		if($("#textoEvento").val().length > 0) {
			$.post($(this).attr("action"), {
				contratosEquipoId : $("#EventoContratoEquipo").val(),
				texto : $("#EventosServicioUsuario").val() + ": " + $("#textoEvento").val(),
				modelo : $("#EventosServicioModelo").val(),
				llave_foranea : $("#EventosServicioLlaveForanea").val()
			}, function(data) {
				if (data == "YES") {
					$(".contenedorEventos").append('<div class="observacion nueva"><div class="encabezado"><div class="fecha">HOY</div></div> <div class="cuerpo">' + $("#EventosServicioUsuario").val() + ": " + $("#textoEvento").val() + '</div></div>');
					$("#textoEvento").val("");
					$('.eventos .historial').scrollTop(10000);
				} else {
					alert(data);
				}
			})
		} else {
			alert("Debe ingresar texto a la bitácora");
		}
		return false;
	});
	$("#formularioEvento").submit(function() {
		$.post($(this).attr("action"), {
			contratosEquipoId : $("#EventoContratoEquipo").val(),
			texto : $("#textoEvento").val()
		}, function(data) {
			if (data == "YES") {
				$(".contenedorEventos").append('<div class="observacion nueva"><div class="encabezado"><div class="fecha">HOY</div></div> <div class="cuerpo">' + $("#textoEvento").val() + '</div></div>');
				$("#textoEvento").val("");
				$('.eventos .historial').scrollTop(10000);
			} else {
				alert(data);
			}
		})

		return false;
	});
	$(".textArearBotones .editar").click(function() {
		$(this).parents().siblings("textarea").removeAttr("disabled");
		$(this).siblings().show();
		$(this).hide();
	});
	$(".textArearBotones .cancelar").click(function() {
		$(this).parents().siblings("textarea").val($(this).attr("valor"));

	});

	$(".textArearBotones .guardarDiagnostico").click(function() {
		$botonGuardar = $(this);
		var id = $botonGuardar.attr("modelId");
		var texto = $botonGuardar.parents().siblings("textarea").val();
		$.post(server + "equipos/AJAX_guardarDiagnostico", {
			"id" : id,
			"texto" : texto
		}, function(data) {

			if (data != "NO") {
				$botonGuardar.siblings().hide();
				$botonGuardar.hide();
				$botonGuardar.siblings(".cancelar").attr("valor", texto);
				$botonGuardar.parents().siblings("textarea").attr("disabled", true);
				$botonGuardar.siblings(".editar").show();
				alert(data);
			} else {
				alert("No se pudo actualizar el diagnostico. Intente de nuevo");
			}
		});
	});
	$(".textArearBotones .guardarDesarrollo").click(function() {
		$botonGuardar = $(this);
		var id = $botonGuardar.attr("modelId");
		var texto = $botonGuardar.parents().siblings("textarea").val();
		$.post(server + "proyectos/AJAX_guardarDesarrollo", {
			"id" : id,
			"texto" : texto
		}, function(data) {

			if (data != "NO") {
				$botonGuardar.siblings().hide();
				$botonGuardar.hide();
				$botonGuardar.siblings(".cancelar").attr("valor", texto);
				$botonGuardar.parents().siblings("textarea").attr("disabled", true);
				$botonGuardar.siblings(".editar").show();
				alert(data);
			} else {
				alert("No se pudo actualizar el diagnostico. Intente de nuevo");
			}
		});
	});

	$(".textArearBotones .guardarObservacionesFinales").click(function() {
		$botonGuardar = $(this);
		var id = $botonGuardar.attr("modelId");
		var texto = $botonGuardar.parents().siblings("textarea").val();
		$.post(server + "equipos/AJAX_guardarObservacionesFinales", {
			"id" : id,
			"texto" : texto
		}, function(data) {

			if (data != "NO") {
				$botonGuardar.siblings().hide();
				$botonGuardar.hide();
				$botonGuardar.siblings(".cancelar").attr("valor", texto);
				$botonGuardar.parents().siblings("textarea").attr("disabled", true);
				$botonGuardar.siblings(".editar").show();
				alert(data);
			} else {
				alert("No se pudo actualizar el diagnostico. Intente de nuevo");
			}
		});
	});

	$(".textArearBotones .guardarActividadesConcluidas").click(function() {
		$botonGuardar = $(this);
		var id = $botonGuardar.attr("modelId");
		var texto = $botonGuardar.parents().siblings("textarea").val();
		$.post(server + "equipos/AJAX_guardarActividadesConcluidas", {
			"id" : id,
			"texto" : texto
		}, function(data) {

			if (data != "NO") {
				$botonGuardar.siblings().hide();
				$botonGuardar.hide();
				$botonGuardar.siblings(".cancelar").attr("valor", texto);
				$botonGuardar.parents().siblings("textarea").attr("disabled", true);
				$botonGuardar.siblings(".editar").show();
				alert(data);
			} else {
				alert("No se pudo actualizar el diagnostico. Intente de nuevo");
			}
		});
	});

	$(".areaInformativa textarea").attr("disabled", true);
});
