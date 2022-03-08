<?php

// requerimos el controlador de simulaciones
require_once APP.'/Controllers/SimulationController.php';
// función que carga la vista principal de la pagina
class UserController extends Controller
{
	// función constructor del controlador
	public function __construct()
	{
		// llamamos al constructor del padre
		parent::__construct();
		// validamos que exista una sesión
		$this->auth->guest();
		// instanciamos el modelo de usuario
		$this->userModel = $this->model('User');
		// instanciamos el modelo de usuario
		$this->companyModel = $this->model('Company');
		// instanciamos el modelo de usuario
		$this->simulationModel = $this->model('Simulation');
		// instanciamos el modelo de usuario
		$this->varietyModel = $this->model('Variety');
		// instanciamos el controlador de simulaciones
		$this->SimulationController = new SimulationController();
	}

	// función para redireccionar a la vista con el listado inicial
	public function index()
	{
		// redireccionamos a la vista del listado
		$this->redirect('User/Listing');	
	}

	// función para mostrar la vista con el listado inicial
	public function listing( $pagina = 1, $input_whr = "name", $value_whr = null )
	{
		// obtenemos los datos del modelo
		$lista = $this->data( $pagina, $input_whr, $value_whr );
		// mostramos la vista al usuario
		echo $this->view( 'User/index', $lista );
	}

	// función para mostrar la vista
	public function edit( $slug, $type = '', $simulation_id = '' )
	{	
		if( !isset( $type ) || empty( $type ) || !isset( $simulation_id ) || empty( $simulation_id ) )
		{
			// obtenemos los datos del usuario
			$user = $this->__get_data( $slug );
			// obtenemos el rol del usuario
			$user['role'] = $this->fix_role( $user['role'] );
			// obtenemos el rol del usuario
			$user['company'] = $this->fix_company( $user['company'] );
			// obtenemos obtenemos los datos del listado
			$response = $this->simulationModel->listing_per_user( $user['id'] );
			// variable que contendra el listado
			$list = '';
			// validamos si hay resultados
			if( $response->num_rows > 0 )
			{
				// recorremos los datos existentes
				foreach( $response as $simulation )
				{
					// vamos concatenando cada dato
					$list .= '
						<tr>
							<td>'.$simulation['id'].'</td>
							<td>'.ConvertTrait::date_with_hour( $simulation['created_at'] ).'</td>
							<td>'.$simulation['number_hectares_planted'].'</td>
							<td>'.$simulation['soil_quality'].' %</td>
							<td>'.$simulation['total_rainfall'].'</td>
							<td>'.$simulation['average_temperature_area'].'</td>
							<td>'.$simulation['harvest'].'</td>
							<td width="10px">
								<a href="'.URL.'/User/Edit/'.$user['slug'].'/Simulation/'.$simulation['id'].'" class="btn btn-sm btn-green m-0">
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
						<td colspan="8" class="grey-text text-center h6 py-4">
							<i class="fa fa-ban mr-2"></i>
							No se han encontrado resultados
						</td>
					</tr>
				';
			}
			// mostramos la vista
			$this->view('User/edit', [ 'user' => $user, 'list' => $list ] );
		}
		else
		{
			// buscamos los datos de la simulación
			$simulation = $this->simulationModel->find( $simulation_id );
			// buscamos los datos de la simulación
			$variety = $this->varietyModel->find( $simulation['variety_id'] );
			// asignamos el nombre de la variedad
			$simulation['variety'] = $variety['name'];
			// obtenemos los calculos con los datos registrados
			$calculos = $this->SimulationController->calculos( $simulation );
			// eliminamos los datos de la propiedad
			unset( $calculos['results_simulation']['variety_property'] );
			// mostramos la vista
			$this->view('Simulation/details', [ 'simulation' => $simulation, 'calculos' => $calculos ] );
		}
	}

	// función para mostrar la vista
	public function profile()
	{	
		// obtenemos el slug del usuario
		$slug = $this->auth->user->__get('slug');
		// obtenemos los datos del usuario
		$user = $this->__get_data( $slug );
		// obtenemos el rol del usuario
		$user['role'] = $this->fix_role( $user['role'] );
		// obtenemos el rol del usuario
		$user['company'] = $this->fix_company( $user['company'] );
		// mostramos la vista
		$this->view('User/profile', [ 'user' => $user ] );
	}

	// función para consultar por medio de ajax para estar cargando los datos sin recargar la página
	public function pagination( $pagina = 1, $input_whr = "name", $value_whr = null )
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
		$data = $this->userModel->listing( $pagina, $input_whr, $value_whr, $this->auth->user->__get('role') );
		// variable que contendra el listado
		$list = "";
		// validamos que existan datos
		if( $data['cant'] > 0 ) 
		{
			// recorremos los datos existentes
			foreach( $data['list'] as $user )
			{
				switch ($user['role']) {
					case 1:
						$role = 'Administrador';
					break;
					case 2:
						$role = 'Asesor';
					break;
					
					default:
						$role = 'Agrónomo';
					break;
				}
				$options = '';
				// validamos que el usuario sea diferente de 3
				if( $this->auth->user->__get('role') != 3 )
				{
					$options = '
						<td width="10px">
							<a href="'.URL.'/User/Edit/'.$user['slug'].'" class="btn btn-sm btn-green m-0">
								<i class="fas fa-eye"></i>
							</a>
						</td>
					';
				}
				// validamos que sea empleado
				if( $this->auth->user->__get('role') == 1 )
				{
					$options .= '
						<td width="10px">
							<a data-toggle="modal" data-target="#modalConfirmDelete" class="open-confirm-delete btn btn-sm btn-danger ml-auto" data-id="'.$user['id'].'">
								<i class="fas fa-trash"></i>
							</a>
							<form id="form-delete-'.$user['id'].'" action="'.URL.'/user/delete" method="POST" style="display: none;">
								'.$this->__csrf_field().'
								<input type="hidden" name="id" value="'.$user['id'].'">
							</form>
						</td>
					';
				}
				// vamos concatenando cada dato
				$list .= '
					<tr>
						<td>'.$user['id'].'</td>
						<td>'.ucfirst( $user['name'] ).'</td>
						<td>'.$user['username'].'</td>
						<td>'.$role.'</td>
						<td>'.ConvertTrait::date( $user['updated_at'] ).'</td>
						'.$options.'
					</tr>
				';
			}
		}
		else
		{
			// asignamos el código para mostrar que no se han encontrado resultados
			$list .= '
				<tr>
					<td colspan="6" class="grey-text text-center h6 py-4">
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

	public function update()
	{
		// Validamos que sea una petición enviada por post
		$this->__post();
		// validación de campos
		$errors = $this->validate( $_POST, [
			'name|nombre' => 'required',
			'username|usuario' => 'required',
		]);
		// Validamos si existe un error
		if( $errors )
		{
			// Mostramos el mensaje de error al usuario
			echo $this->errors();
			// evitamos que siga la función
			return;
		}
		//  validamos si existe la pass
		if( isset( $_POST['password'] ) && !empty( $_POST['password'] ) )
		{
			// validamos si son iguales
			if( $_POST['confirm-password'] != $_POST['password'] )
			{
				array_push( $this->errors, "Las contraseñas no coinciden.");
				echo $this->errors();
				exit();
			}
		}
		// array que pasara los datos a la vista
		$request = [
			'id' => $_POST['id'],
			'name' => $_POST['name'],
			'username' => $_POST['username'],
			'slug' => SlugTrait::generate( $_POST['username'] ),
			'password' => $_POST['password'],
			'role' => $_POST['role'],
			'company' => $_POST['company'],
			'telephone' => $_POST['telephone'],
			'cc' => $_POST['cc'],
			'updated_at' => date('Y-m-d h:i:s')
		];
		// validamos si no esta vacio
		if( empty( $_POST['password'] ) )
			// eliminamos el campo de pass
			unset( $request['password'] );
		// Realizamos la petición de registro
		$result = $this->userModel->update( $_POST );
		// Validamos si existe un error
		if( !$result )
		{
			// Agregamos el mensaje a la variable para ser mostrada
			array_push( $this->errors, $result );
			// Mostramos el mensaje de error al usuario
			echo $this->errors();
		}
		else
		{
			// buscamos los datos
			$response = $this->companyModel->find_by_select( $_POST['company'] );
			// validamos si no hay resultados
			if( $response->num_rows < 1 )
			{
				$request = [
					'name' => $_POST['company'],
					'created_at' => date('Y-m-d'),
				];
				$this->companyModel->store( $request );
			}
			// Mostramos el mensaje de éxito al usuario
			echo "true";
		}
		
	}

	// función para buscar los datos de un usuario
	private function __get_data( $slug )
	{
		// buscamos los datos del usuario
		$response = $this->userModel->find_by_slug( $slug );
		// retornamos los datos encontrados
		return $response;
	}

	// funcipin para arreglar el rol
	private function fix_role( $role )
	{
		switch ( $role ) 
		{
			case '1':
				return 'Administrador';
			break;
			case '2':
				return 'Asesor';
			break;			
			default:
				return 'Agrónomo';
			break;
		}
	}

	// funcipin para arreglar la compañia
	private function fix_company( $company )
	{
		if ( $company == 'NULL' ) 
			return '';
		else
			return $company;
	}

}