<?php

// función que carga la vista principal de la pagina
class SimulationController extends Controller
{
	// función constructor del controlador
	public function __construct()
	{
		// llamamos al constructor del padre
		parent::__construct();
		// validamos que exista una sesión
		$this->auth->guest();
		// instanciamos el modelo de usuario
		$this->simulationModel = $this->model('Simulation');
		// instanciamos el modelo de usuario
		$this->simulation_usersModel = $this->model('Simulation_users');
		// instanciamos el modelo de usuario
		$this->varietyModel = $this->model('Variety');
		// instanciamos el modelo de usuario
		$this->variety_propertiesModel = $this->model('Variety_properties');
		// instanciamos el modelo de usuario
		$this->variety_agroindustrial_propertiesModel = $this->model('Variety_agroindustrial_properties');
	}

	// función para redireccionar a la vista con el listado inicial
	public function index()
	{
		// redireccionamos a la vista del listado
		$this->redirect('Simulation/Listing');	
	}

	// función para mostrar la vista con el listado inicial
	public function listing( $pagina = 1, $input_whr = "id", $value_whr = null )
	{
		// obtenemos los datos del modelo
		$lista = $this->data( $pagina, $input_whr, $value_whr );
		// mostramos la vista al usuario
		echo $this->view( 'Simulation/index', $lista );
	}

	// función para mostrar la vista
	public function create()
	{	
		// mostramos la vista
		$this->view('Simulation/create');
	}

	// función para obtener el listado de los usuarios que han realizado cambios
	public function user_updates( $simulation_id )
	{
		// obtenemos el listado de usuarios que han hecho cambios
		$users = $this->simulation_usersModel->find_by_simulation( $simulation_id );

		$tr = '';

		foreach ( $users as $user ) 
		{
			$tr .= '
				<tr>
					<td>'.ucfirst( $user['name'] ).'</td>
					<td>'.ConvertTrait::date_with_hour( $user['created_at'] ).'</td>
				</tr>
			';
		}

		echo $tr;
	}

	// función para consultar por medio de ajax para estar cargando los datos sin recargar la página
	public function pagination( $pagina = 1, $input_whr = "id", $value_whr = null )
	{
		// obtenemos los datos del modelo
		$jsondata = $this->data( $pagina, $input_whr, $value_whr );
		// agregamos la cabecera de json para evitar errores
		header('Content-type: application/json; charset=utf-8');
		// mostramos la vista al usuario
		echo json_encode( $jsondata, JSON_FORCE_OBJECT );
	}

	// función para obtener los datos del listado
	public function data( $pagina, $input_whr, $value_whr )
	{
		// obtenemos obtenemos los datos del listado
		$data = $this->simulationModel->listing( $pagina, $input_whr, $value_whr, $this->auth->user->__get('id') );
		// variable que contendra el listado
		$list = "";
		// validamos que existan datos
		if( $data['cant'] > 0 ) 
		{
			// recorremos los datos existentes
			foreach( $data['list'] as $simulation )
			{
				// vamos concatenando cada dato
				$list .= '
					<tr>
						<td>'.$simulation['id'].'</td>
						<td>'.ucfirst( $simulation['variety'] ).'</td>
						<td>'.ConvertTrait::month_and_day_and_year_short( $simulation['created_at'] ).'</td>
						<td>'.$simulation['number_hectares_planted'].'</td>
						<td>'.$simulation['soil_quality'].' %</td>
						<td>'.$simulation['total_rainfall'].'</td>
						<td>'.$simulation['average_temperature_area'].'</td>
						<td>'.$simulation['harvest'].'</td>
						<td width="10px">
							<a href="'.URL.'/Simulation/Edit/'.$simulation['id'].'" class="btn btn-sm btn-green m-0">
								<i class="fas fa-eye"></i>
							</a>
						</td>
					</tr>
				';
			}
		}
		else
		{
			// asignamos el código para mostrar que no se han encontrado resultados
			$list .= '
				<tr>
					<td colspan="9" class="grey-text text-center h6 py-4">
						<i class="fa fa-ban mr-2"></i>
						No se han encontrado resultados
					</td>
				</tr>
			';
		}
		// cambiamos el valor del parametro que tiene los resultados de la lista con el valor que acabamos de crear
		$data['list'] = $list;
		// retornamos el array
		return $data;	
	}

	public function edit( $simulation_id )
	{
		// buscamos los datos de la simulación
		$simulation = $this->simulationModel->find( $simulation_id );
		// buscamos los datos de la simulación
		$variety = $this->varietyModel->find( $simulation['variety_id'] );
		// asignamos el nombre de la variedad
		$simulation['variety'] = $variety['name'];
		// mostramos la vista
		$this->view('Simulation/details', [ 'simulation' => $simulation ] );
	}

	public function new()
	{
		// validamos si es por método post
		$this->__post();
		// validación de campos
		$errors = $this->validate( $_POST, [
			'variety_id|Variedad para realizar la simulación' => 'required',
			'number_hectares_planted|Número de hectareas sembradas' => 'required',
			'soil_quality|Calidad del suelo (porcentaje)' => 'required',
			'total_rainfall|Precipitaciones totales' => 'required',
			'average_temperature_area|Temperatura promedio de la zona (centigrados)' => 'required',
			'harvest|Recoleccion (número de meses desde el cultivo)' => 'required',
		]);
		// Validamos si existe un error
		if( $errors )
		{
			// Mostramos el mensaje de error al usuario
			$params = [ "status" => "error", "message" => $this->errors('app') ];
		}
		else
		{
			// array que pasara los datos a la vista
			$request = [
				'user_id' => $this->auth->user->__get('id'),
				'variety_id' => $_POST['variety_id'],
				'number_hectares_planted' => $_POST['number_hectares_planted'],
				'soil_quality' => $_POST['soil_quality'],
				'total_rainfall' => $_POST['total_rainfall'],
				'average_temperature_area' => $_POST['average_temperature_area'],
				'harvest' => $_POST['harvest'],
				'created_at' => date('Y-m-d H:i:s')
			];
			// Realizamos la petición de registro
			$result = $this->simulationModel->store( $request );
			// Validamos si existe un error
			if( !$result )
			{
				// Mostramos el mensaje de error al usuario
				$params = [ "status" => "error", "message" => $result ];
			}
			else
			{
				// calculos para la variedad actual
				$current_variety = $this->calculos( $request );
				// calculamos los meses de siembra de la variedad actual
				$calcular_meses_siembra = $this->calcular_meses_siembra( $request['harvest'], $current_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $current_variety['results_simulation']['variety_property']['cane_production'], $current_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
				// eliminamos las propiedades de la variedad 
				// unset( $current_variety['results_simulation']['variety_property'] );
				// definimos una variable vacia
				$rd_variety = [];
				// validamos que la variedad no se la rd 75-11
				if( $request['variety_id'] != 4)
				{
					// actualizamos la variedad para asignar la rd_75_11_variety
					$request['variety_id'] = 4;
					// calculos para la variedad rd 75-11
					$rd_variety = $this->calculos( $request );
					// calculamos los meses de siembra de la variedad rd 75-11
					$calcular_meses_siembra_rd_75_11_variety = $this->calcular_meses_siembra( $request['harvest'], $rd_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $rd_variety['results_simulation']['variety_property']['cane_production'], $rd_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
				}
				// Mostramos el mensaje de error al usuario
				$params = [ 
					"status" => "success",
					"calculos_previos"  => $current_variety['calculos_previos'],
					"results_simulation"  => $current_variety['results_simulation'],
					"calculos_agroindustrial_properties"  => $current_variety['calculos_agroindustrial_properties'],
					"months" => [
						'current_variety' => $calcular_meses_siembra,
						'rd_75_11_variety' => $calcular_meses_siembra_rd_75_11_variety,
					],
					"data_for_comparation" => [
						'current_variety' => $current_variety,
						'rd_75_11_variety' => $rd_variety,
					],
				];
			}
		}
		echo json_encode( $params, JSON_UNESCAPED_UNICODE );
	}

	public function update()
	{
		// validamos si es por método post
		$this->__post();
		// validación de campos
		$errors = $this->validate( $_POST, [
			'variety_id|Variedad para realizar la simulación' => 'required',
			'number_hectares_planted|Número de hectareas sembradas' => 'required',
			'soil_quality|Calidad del suelo (porcentaje)' => 'required',
			'total_rainfall|Precipitaciones totales' => 'required',
			'average_temperature_area|Temperatura promedio de la zona (centigrados)' => 'required',
			'harvest|Recoleccion (número de meses desde el cultivo)' => 'required',
		]);
		// Validamos si existe un error
		if( $errors )
		{
			// Mostramos el mensaje de error al usuario
			$params = [ "status" => "error", "message" => $this->errors('app') ];
		}
		else
		{
			// array que pasara los datos a la vista
			$request = [
				'id' => $_POST['id'],
				'variety_id' => $_POST['variety_id'],
				'number_hectares_planted' => $_POST['number_hectares_planted'],
				'soil_quality' => $_POST['soil_quality'],
				'total_rainfall' => $_POST['total_rainfall'],
				'average_temperature_area' => $_POST['average_temperature_area'],
				'harvest' => $_POST['harvest'],
				'updated_at' => date('Y-m-d H:i:s')
			];
			// Realizamos la petición de registro
			$result = $this->simulationModel->update( $request );
			// Validamos si existe un error
			if( !$result )
			{
				// Mostramos el mensaje de error al usuario
				$params = [ "status" => "error", "message" => $result ];
			}
			else
			{
				// array que pasara los datos a la vista
				$request_users = [
					'simulacion_id' => $_POST['id'],
					'user_id' => $this->auth->user->__get('id'),
					'created_at' => date('Y-m-d H:i:s')
				];
				$this->simulation_usersModel->store( $request_users );
				// calculos para la variedad actual
				$current_variety = $this->calculos( $request );
				// calculamos los meses de siembra de la variedad actual
				$calcular_meses_siembra = $this->calcular_meses_siembra( $request['harvest'], $current_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $current_variety['results_simulation']['variety_property']['cane_production'], $current_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
				// eliminamos las propiedades de la variedad 
				// unset( $current_variety['results_simulation']['variety_property'] );
				// definimos una variable vacia
				$rd_variety = [];
				// validamos que la variedad no se la rd 75-11
				if( $request['variety_id'] != 4)
				{
					// actualizamos la variedad para asignar la rd_75_11_variety
					$request['variety_id'] = 4;
					// calculos para la variedad rd 75-11
					$rd_variety = $this->calculos( $request );
					// calculamos los meses de siembra de la variedad rd 75-11
					$calcular_meses_siembra_rd_75_11_variety = $this->calcular_meses_siembra( $request['harvest'], $rd_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $rd_variety['results_simulation']['variety_property']['cane_production'], $rd_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
				}
				// Mostramos el mensaje de error al usuario
				$params = [ 
					"status" => "success",
					"calculos_previos"  => $current_variety['calculos_previos'],
					"results_simulation"  => $current_variety['results_simulation'],
					"calculos_agroindustrial_properties"  => $current_variety['calculos_agroindustrial_properties'],
					"months" => [
						'current_variety' => $calcular_meses_siembra,
						'rd_75_11_variety' => $calcular_meses_siembra_rd_75_11_variety,
					],
					"data_for_comparation" => [
						'current_variety' => $current_variety,
						'rd_75_11_variety' => $rd_variety,
					],
				];
			}
		}
		echo json_encode( $params, JSON_UNESCAPED_UNICODE );
	}



	public function details()
	{
		// validamos si es por método post
		$this->__post();
		// validación de campos
		$errors = $this->validate( $_POST, [
			'variety_id|Variedad para realizar la simulación' => 'required',
			'number_hectares_planted|Número de hectareas sembradas' => 'required',
			'soil_quality|Calidad del suelo (porcentaje)' => 'required',
			'total_rainfall|Precipitaciones totales' => 'required',
			'average_temperature_area|Temperatura promedio de la zona (centigrados)' => 'required',
			'harvest|Recoleccion (número de meses desde el cultivo)' => 'required',
		]);
		// Validamos si existe un error
		if( $errors )
		{
			// Mostramos el mensaje de error al usuario
			$params = [ "status" => "error", "message" => $this->errors('app') ];
		}
		else
		{
			// array que pasara los datos a la vista
			$request = [
				'user_id' => $this->auth->user->__get('id'),
				'variety_id' => $_POST['variety_id'],
				'number_hectares_planted' => $_POST['number_hectares_planted'],
				'soil_quality' => $_POST['soil_quality'],
				'total_rainfall' => $_POST['total_rainfall'],
				'average_temperature_area' => $_POST['average_temperature_area'],
				'harvest' => $_POST['harvest'],
				'created_at' => date('Y-m-d H:i:s')
			];
			// calculos para la variedad actual
			$current_variety = $this->calculos( $request );
				// calculamos los meses de siembra de la variedad actual
			$calcular_meses_siembra = $this->calcular_meses_siembra( $request['harvest'], $current_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $current_variety['results_simulation']['variety_property']['cane_production'], $current_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
			// definimos una variable vacia
			$rd_variety = [];
			// validamos que la variedad no se la rd 75-11
			if( $request['variety_id'] != 4)
			{
				// actualizamos la variedad para asignar la rd_75_11_variety
				$request['variety_id'] = 4;
				// calculos para la variedad rd 75-11
				$rd_variety = $this->calculos( $request );
				// calculamos los meses de siembra de la variedad rd 75-11
				$calcular_meses_siembra_rd_75_11_variety = $this->calcular_meses_siembra( $request['harvest'], $rd_variety['calculos_previos']['mes_cosecha'], $request['soil_quality'], $rd_variety['results_simulation']['variety_property']['cane_production'], $rd_variety['calculos_previos']['porcentaje_clima'], $request['number_hectares_planted'] );
			}
			// Mostramos el mensaje de error al usuario
			$params = [ 
				"status" => "success",
				"calculos_previos"  => $current_variety['calculos_previos'],
				"results_simulation"  => $current_variety['results_simulation'],
				"calculos_agroindustrial_properties"  => $current_variety['calculos_agroindustrial_properties'],
				"months" => [
					'current_variety' => $calcular_meses_siembra,
					'rd_75_11_variety' => $calcular_meses_siembra_rd_75_11_variety,
				],
				"data_for_comparation" => [
					'current_variety' => $current_variety,
					'rd_75_11_variety' => $rd_variety,
				],
			];
		}
		echo json_encode( $params, JSON_UNESCAPED_UNICODE );
	}

	// función para hacer todos los calculos de la variedad
	public function calculos( $request )
	{
		// calculos previos
		$calculos_previos = $this->calculos_previos( $request );
		// resultados de la simulación
		$results_simulation = $this->results_simulation( $request, $calculos_previos );
		// calculos agroindustriales de las propiedades de la variedad
		$calculos_agroindustrial_properties = $this->calculos_agroindustrial_properties( $request, $calculos_previos );
		// retornamos los datos
		return [
			'calculos_previos' => $calculos_previos,
			'results_simulation' => $results_simulation,
			'calculos_agroindustrial_properties' => $calculos_agroindustrial_properties,
		];
	}

	// función para realizar los calclos previos de la variedad
	public function calculos_previos( $simulation )
	{
		// buscamos los datos de la variedad
		$variety = $this->varietyModel->find( $simulation['variety_id'] );
		// capturamos el mes de la variedad
		$result['mes_cosecha'] = $variety['month'];
		// calculamos el porcentaje de temperatura
		$result['porcentaje_temperatura'] = $this->fix_value( $simulation['average_temperature_area'] / 21 );
		// calculamos el porcentaje de precipitaciones
		$result['porcentaje_precipitaciones'] = $this->fix_value( $simulation['total_rainfall'] / 1700 );
		// calculamos el porcentaje de precipitaciones
		$result['porcentaje_clima'] = $this->fix_value( ( $result['porcentaje_temperatura'] + $result['porcentaje_precipitaciones'] ) / 2 );
		// calculamos el porcentaje de precipitaciones
		$result['porcentaje_aptitud'] = $this->fix_value( $simulation['harvest'] / $variety['month'] );
		// retornamos los datos calculados
		return $result;
	}

	// función para realizar los resultados de la simulación
	public function results_simulation( $simulation, $calculos_previos )
	{
		$calculos_previos['soil_quality'] = ( $simulation['soil_quality'] / 100 );
		// obtenemos las propiedades de la variedad
		$variety_property = $this->variety_propertiesModel->find_by_variety_id( $simulation['variety_id'] );
		// agregamos la
		$result['variety_property'] = $variety_property;
		// calculamos la altura promedio
		$result['altura_promedio_planta'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['average_plant_height'], $calculos_previos ) );
		// calculamos el diametro tallo
		$result['diametro_tallo'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['stem_diameter'], $calculos_previos ) );
		// calculamos el diametro tallo
		$result['longitud_entrenudo'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['internode_length'], $calculos_previos ) );
		// calculamos el indice de crecimiento cm
		$result['indice_crecimiento'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['growth_rate_cm'], $calculos_previos ) );
		// calculamos el indice de crecimiento entrenudo
		$result['indice_crecimiento_entrenudo'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['growth_rate_entrenudo'], $calculos_previos ) );
		// calculamos el indice de tallos molederos
		$result['tallos_molederos_monte_corte'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['grinding_stems_time_cutting'], $calculos_previos ) );
		// calculamos el indice de produccion de caña
		$result['produccion_cana'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['cane_production'], $calculos_previos ) );
		// calculamos el indice de produccion de cogollo semilla
		$result['produccion_cogollo_semilla'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['bud_production_seed'], $calculos_previos ) );
		// calculamos el indice de produccion de palma de hojas verdes
		$result['produccion_palma_hojas_verdes'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['palm_production_green_leaves'], $calculos_previos ) );
		// calculamos el indice de produccion de panela
		$result['produccion_panela'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['panela_production'], $calculos_previos ) );
		// calculamos el indice de rendimiento de panela
		$result['rendimiento_panela'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['yield_panela'], $calculos_previos ) );
		// calculamos el indice de produccion cachaza
		$result['produccion_cachaza'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['cachaca_production'], $calculos_previos ) );
		// calculamos el indice de produccion melote
		$result['produccion_melote'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['melote_production'], $calculos_previos ) );
		// calculamos el indice de produccion bagazo verde
		$result['produccion_bagazo_verde'] = $this->fix_value( $this->calculate_results_simulation( $variety_property['green_bagasse_production'], $calculos_previos ) );
		// retornamos los datos calculados
		return $result;
	}

	// función para realizar los calclos agroindustriales de la variedad
	public function calculos_agroindustrial_properties( $simulation, $calculos_previos )
	{
		// 
		$calculos_previos['soil_quality'] = ( $simulation['soil_quality'] / 100 );
		// buscamos los datos agroindustriales de jugos
		$agroindustrial_jugos = $this->variety_agroindustrial_propertiesModel->find_by_variety_id_and_type( $simulation['variety_id'], 1 );
		// capturamos el dato de jugos brix
		$result['jugos_brix'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['brix'], $calculos_previos ) );
		// capturamos el dato de jugos ph
		$result['jugos_ph'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['ph'], $calculos_previos ) );
		// capturamos el dato de jugos azucares
		$result['jugos_azucares'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['sugars'], $calculos_previos ) );
		// capturamos el dato de jugos sacarosa
		$result['jugos_sacarosa'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['saccharose'], $calculos_previos ) );
		// capturamos el dato de jugos pureza
		$result['jugos_pureza'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['purity'], $calculos_previos ) );
		// capturamos el dato de jugos fosforo
		$result['jugos_fosforo'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['phosphor'], $calculos_previos ) );
		// capturamos el dato de jugos humedad
		$result['jugos_humedad'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_jugos['humidity'], $calculos_previos ) );


		// buscamos los datos agroindustriales de jugos
		$agroindustrial_panela = $this->variety_agroindustrial_propertiesModel->find_by_variety_id_and_type( $simulation['variety_id'], 2 );
		// capturamos el dato de panela brix
		$result['panela_brix'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['brix'], $calculos_previos ) );
		// capturamos el dato de panela ph
		$result['panela_ph'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['ph'], $calculos_previos ) );
		// capturamos el dato de panela azucares
		$result['panela_azucares'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['sugars'], $calculos_previos ) );
		// capturamos el dato de panela sacarosa
		$result['panela_sacarosa'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['saccharose'], $calculos_previos ) );
		// capturamos el dato de panela pureza
		$result['panela_pureza'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['purity'], $calculos_previos ) );
		// capturamos el dato de panela fosforo
		$result['panela_fosforo'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['phosphor'], $calculos_previos ) );
		// capturamos el dato de panela humedad
		$result['panela_humedad'] = $this->fix_value( $this->calculate_results_simulation( $agroindustrial_panela['humidity'], $calculos_previos ) );

		// retornamos los datos calculados
		return $result;
	}

	// función para obtener los datos de las otras comparaciones y cargarlas
	public function load_other_comparation()
	{
		// valiamos si es una variable agroindustrial
		if( $_POST['property'] == 'jugos_brix' || $_POST['property'] == 'jugos_ph' || $_POST['property'] == 'jugos_azucares' || $_POST['property'] == 'jugos_sacarosa' || $_POST['property'] == 'jugos_pureza' || $_POST['property'] == 'jugos_fosforo' || $_POST['property'] == 'jugos_humedad' || $_POST['property'] == 'panela_brix' || $_POST['property'] == 'panela_ph' || $_POST['property'] == 'panela_azucares' || $_POST['property'] == 'panela_sacarosa' || $_POST['property'] == 'panela_pureza' || $_POST['property'] == 'panela_fosforo' || $_POST['property'] == 'panela_humedad' )
		{
			// buscamos el dato por el que se va a buscar en la propieda actual
			$current_property = $_POST['data_for_comparation']['current_variety']['calculos_agroindustrial_properties'][ $_POST['property'] ];
			// buscamos el dato por el que se va a buscar en la propieda rd 75 11
			$rd_75_property = $_POST['data_for_comparation']['rd_75_11_variety']['calculos_agroindustrial_properties'][ $_POST['property'] ];
		}
		else
		{
			// buscamos el dato por el que se va a buscar en la propieda actual
			$current_property = $_POST['data_for_comparation']['current_variety']['results_simulation']['variety_property'][ $_POST['property'] ];
			// buscamos el dato por el que se va a buscar en la propieda rd 75 11
			$rd_75_property = $_POST['data_for_comparation']['rd_75_11_variety']['results_simulation']['variety_property'][ $_POST['property'] ];
		}
		// calculamos los meses de siembra de la variedad actual
		$calcular_meses_siembra = $this->calcular_meses_siembra( $_POST['harvest'], $_POST['data_for_comparation']['current_variety']['calculos_previos']['mes_cosecha'], $_POST['soil_quality'], $current_property, $_POST['data_for_comparation']['current_variety']['calculos_previos']['porcentaje_clima'], $_POST['number_hectares_planted'] );
		// validamos que la variedad no se la rd 75-11
		if( $request['variety_id'] != 4)
		{
			// actualizamos la variedad para asignar la rd_75_11_variety
			$_POST['variety_id'] = 4;
			// calculamos los meses de siembra de la variedad rd 75-11
			$calcular_meses_siembra_rd_75_11_variety = $this->calcular_meses_siembra( $_POST['harvest'], $_POST['data_for_comparation']['rd_75_11_variety']['calculos_previos']['mes_cosecha'], $_POST['soil_quality'], $rd_75_property, $_POST['data_for_comparation']['rd_75_11_variety']['calculos_previos']['porcentaje_clima'], $_POST['number_hectares_planted'] );
		}
		// Mostramos el mensaje de error al usuario
		$params = [ 
			"status" => "success",
			"months" => [
				'current_variety' => $calcular_meses_siembra,
				'rd_75_11_variety' => $calcular_meses_siembra_rd_75_11_variety,
			]
		];
		echo json_encode( $params, JSON_UNESCAPED_UNICODE );
	}

	// función para calcular los meses de siembre
	// haverst: mes que ingresa el usuario para definir los mes que se calcularan
	// mes_cosecha: mes obtimo de cosecha de cada variedad
	// soil_quality: calidad del suelo
	// variety_property: valor de la propiedad a comprar
	// number_hectares_planted: numero de hectareas ingresadas por el usuario, por defecto le colocamos 1 porque en algunas formulas no va
	public function calcular_meses_siembra( $harvest, $mes_cosecha, $soil_quality, $variety_property, $porcentaje_clima, $number_hectares_planted = 1 )
	{
		// arreglamos la calidad del suelo
		$soil_quality = ( $soil_quality / 100 );
		// aproximamos la cantidad de meses de cosecha hacia abajo
		$harvest = floor( $harvest );
		// aproximamos el mes de cosehca hacia abajo
		$mes_cosecha = floor( $mes_cosecha );
		// variable que contendra los datos de los meses
		$months = [];
		// recorremos la cantidad de meses
		for ( $i = 1; $i <= $harvest; $i++ ) 
		{ 
			// calculamos el porcentaje de aptitud de cosecha
			$harvest_fitness_percentage = $i / $mes_cosecha;
			// calculamos el valor del mes
			$value = $this->fix_value( ( ( ( ( $variety_property * $soil_quality ) * $porcentaje_clima ) * $harvest_fitness_percentage ) * $number_hectares_planted) );
			// asginamos el porcentaje de de aptitud por mes de cosecha
			$months[ $i ][ 'harvest_fitness_percentage' ] = $this->fix_value( $harvest_fitness_percentage );
			// asginamos el porcentaje de de aptitud por mes de cosecha
			$months[ $i ][ 'value' ] = $value;
		}

		return $months;
	}

	// función para calcular los resultados de la simulación
	private function calculate_results_simulation( $variety_property, $calculos_previos )
	{
		return ( ( $variety_property * $calculos_previos['soil_quality'] ) * $calculos_previos['porcentaje_clima'] ) * $calculos_previos['porcentaje_aptitud'];
	}

	// función para arreglar un valor
	private function fix_value( $value )
	{
		// validamos si es 0
		if( $value == 0 )
			// retornamos el 0
			return 0;
		// explotamos el valor
		$exp = explode( '.', $value );
		// retornamos el valor arreglado
		return $exp[0].'.'.substr( $exp[1], 0, 3);
	}

}