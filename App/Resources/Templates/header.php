<!DOCTYPE html>
<html lang="es" class="full-height">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="id=edge">
	<title><?php echo APP_NAME; ?></title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/bootstrap.min.css">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/mdb.min.css">
	<!-- Font awesome CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.1/css/all.css">
	<!-- Your custom styles (fuentes) -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/fonts.css">
	<!-- Your custom styles (scroll) -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/scroll.css">
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/style.css">
	<link rel="icon" type="image/png" href="<?php echo URL; ?>/favicon.png">
	<!-- etiquetas seo -->
	<meta http-equiv="content-language" content="es-co">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="geography" content="Bucaramanga, Santander, Colombia">
	<meta name="city" content="Bucaramanga, Santander, Colombia,">
	<meta name="country" content="colombia,">
	<meta name="language" content="spanish">
	<meta http-equiv="expires" content="never">
	<meta name="copyright" content="2018 Hyperlink Soluciones Empresariales - www.hyperlinkse.com">
	<meta name="designer" content="Hyperlink Soluciones Empresariales - www.hyperlinkse.com">
	<meta name="author" content="Hyperlink Soluciones Empresariales - www.hyperlinkse.com">
	<meta name="publisher" content="Hyperlink Soluciones Empresariales - www.hyperlinkse.com">
	<meta name="revisit-after" content="1 days">
	<meta name="distribution" content="global">
	<meta name="robots" content="Index, Follow">
	<meta property="og:url" content="" />
	<meta property="og:title" content="" />
	<meta property="og:description" content="" />
	<meta property="og:type" content="website" />
	<meta property="fb:app_id" content="">
	<meta property="og:locale" content="co_ES">
	<meta property="og:image" content="" />
	<meta property="og:image:url" content="" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<meta property="og:image:alt" content="" />
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="">
	<meta name="twitter:creator" content="">
	<meta name="twitter:title" content="">
	<meta name="twitter:description" content="">
	<meta name="twitter:image" content="">
	<link rel="icon" type="image/ico" href="<?php echo URL; ?>/favicon.ico">
	<link rel="shortcut icon" href="<?php echo URL; ?>/favicon.ico">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL; ?>/icons/favicon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL; ?>/icons/favicon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>/icons/favicon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>/icons/favicon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>/icons/favicon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL; ?>/icons/favicon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL; ?>/icons/favicon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL; ?>/icons/favicon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL; ?>/icons/favicon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo URL; ?>/icons/favicon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo URL; ?>/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo URL; ?>/icons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo URL; ?>/icons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo URL; ?>/manifest.json">
	<meta name="msapplication-TileColor" content="#4CCC4C">
	<meta name="msapplication-TileImage" content="<?php echo URL; ?>/icons/favicon-144x144.png">
	<meta name="theme-color" content="#4CCC4C">
</head>
<body class="scroll" manifest="manifest.cache">
	<?php 

	// campo del cual podemos obtener la ruta de la aplicación por medio de javascript
	echo "<input type='hidden' id='URL' name='URL' value='".URL."' />";

	?>

	<div class="container-fluid">
		<div class="row justify-content-end">
			<div class="col-3 navegacion scroll">
				<div class="row">
					<div class="col-12 text-center py-3">
						<img src="<?php echo IMG; ?>/user.svg" alt="user" style="height: 120px;">
						<a href="<?php echo URL; ?>/User/Profile" class="white-text d-block mt-2 font-weight-bold">
							<?php echo ucwords( $this->auth->user->__get('name') ); ?>
						</a>
					</div>
					<div class="col-12">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo URL; ?>/Simulation/create">
									<p class="mb-0">
										Nueva simulación
									</p>
								</a>
							</li>
							<li>
								<a href="<?php echo URL; ?>/Simulation/">
									<p class="mb-0">
										Registro de simulaciones
									</p>
								</a>
							</li>
							<?php if( $this->auth->user->__get('role') != 3 ){ ?>
								<li>
									<a href="<?php echo URL; ?>/User">
										<p class="mb-0">
											Registro de usuarios
										</p>
									</a>
								</li>
							<?php } ?>
							<li>
								<a href="<?php echo URL; ?>/Soil_parameters/">
									<p class="mb-0">
										Parametros de suelo
									</p>
								</a>
							</li>
							<li>
								<a href="<?php echo URL; ?>/Help/">
									<p class="mb-0">
										Ayuda
									</p>
								</a>
							</li>
							<li>
								<a href="">
									<form id="form-logout" name="form-logout" method="POST" action="<?php echo URL; ?>/auth/logout" class="d-inline">
										<input type="hidden" name="logout" value="yes">
										<button type="submit">
											Cerrar sesión
										</button>
									</form>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-9 contenedor">

