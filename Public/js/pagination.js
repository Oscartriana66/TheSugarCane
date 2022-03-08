$(document).ready(function() {

	$("#input_whr option").each(function(){
		if( $(this).val() == "" )
		{
			$(this).remove();
		}
	});

	// obtenemos el click del boton de busqueda
	$(".form-search").submit(function(){
		// obtenemos el action del formulario de para buscar y cargar los datos de la búsqueda
		var url = $(this).attr('action');
		// obtenemos el data del formulario para cambiar la ruta en la barra de navegación
		var url_change = $(this).data('url-change');
		// generamos los nuevos registros con el valor de pagina 1 y los demas datos
		pagination( url, url_change, 1, input_whr(), value_whr() );
		// evitamos enviar el formulario
		return false;
	});

	// función para cambiar de pagina según la página o botón que selecciona del render
	$(".link_pagination").click(function(){
		// obtenemos el formulario al que pertenece el botón
		var form = $(this).parent('div').parent('td').parent('tr').parent('tfoot').parent('table').siblings('form');
		// obtenemos el action del formulario de para buscar y cargar los datos de la búsqueda
		var url = form.attr('action');
		// obtenemos el data del formulario para cambiar la ruta en la barra de navegación
		var url_change = form.data('url-change');
		// obtenemos la página a la que queremos ir
		var pagina = $(this).data('pagina');
		// generamos los nuevos registros con el valor de pagina 1 y los demas datos
		pagination( url, url_change, pagina, input_whr(), value_whr() );
	});

});

// función para realizar la carga de la paginación
// url: ruta en donde se buscaran los datos para ser cargados
// url_change: ruta que se mostrara en la barra de navegación
// pagina: número de la página a donde irea
// input_whr: valor en el campo de tipo de dato
// value_whr: valor escrito en el campo de busqueda
function pagination( url, url_change, pagina = 1, input_whr = 'id', value_whr = 'null' )
{
	$.ajax({
		url: url+"/"+pagina+"/"+input_whr+"/"+value_whr,
		type: 'GET',
		dataType: "json",
		beforeSend: function() {
			// mostramos el spinner de carga de datos en el contenedor de los datos y en el renderizado de los links
			$(".content-pagination, .render-pagination").html('<div class="preloader-wrapper active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
		},
		success: function( response ) {
			// removemos el spinner de carga de datos
			$(".content-pagination .preloader-wrapper, .render-pagination .preloader-wrapper").remove();
			// cargamos los datos
			$(".content-pagination").append( response.list );
			// cargamos los datos del render y el script para los botones
			$(".render-pagination").append( response.render + '<script>$(document).ready(function() {$(".link_pagination").click(function(){var form = $(this).parent("div").parent("td").parent("tr").parent("tfoot").parent("table").siblings("form");var url = form.attr("action");var url_change = form.data("url-change");var pagina = $(this).data("pagina");pagination( url, url_change, pagina, input_whr(), value_whr() );});});</script>' );
			// cambiamos la ruta de la barra de navegación a la que desemaos ver
			history.pushState(null, "", url_change+"/"+pagina+"/"+input_whr+"/"+value_whr);
		},
		error: function(xhr) { 
			// if error occured
			toastr.error("Ha ocurrido un error.");
			console.log(xhr.statusText + xhr.responseText);
		},
	});
}

// función para obtener el valor en el campo de tipo de dato
function input_whr()
{
	// retornamos el valor correspondiente
	return $("#input_whr").val();
}

// función para obtener el valor escrito en el campo de busqueda
function value_whr()
{
	// retornamos el valor correspondiente
	return $("#value_whr").val();
}