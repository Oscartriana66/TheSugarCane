$(document).ready(function() {
	// declaramos una variable para que solo funcione 1 vez
	var focus_input = false;
	// función para cuando le hagan focus por priemra vez
	$(".show_options").on('focus', function(){
		if( !focus_input )
		{
			focus_input = true;
			var obj = $(this);
			// obtenemos el valor
			var value = obj.val();
			// obtenemos la ruta a donde se va a enviar
			var url = obj.data('url');
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					'value': value
				},
				beforeSend: function() 
				{
					// validamos que no exista el objeto creado
					if( !obj.siblings(".content_options").length )
						// creamos el objeto
						obj.parent().append('<div class="content_options scroll arial"><div class="list_content_options"></div><div class="loading_options"><i class="fa fa-spinner mr-2"></i>Cargando datos...</div></div>');
				},
				success: function(data) {
					obj.siblings(".content_options").children('.loading_options').addClass('d-none');
					obj.siblings(".content_options").children('.list_content_options').html( data );
					// Tooltips Initialization
		            $(function () {
		                $('[data-toggle="tooltip"]').tooltip()
		            });

		            $(function () {
		                $('[data-toggle="popover"]').popover()
		            });
				},
				error: function(xhr) {
				   	toastr.error("Ha ocurrido un error.");
				    // console.log(xhr.statusText + xhr.responseText);
				},
			});
		}
		return false;
	});

	$(".show_options").on('keyup', function(){
		var obj = $(this);
		// obtenemos el valor
		var value = obj.val();
		// validamos si el valor es mejor a 1
		if( value.length < 1 )
		{
			// removemos el objeto
			obj.siblings('.content_options').remove();
			// evitamos que contiene
			return;
		}
		// obtenemos la ruta a donde se va a enviar
		var url = obj.data('url');
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				'value': value
			},
			beforeSend: function() 
			{
				// validamos que no exista el objeto creado
				if( !obj.siblings(".content_options").length )
					// creamos el objeto
					obj.parent().append('<div class="content_options scroll arial"><div class="list_content_options"></div><div class="loading_options"><i class="fa fa-spinner mr-2"></i>Cargando datos...</div></div>');
			},
			success: function(data) {
				obj.siblings(".content_options").children('.loading_options').addClass('d-none');
				obj.siblings(".content_options").children('.list_content_options').html( data );
				// Tooltips Initialization
	            $(function () {
	                $('[data-toggle="tooltip"]').tooltip()
	            });

	            $(function () {
	                $('[data-toggle="popover"]').popover()
	            });
			},
			error: function(xhr) {
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});

	// función para cargar los datos luego de dar clic al deseado 
	$('.form-group').on('click', '.option_loaded', function(){
		// capturamos el valor
		var value = $(this).data('value');
		// capturamos el valor
		var value_2 = $(this).data('value-2');
		// asignamos el valor al campo
		$(this).parent('.list_content_options').parent('.content_options').siblings('.show_options').val( value );
		// asignamos el valor al campo
		$(this).parent('.list_content_options').parent('.content_options').siblings('.show_options_2').val( value_2 );
		// removemos el contenedor del listado
		$(this).parent('.list_content_options').parent('.content_options').remove();
	});

});