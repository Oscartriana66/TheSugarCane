$(document).ready(function(){

	// funcion para que el usuario se registre
	$(".register-form").submit(function(){
		$(".errors-register").html('');
		var form = $(this);
		var url = form.attr('action');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				show_loader( form );
				toastr.info("Registandome...");
			},
			success: function(data) {
				console.log(data);
				data = data.split('|');
				if( data[0] === 'true' )
				{
					toastr.success("Sesión iniciada con éxito.");
					window.location = data[1];
				}else
				{
					hide_loader();
					toastr.error("Ha ocurrido un error..");
					$(".errors-register").append( data[0] );
				}
			},
			error: function(xhr) { // if error occured
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});


	// funcion para que el usuario inicie sesion
	$(".login-form").submit(function(){
		$(".errors-login").html('');
		var form = $(this);
		var url = form.attr('action');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				show_loader( form );
				toastr.info("Iniciando sesión...");
			},
			success: function(data) {
				data = data.split('|');
				if( data[0] === 'true' )
				{
					toastr.success("Sesión iniciada con éxito.");
					window.location = data[1];
				}else
				{
					hide_loader();
					toastr.error("Ha ocurrido un error..");
					$(".errors-login").append( data[0] );
				}
			},
			error: function(xhr) { // if error occured
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});

	// funcion para que el usuario inicie sesion
	$(".recover-form").submit(function(){
		$(".errors-recover").html('');
		var form = $(this);
		var url = form.attr('action');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				show_loader( form );
				toastr.info("Validando datos...");
			},
			success: function(data) {
				hide_loader();
				if( data === 'true' )
				{
					toastr.success("Password enviada con éxito.");
				}else
				{
					toastr.error("Ha ocurrido un error..");
					$(".errors-recover").append( data );
				}
			},
			error: function(xhr) { // if error occured
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});

});


// función para mostrar la card de esperar
function show_loader( form )
{
	form.parent(".card-body").parent(".card").append('<div class="content-loader"><div class="loader-inner ball-clip-rotate-multiple"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
}

// función para remover la card de esperar
function hide_loader()
{
	$(".content-loader").remove();
}