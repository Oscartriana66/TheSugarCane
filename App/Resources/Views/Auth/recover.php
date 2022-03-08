<?php require_once RESOURCES."/Templates/Login/header.php"; ?>

<!-- <form method="POST" action="<?php echo URL; ?>/auth/recover_validation" class="recover-form">
	<div class="errors-recover"></div>
	<div class="row my-4 justify-content-center">
		<div class="col-12 col-md-10 text-justify">
			<p>Ingresa el correo electronico vinculado a su cuenta para enviarle su nueva contraseña:</p>
		</div>
	</div>
	<div class="row my-4 justify-content-center">
		<div class="col-12 col-md-10">
			<input type="email" class="form-control" name="email" id="email" placeholder="Usuario" class="py-5">
		</div>
	</div>
	<div class="row align-items-center justify-content-center">
		<div class="col-12 order-2 order-md-1 col-md-5 text-center text-md-left">
			<a href="<?php echo URL; ?>/Auth/login" title="Iniciar sesión" data-toggle="tooltip" class="btn btn-outline-danger raleway-regular">Iniciar sesión</a>
		</div>
		<div class="col-12 order-md-2 col-md-5 text-center">
			<div class="text-md-right my-2">
				<button id="btn-recover" class="btn btn-primary" title="Recuperar" data-toggle="tooltip">Recuperar</button>
			</div>
		</div>
	</div>
</form> -->

<div class="container p-5">
	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="col-12">
					<img src="<?php echo IMG; ?>/logotipo.svg" alt="logotipo" class="img-fluid" style="height: 90px;">
				</div>
				<div class="col-12 mt-4 mb-3">
					<h1 class="teal-text text-uppercase display-4 raleway-bold">Recuperar</h1>
					<p class="grey-text">
						¿Haz olvidado tu contraseña? No te preocupes, ingresa el correo electrónico vinculado a tu cuenta y recibiras una nueva:
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<form method="POST" action="<?php echo URL; ?>/auth/recover_validation" class="recover-form">
						<div class="errors-recover"></div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">E-mail</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Usuario" class="py-5">
								</div>
							</div>
							<div class="col-12 mt-3">
								<button id="btn-recover" class="btn" title="Recuperar" data-toggle="tooltip">Recuperar</button>

								<a href="<?php echo URL; ?>/Auth/Login" title="Ingresar" data-toggle="tooltip" class="btn btn-outline-default  raleway-regular">Ingresar</a>
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