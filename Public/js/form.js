$(document).ready(function() {
	
	$(".form-create").submit(function(){
		var errors_create = $(this).children(".errors-create");
		var form = $(this);
		var url = form.attr('action');
		errors_create.html('');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				toastr.info("Creando registro, espere un momento...");
			},
			success: function(data) {
				if( data === 'true' )
				{
					toastr.success("Registro exitoso.");
				}else
				{
					toastr.error("Ha ocurrido un error.");
					errors_create.append( data );
					$('.scroll').animate({
						scrollTop: errors_create.offset().top
					});
				}
			},
			error: function(xhr) {
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});


	$(".open-confirm-delete").click(function()
	{
		$("#id-form-delete").val( $(this).data('id') );
		$(".form-delete").data( "id", $(this).data('id') );
	});


	$(".form-delete").click(function(){
		var id = $(this).data('id');
		var form = $("#form-delete-"+id);
		var url = form.attr('action');
		var errors_delete = form.parent("td").parent("tr").parent("tbody").parent("table").siblings('.errors-delete');
		errors_delete.html('');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				toastr.info("Eliminando registro, espere un momento...");
			},
			success: function(data) {
				if( data === 'true' )
				{
					toastr.success("Registro eliminado con exito.");
					location.reload();
				}else
				{
					toastr.error("Ha ocurrido un error.");
					errors_delete.append( data );
					$('.scroll').animate({
						scrollTop: errors_delete.offset().top
					});
				}
			},
			error: function(xhr) {
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});

	$(".open-confirm-pay").click(function()
	{
		$("#id-form-pay").val( $(this).data('id') );
		$(".form-pay").data( "id", $(this).data('id') );
	});


	$(".form-pay").click(function(){
		var id = $(this).data('id');
		var form = $("#form-pay-"+id);
		var url = form.attr('action');
		var errors_delete = form.parent("td").parent("tr").parent("tbody").parent("table").siblings('.errors-pay');
		errors_delete.html('');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				toastr.info("Pagando factura, espere un momento...");
			},
			success: function(data) {
				if( data === 'true' )
				{
					toastr.success("Factura pagada con éxito.");
					location.reload();
				}else
				{
					toastr.error("Ha ocurrido un error.");
					errors_delete.append( data );
					$('.scroll').animate({
						scrollTop: errors_delete.offset().top
					});
				}
			},
			error: function(xhr) {
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});


	$(".form-find").click(function(){
		var errors_find = $(this).children(".errors-find");
		var id = $(this).data('id');
		var url = $(this).data('url');
		errors_find.html('');
		$.ajax({
			url: url,
			type: 'POST',
			data: {'id': id},
			dataType: 'json',
			beforeSend: function() {
				toastr.info("Buscando registro, espere un momento...");
			},
			success: function(data) {
				if( data['status'] === 'true' )
				{
					toastr.success("Registro encontrado con exito.");
					$("#edit").modal('show');

					$.each( data['datos'], function(key, value){
						$("#edit #"+key).val(value);
					});

				}else
				{
					toastr.error("Ha ocurrido un error.");
				}
			},
			error: function(xhr) {
			   	toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;
	});


	$(".form-edit").submit(function(){
		var errors_edit = $(this).children(".errors-edit");
		var form = $(this);
		var url = form.attr('action');
		var modal = form.data('modal');
		errors_edit.html('');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			beforeSend: function() {
				toastr.info("Actualizando registro, espere un momento...");
			},
			success: function(data) {
				if( data === 'true' )
				{
					toastr.success("Registro actualizado con exito.");
				}else
				{

					toastr.error("Ha ocurrido un error.");
					errors_edit.append( data );
					// validamos si es una ventana modal
					if( modal == undefined )
					{
						$('.scroll').animate({
							scrollTop: errors_edit.offset().top
						});
					}
				}
			},
			error: function(xhr) {
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