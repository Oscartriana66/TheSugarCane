<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="id=edge">
	<title><?php echo APP_NAME; ?></title>
	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/mdb.min.css">
    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <!-- Your custom styles (optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/fonts.css">
    <!-- Your custom styles (optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/style.css">
	<link rel="icon" type="image/ico" href="<?php echo URL; ?>/favicon.ico">
</head>
<body>


	<div class="container">
		<div class="row align-items-center justify-content-center" style="height: 100vh;">
			<div class="col-12 text-center">
				<div class="row">
					<div class="col-12">
						<h1 class="text-black-50 display-4 raleway-bold">ERROR 403</h1>
					</div>
					<div class="col-12 mt-4">
						<p class="grey-text">
							You don't have permits. 
							<a href="<?php echo URL; ?>">Return welcome</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="<?php echo RUTA_JS; ?>/jquery-3.3.1.js"></script>
	<!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?php echo RUTA_JS; ?>/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="<?php echo RUTA_JS; ?>/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="<?php echo RUTA_JS; ?>/mdb.min.js"></script>
    <!-- Your custom js (optional) -->
	<script type="text/javascript" src="<?php echo RUTA_JS; ?>/script.js"></script>
    <script>
  		new WOW().init();
  	</script>
</body>
</html>