<?php require_once RESOURCES."/Templates/Login/header.php"; ?>

<div class="container p-5">
	<div class="row">
		<div class="col-12 mb-5">
			<div class="row">
				<div class="col-12">
					<img src="<?php echo IMG; ?>/logotipo.svg" alt="logotipo" class="img-fluid" style="height: 90px;">
				</div>
			</div>
		</div>
	</div>
	<form method="POST" action="<?php echo URL; ?>/auth/register" class="register-form" name="register-form">
		<?php echo $this->__csrf_field(); ?>
		<div class="errors-register"></div>
		<div class="row">
			<div class="col-md-6">
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Nombres</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Nombres" class="py-5" autocomplete="off">
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">E-mail</label>
						<input type="email" class="form-control" name="username" id="username" placeholder="E-mail" class="py-5" autocomplete="off">
					</div>
				</div>
				<div class="col-12 mt-4">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Tipo de usuario</label>
						<select class="browser-default form-control" name="role" id="role" placeholder="Nombres" class="py-5">
							<option value="" disabled="" selected="">-- Seleccionar uno --</option>
							<option value="2">Asesor</option>
							<option value="3">Agrónomo</option>
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Entidad a la que se esta vinculando</label>
						<input type="text" class="form-control show_options" data-url="<?php echo URL; ?>/Auth/Find_by_company" name="company" id="company" placeholder="Entidad a la que se esta vinculando" class="py-5" autocomplete="off" disabled="">
					</div>
				</div>
				<div class="col-12 mt-3">
					<button id="btn-register" class="btn" title="Registrarme" data-toggle="tooltip">Registrarme</button>

					<a href="<?php echo URL; ?>/Auth/login" title="Crear cuenta" data-toggle="tooltip" class="btn btn-outline-default  raleway-regular">Ingresar</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Contraseña</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" autocomplete="off">
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Confirmar contraseña</label>
						<input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirmar contraseña" autocomplete="off">
					</div>
				</div>
				<div class="col-12 mt-4">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Teléfono/Celular</label>
						<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Teléfono/Celular" class="py-5" autocomplete="off">
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Número de documento de identidad</label>
						<input type="text" class="form-control" name="cc" id="cc" placeholder="Número de documento de identidad" class="py-5" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<?php require_once RESOURCES."/Templates/Login/footer.php"; ?>
<script src="<?php echo JS; ?>/show_options.js"></script>
<script>
	$(document).ready(function() {
		$("#role").on('change', function(){
			let role = $(this).val();
			if( role == 2 )
			{
				$("#company").prop('disabled', false);
				$("#company").focus();
			}
			else
			{
				$("#company").prop('disabled', true);
				$("#company").val('');
			}
		});
	});
</script>