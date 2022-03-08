
// funcion para cerrar sesion cuando el tiempo se halla agotado
function inactividad() {
	var form = $("#logout-iniactividad-form");
	var url = form.attr('action');
	$.ajax({
		url: url,
		type: 'POST',
		data: form.serialize(),
		beforeSend: function() {
			toastr.info("Cerrando sesión...");
		},
		success: function(data) {
			if( data === 'true' )
			{
				toastr.success("Sesión cerrada con éxito.");
				location.reload();
			}else
			{
				toastr.error("Ha ocurrido un error..");
				console.log(data);
			}
		},
			error: function(xhr) { // if error occured
				toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
}

// variable que contiene el tiempo de inactividad
var t = null;
// funcion que lleva el tiempo de inactividad
function contadorInactividad() {
	// actualizamos el valor de la variable
	t = setTimeout("inactividad()", 1000*60*5);
}
// funcion que valida cada vez que el usuario haga un movimiento en la página web
window.onblur = window.onmousemove = function() {
	if( $("#user_auth_id").val() != "" && $("#user_auth_id").length )
	{
		if( t ) {
			clearTimeout(t);
		}
		contadorInactividad();
	}
}