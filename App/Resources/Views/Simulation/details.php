<?php require_once RESOURCES."/Templates/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/auth.css">

<div class="container px-5 pt-5">
	<div class="row">
		<div class="col-12 mb-5">
			<div class="row">
				<div class="col-6">
					<img src="<?php echo IMG; ?>/logotipo.svg" alt="logotipo" class="img-fluid" style="height: 120px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 mb-4">
			<div class="d-flex justify-content-between">
				<h4 class="font-weight-bold" style="color: #008000;">
					Detalles de simulación
				</h4>
				<a href="" class="btn btn-sm btn-green pull-right btn-user-updates" data-toggle="modal" data-target="#details-user-updates" data-url="<?php echo URL.'/Simulation/User-updates/'.$params['simulation']['id']; ?>">
					<i class="fa fa-list mr-1"></i> Listado de actualizaciones
				</a>
			</div>
			<hr style="border: 2px solid green;" >
		</div>
	</div>
	<form class="form-simulation" method="post" action="<?php echo URL; ?>/Simulation/update" data-action-load="<?php echo URL; ?>/Simulation/details">
		<?php echo $this->__csrf_field(); ?>
		<div class="errors-simulation"></div>
		<input type="hidden" name="id" id="id" value="<?php echo $params['simulation']['id']; ?>">
		<div class="row">
			<div class="col-12 mb-3">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Variedad</label>
					<input type="text" class="form-control show_options" data-url="<?php echo URL; ?>/Variety/find_by_select" name="variedad" id="variedad" placeholder="Ingrese la variedad para realizar la simulación" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['variety']; ?>">
					<input type="hidden" class="show_options_2" name="variety_id" id="variety_id" value="<?php echo $params['simulation']['variety_id']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Número de hectareas sembradas</label>
					<input type="number" step="0.1" class="form-control" name="number_hectares_planted" id="number_hectares_planted" placeholder="Número de hectareas sembradas" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['number_hectares_planted']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Calidad del suelo (porcentaje 0 - 100)</label>
					<input type="number" step="1" min="0" max="100" class="form-control" name="soil_quality" id="soil_quality" placeholder="Calidad del suelo (porcentaje)" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['soil_quality']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Precipitaciones totales</label>
					<input type="number" step="0.1" class="form-control" name="total_rainfall" id="total_rainfall" placeholder="Precipitaciones totales" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['total_rainfall']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Temperatura promedio de la zona (centigrados)</label>
					<input type="number" step="0.1" class="form-control" name="average_temperature_area" id="average_temperature_area" placeholder="Temperatura promedio de la zona (centigrados)" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['average_temperature_area']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3 mb-md-0">
				<div class="form-group">
					<label for="" style="position: absolute; color: #009688; font-size: 12px; left: 25px; top: 3px;">Recoleccion (número de meses desde el cultivo)</label>
					<input type="number" step="0.1" class="form-control" name="harvest" id="harvest" placeholder="Recoleccion (número de meses desde el cultivo)" class="py-5" autocomplete="off" value="<?php echo $params['simulation']['harvest']; ?>">
				</div>
			</div>
			<div class="col-md-6 mb-3 mb-md-0">
				<div class="form-group">
					<button id="btn-register" class="btn btn-block btn-new-simulation" title="Registrarme" data-toggle="tooltip">
						Actualizar simulación
					</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div id="content-calculos-previos" class="container px-5 d-none">
	<div class="row">
		<div class="col-12 mb-4">
			<h4 class="font-weight-bold" style="color: #008000;">
				Cálculos previos
			</h4>
			<hr style="border: 2px solid green;" >
		</div>
	</div>
	<div class="row grey lighten-3 align-items-center mb-3">
		<div class="col-md-4">
			<p class="mb-0">
				Porcentaje de temperatura: 
				<span class="font-weight-bold arial load_data porcentaje_temperatura">
					<i class="fa fa-spinner mr-2"></i>
				</span>
			</p>
		</div>
		<div class="col-md-4">
			<p class="mb-0">
				Porcentaje de precipitaciones: 
				<span class="font-weight-bold arial load_data porcentaje_precipitaciones">
					<i class="fa fa-spinner mr-2"></i>
				</span>
			</p>
		</div>
		<div class="col-md-4 green lighten-2 p-3">
			<p class="mb-0">
				Porcentaje de condiciones del clima: 
				<span class="font-weight-bold arial load_data porcentaje_clima">
					<i class="fa fa-spinner mr-2"></i>
				</span>
			</p>
		</div>
	</div>
	<div class="row grey lighten-3 align-items-center">
		<div class="col-md-8">
			<p class="mb-0">
				Mes apto de cosecha: 
			</p>
			<p class="mb-0">
				<span class="font-weight-bold arial load_data mes_cosecha">
					<i class="fa fa-spinner mr-2"></i>
				</span>
			</p>
		</div>
		<div class="col-md-4 green lighten-2 p-3">
			<p class="mb-0">
				Porcentaje de aptitud de coseña: 
				<span class="font-weight-bold arial load_data porcentaje_aptitud">
					<i class="fa fa-spinner mr-2"></i>
				</span>
			</p>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12 mb-4">
			<h4 class="font-weight-bold" style="color: #008000;">
				Resultados
			</h4>
			<hr style="border: 2px solid green;" >
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 pr-md-5">
			<div class="row mb-3">
				<div class="col-12 green lighten-2 py-2">
					<strong class="font-weight-bold text-center">Variables Agroindustriales</strong>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Brix
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_brix" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Brix: Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_brix">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_brix" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Brix: Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_brix">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					pH
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_ph" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="pH: Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_ph">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_ph" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="pH: Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_ph">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Azúcares reductores (%)
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_azucares" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Azúcares reductores (%): Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_azucares">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_azucares" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Azúcares reductores (%): Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_azucares">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Sacarosa (%)
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_sacarosa" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Sacarosa (%): Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_sacarosa">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_sacarosa" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Sacarosa (%): Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_sacarosa">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Pureza (%)
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_pureza" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Pureza (%): Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_pureza">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_pureza" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Pureza (%): Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_pureza">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Fósforo (ppm)
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_fosforo" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Fósforo (ppm): Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_fosforo">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_fosforo" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Fósforo (ppm): Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_fosforo">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
			<div class="row align-items-center mb-3">
				<div class="col-12 green lighten-3 py-2">
					Humedad (%)
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="jugos_humedad" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Humedad (%): Jugos">
					Jugos:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data jugos_humedad">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
				<div class="col-md-6 grey lighten-3 py-2 d-flex align-items-center load_other_comparation" data-property="panela_humedad" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Humedad (%): Panela">
					Panela:
					<p class="ml-3 mb-0 text-truncate font-weight-bold arial load_data panela_humedad">
						<i class="fa fa-spinner mr-2"></i>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="row mb-3">
				<div class="col-12 grey lighten-3 py-2">
					<strong class="font-weight-bold text-center">Variables Agronómicas</strong>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="average_plant_height" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Altura promedia de planta (m)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Altura promedia de planta (m)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data altura_promedio_planta">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="stem_diameter" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Diámetro de tallo (cm)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Diámetro de tallo (cm)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data diametro_tallo">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="internode_length" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Longitud de entrenudo (cm)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Longitud de entrenudo (cm)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data longitud_entrenudo">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="growth_rate_cm" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Índice de crecimiento (cm/mes)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Índice de crecimiento (cm/mes)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data indice_crecimiento">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="growth_rate_entrenudo" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Índice de crecimiento (entrenudos/mes)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Índice de crecimiento (entrenudos/mes)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data indice_crecimiento_entrenudo">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="grinding_stems_time_cutting" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Tallos molederos al momento del corte (Nro.)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Tallos molederos al momento del corte (Nro.)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data tallos_molederos_monte_corte">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="cane_production" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de caña (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de caña (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_cana">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="bud_production_seed" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de cogollo – semilla (t/ha) 2" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de cogollo – semilla (t/ha) 2
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_cogollo_semilla">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="palm_production_green_leaves" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de palma - hojas verdes (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de palma - hojas verdes (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_palma_hojas_verdes">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="panela_production" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de panela (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de panela (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_panela">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="yield_panela" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Rendimiento en panela (%)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Rendimiento en panela (%)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data rendimiento_panela">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="cachaca_production" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de cachaza (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de cachaza (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_cachaza">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="melote_production" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de melote (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de melote (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_melote">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
			<div class="row grey lighten-3 align-items-center mb-2 py-2 load_other_comparation" data-property="green_bagasse_production" data-url="<?php echo URL; ?>/Simulation/load_other_comparation" data-load-title="Producción de bagazo verde (t/ha)" data-toggle="tooltip" title="Clic para ver los datos de comparación de esta propiedad">
				<div class="col-md-8">
					Producción de bagazo verde (t/ha)
				</div>
				<div class="col-md-4 text-center text-truncate">
					<span class="font-weight-bold arial load_data produccion_bagazo_verde">
						<i class="fa fa-spinner mr-2"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5 green lighten-2 p-3">
		<div class="col-12 text-center">
			<h5 class="font-weight-bold arial">
				Comparación de datos de <span class="load_title">Producción de caña (t/ha)</span>
			</h5>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12 contenedor-chart">
			<canvas id="lineChart"></canvas>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 text-center pink lighten-4 p-3">
			<h5 class="font-weight-bold arial">
				Variedad seleccionada
			</h5>
		</div>
		<div class="col-md-6 text-center blue lighten-4 p-3">
			<h5 class="font-weight-bold arial">
				Variedad de control RD 75-11
			</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 content-current-variety">
			<!-- espacio para cargar los datos del mes de la variedad seleccionada -->
		</div>
		<div class="col-md-6 content-current-rd-75-11">
			<!-- espacio para cargar los datos del mes de la variedad rd 75-11 -->
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="details-user-updates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-bold" id="exampleModalLabel">Listado de actualizaciones</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead class="green white-text">
						<tr>
							<th>Usuario</th>
							<th>Realizada el</th>
						</tr>
					</thead>
					<tbody class="load-user-updates">
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<?php require_once RESOURCES."/Templates/footer.php"; ?>
<script src="<?php echo JS; ?>/show_options.js"></script>
<script>
	// variable que contendra los datos de los resultados para hacer los calculos de comparación
	var data_for_comparation = {
		'current_variety' : [],
		'rd_75_11_variety' : [],
	};
	
	$(document).ready(function() 
	{
		// función para cuando escriban en calida del suelo
		$("#soil_quality").on('blur', function(event){
			// valiamos si el valor es mayor a 100
			if( $(this).val() > 100 )
				// asginamos el 100 por efecto
				$(this).val('100');
		});

		$(".btn-user-updates").on('click', function(){
			// obtenemos la ruta a donde se va a enviar
			var url = $(this).data('url');
			$.ajax({
				url: url,
				type: 'POST',
				success: function( response ) {
					$(".load-user-updates").html( response );
				},
				error: function(xhr) {
				   	toastr.error("Ha ocurrido un error.");
				    // console.log(xhr.statusText + xhr.responseText);
				},
			});
		});

		// función para realizar una nueva simulación
		$(".btn-new-simulation").on('click', function(){
			// contenedor de los calculos previos
			var content_calculos = $("#content-calculos-previos");
			// formulario de la simualacion
			var form = $(".form-simulation");
			// obtenemos la ruta a donde se va a enviar
			var url = form.attr('action');
			// limpiamos el campo de errores
			$(".errors-simulation").html('');
			// ocultamos el contenedor de los calculos
			content_calculos.addClass('d-none');
			$.ajax({
				url: url,
				type: 'POST',
				data: form.serialize(),
				dataType: 'json',
				success: function( response ) {
					// validamos el estado de la respuesta
					if( response.status == "success" )
					{
						// asginamos los datos para comparar para la variedad seleccionada
						data_for_comparation.current_variety = response.data_for_comparation.current_variety;
						// asginamos los datos para comparar para la variedad rd 75 11
						data_for_comparation.rd_75_11_variety = response.data_for_comparation.rd_75_11_variety;
						// mostramos el contenedor de los calculos
						content_calculos.removeClass('d-none');
						// capturamos el body de la pagina
						var body = $("html, body");
						// función que se ejecuta 3 milisegundos
						setTimeout(function(){
							// nos ubicamos en la posicion del contenedor de calculos previos
							body.stop().animate({scrollTop: content_calculos.offset().top }, 700 );
						}, 300);
						// calculos previos
						$.each( response.calculos_previos, function (ind, elem) { 
							$("."+ind).html( elem );
						}); 

						// resultados de propiedades
						$.each( response.results_simulation, function (ind, elem) { 
							$("."+ind).html( elem );
						}); 

						// resultados de propiedades
						$.each( response.calculos_agroindustrial_properties, function (ind, elem) { 
							$("."+ind).html( elem );
						});
						// mostramos los datos de la varuedad acutal
						load_current_variety( response.months.current_variety );
						// mostramos los datos de la varuedad rd 75 11
						load_current_rd_75_11_variety( response.months.rd_75_11_variety );
					}
					else
					{
						// mostramos los errores de la simulación
						$(".errors-simulation").html( response.message );
					}
				},
				error: function(xhr) {
				   	toastr.error("Ha ocurrido un error.");
				    // console.log(xhr.statusText + xhr.responseText);
				},
			});
			return false;
		});

		$(".load_other_comparation").on('click', function(event) 
		{
			let title = $(this).data('load-title');
			// obtenemos la ruta a donde se va a enviar
			var url = $(this).data('url');
			// validamos si la url no existe
			if( url == "" || url == undefined )
				// evitamos que siga
				return false;
			// obtenemos la ruta a donde se va a enviar
			var property = $(this).data('property');
			// limpiamos el campo de errores
			$(".errors-simulation, .content-current-variety, .content-current-rd-75-11").html('');

			$.ajax({
				url: url,
				type: 'POST',
				data: {
					'variety_id': $("#variety_id").val(),
					'harvest': $("#harvest").val(),
					'soil_quality': $("#soil_quality").val(),
					'number_hectares_planted': $("#number_hectares_planted").val(),
					'data_for_comparation' : data_for_comparation,
					'property' : property,
				},
				dataType: 'json',
				success: function( response ) {
					// console.log( response );
					// validamos el estado de la respuesta
					if( response.status == "success" )
					{
						$(".load_title").html( title );
						// mostramos los datos de la varuedad acutal
						load_current_variety( response.months.current_variety );
						// mostramos los datos de la varuedad rd 75 11
						load_current_rd_75_11_variety( response.months.rd_75_11_variety );
						// llamamos la función para generar la gráfica
						genete_chart( $("#harvest").val(), response.months.current_variety, response.months.rd_75_11_variety );
					}
					else
					{
						// mostramos los errores de la simulación
						$(".errors-simulation").html( response.message );
					}
				},
				error: function(xhr) {
				   	toastr.error("Ha ocurrido un error.");
				    console.log(xhr.statusText + xhr.responseText);
				},
			});
			return false;
		});

	});


	$(window).on("load", function()
	{
		// contenedor de los calculos previos
		var content_calculos = $("#content-calculos-previos");
		// formulario de la simualacion
		var form = $(".form-simulation");
		// obtenemos la ruta a donde se va a enviar
		var url = form.data('action-load');
		// limpiamos el campo de errores
		$(".errors-simulation").html('');
		// ocultamos el contenedor de los calculos
		content_calculos.addClass('d-none');
		$.ajax({
			url: url,
			type: 'POST',
			data: form.serialize(),
			dataType: 'json',
			success: function( response ) {
				// validamos el estado de la respuesta
				if( response.status == "success" )
				{
					// asginamos los datos para comparar para la variedad seleccionada
					data_for_comparation.current_variety = response.data_for_comparation.current_variety;
					// asginamos los datos para comparar para la variedad rd 75 11
					data_for_comparation.rd_75_11_variety = response.data_for_comparation.rd_75_11_variety;
					// mostramos el contenedor de los calculos
					content_calculos.removeClass('d-none');
						// capturamos el body de la pagina
					var body = $("html, body");
					// función que se ejecuta 3 milisegundos
					setTimeout(function(){
						// nos ubicamos en la posicion del contenedor de calculos previos
						body.stop().animate({scrollTop: content_calculos.offset().top }, 700 );
					}, 300);
					// calculos previos
					$.each( response.calculos_previos, function (ind, elem) { 
						$("."+ind).html( elem );
					}); 
					// resultados de propiedades
					$.each( response.results_simulation, function (ind, elem) { 
						$("."+ind).html( elem );
					}); 
					// resultados de propiedades
					$.each( response.calculos_agroindustrial_properties, function (ind, elem) { 
						$("."+ind).html( elem );
					});
					// mostramos los datos de la varuedad acutal
					load_current_variety( response.months.current_variety );
					// mostramos los datos de la varuedad rd 75 11
					load_current_rd_75_11_variety( response.months.rd_75_11_variety );
					// llamamos la función para generar la gráfica
					genete_chart( $("#harvest").val(), response.months.current_variety, response.months.rd_75_11_variety );
				}
				else
				{
					// mostramos los errores de la simulación
					$(".errors-simulation").html( response.message );
				}
			},
			error: function(xhr) {
				toastr.error("Ha ocurrido un error.");
			    // console.log(xhr.statusText + xhr.responseText);
			},
		});
		return false;

	});

	

	// cargamos los datos de la variedad actual
	function load_current_variety( data_months )
	{

		// limpiamos el espacio de llenado
		$(".content-current-variety").html('');
		// resultados de propiedades
		$.each( data_months, function (ind, elem) 
		{
			$(".content-current-variety").append(`
				<div class="row pink lighten-5 align-items-center mb-2 py-2">
					<div class="col-md-3">
						Mes: 
						<span class="font-weight-bold arial">
							`+ind+`
						</span>
					</div>
					<div class="col-md-9 text-truncate">
						% aptitud de cosecha por mes:
						<span class="font-weight-bold arial">
							`+elem.harvest_fitness_percentage+`
						</span>
					</div>
					<div class="col-12 text-truncate mt-2">
						Resultado:
						<span class="font-weight-bold arial load_data produccion_bagazo_verde">
							`+elem.value+`
						</span>
					</div>
				</div>
			`);
		});
	}

	// cargamos los datos de la variedad rd 75 11
	function load_current_rd_75_11_variety( data_months_rd )
	{
		// limpiamos el espacio de llenado
		$(".content-current-rd-75-11").html('');
		// resultados de propiedades
		$.each( data_months_rd, function (ind, elem) 
		{
			$(".content-current-rd-75-11").append(`
				<div class="row blue lighten-5 align-items-center mb-2 py-2">
					<div class="col-md-3">
						Mes: 
						<span class="font-weight-bold arial">
							`+ind+`
						</span>
					</div>
					<div class="col-md-9 text-truncate">
						% aptitud de cosecha por mes:
						<span class="font-weight-bold arial">
							`+elem.harvest_fitness_percentage+`
						</span>
					</div>
					<div class="col-12 text-truncate mt-2">
						Resultado:
						<span class="font-weight-bold arial load_data produccion_bagazo_verde">
							`+elem.value+`
						</span>
					</div>
				</div>
			`);
		});
	}

	function genete_chart( harvest, current_variety_data, rd_variety_data )
	{
		// eliminamos el contendor de la grafica para evitar que se carguen varias graficas
		$("#lineChart").remove();
		// agregamos el contenedor nuevamente
		$(".contenedor-chart").append('<canvas id="lineChart"></canvas>');
		// definimosla variable que contendra los meses
		let months = [];
		// definimosla variable que contendra los datos de la variedad actual
		let current_variety = [];
		// definimosla variable que contendra los datos de la variedad rd
		let rd_variety = [];
		// recorremos la cantida de meses
		for ( var i=0; i < harvest; i++)
			// agregamos el mes
			months.push( "Mes "+ parseInt(i+1) );
		// recorremos la variedad actual
		$.each( current_variety_data, function (ind, elem) {
			// agregamos el mes
			current_variety.push( elem.value );
		});
		// recorremos la variedad r
		$.each( rd_variety_data, function (ind, elem) {
			// agregamos el mes
			rd_variety.push( elem.value );
		});

		//line
		var ctxL = document.getElementById("lineChart").getContext('2d');
		var myLineChart = new Chart(ctxL, {
			type: 'line',
			data: {
				labels: months,
				datasets: [{
					label: "Variedad seleccionada",
					data: current_variety,
					backgroundColor: [
					'rgba(105, 0, 132, .2)',
					],
					borderColor: [
					'rgba(200, 99, 132, .7)',
					],
					borderWidth: 2
				},
				{
					label: "Variedad de control RD 75-11",
					data: rd_variety,
					backgroundColor: [
					'rgba(0, 137, 132, .2)',
					],
					borderColor: [
					'rgba(0, 10, 130, .7)',
					],
					borderWidth: 2
				}
				]
			},
			options: {
				responsive: true
			}
		});
	}
</script>