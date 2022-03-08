<?php require_once RESOURCES."/Templates/Login/header.php"; ?>


<div class="container p-5">
	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="col-12">
					<img src="<?php echo IMG; ?>/logotipo.svg" alt="logotipo" class="img-fluid" style="height: 90px;">
				</div>
				<div class="col-12 mt-4 mb-3">
					<h1 class="teal-text text-uppercase display-4 raleway-bold">Bienvenido</h1>
					<p class="grey-text">
						Gracias por regresar, por favor inicie sesión en su cuenta completando este formulario.
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<form method="POST" action="<?php echo URL; ?>/auth/access" class="login-form">
						<div class="errors-login"></div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">E-mail</label>
									<input type="email" class="form-control" name="username" id="username" placeholder="E-mail" class="py-5" autocomplete="off">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Contraseña</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" autocomplete="off">
								</div>
							</div>
							<div class="col-12 text-right mt-2">
								<a href="<?php echo URL; ?>/Auth/recover" title="¿Olvidó su contraseña? Haz clic para recuperarla" data-toggle="tooltip" class="black-text raleway-regular">
									<small>¿Olvidó su contraseña?</small>
								</a>
							</div>
							<div class="col-12">
								<button id="btn-login" class="btn" title="Ingresar" data-toggle="tooltip">Ingresar</button>

								<a href="<?php echo URL; ?>/Auth/sign_up" title="Crear cuenta" data-toggle="tooltip" class="btn btn-outline-default  raleway-regular">Registrarme</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<img src="<?php echo IMG; ?>/auth.jpg" alt="auth" class="img-fluid" style="max-height: calc( 100vh - 6rem );">
		</div>
	</div>
</div>



<?php require_once RESOURCES."/Templates/Login/footer.php"; ?>