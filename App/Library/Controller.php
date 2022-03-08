<?php 

// requerimos la clase de autentificacion
require_once APP."/Auth/Auth.php";
// requerimos el trait de los slugs
require_once APP."/Traits/ValidateEmailTrait.php";
// requerimos el trait de la validacion de un campo unique
require_once APP."/Traits/ValidateUniqueTrait.php";
// requerimos el trait de la validacion de un campo unique
require_once APP."/Traits/ConvertTrait.php";

// nombre de la clase
class Controller
{
	// array vacio para guardar los errores del sistema
	protected $errors = [];
	// variable que contendra la instancia de la sesión
	public $auth;

	// funcion para obtener los datos y funcionalidades de la sesion de un usuario
	public function __construct()
	{
		// creamos una instancia de la clase para manipular las variables de sesion
		$this->auth = new Auth;
	}

	// carga el modelo que se desea desde el controlador hijo
	public function model( $model )
	{
		// dejamos la primera palabra en mayuscula
		$model = ucwords( $model );
		// incluimos el model
		require_once APP.'/Models/' . $model . '.php';
		// instanciamos el modelo
		return new $model();
	}

	// carga las vistas despues de realizar alguna accion a la base de datos
	public function redirect( $view )
	{
		// reubicamos la vista para evitar que se reejecute la accion antes realizada
		header('Location: ' . URL . '/' . $view );
	}

	// carga el vista por metodo get
	public function view( $view, $params = [] )
	{
		// validamos que el archivo de la vista exista
		if( file_exists( RESOURCES.'/Views/' . $view . '.php' ) )
			// llamamos a la vista
			require_once RESOURCES.'/Views/' . $view . '.php';
		else
			// llamamos a la vista de ellor
			$this->page_error();
	}

	// funcion para validar campos de la base de datos
	// $request: es el array quec contiene los datos
	// $validations: son las validaciones a aplicar
	// return el valor que contiene la variable de errores por si se realiza con ajax para evitar problemas
	protected function validate( $request, $validations )
	{
		// array vacio para guardar los nombres de las posiciones del request
		$keys_request = [];
		// array vacio para guardar los errores del sistema
		$this->errors = [];
		// recorremos el elemento actual del request
		foreach ( $request as $key ) 
		{
			// validamos si existe una sesión
			if( $this->auth->check() )
			{
				// validamos que exista el _token de sesión para realizar acciones
				if( isset( $request['_token'] ) && !empty( $request['_token'] ) )
				{
					// validamos si el _token de sesión es el mismo al que tenemos registrado
					if( $request['_token'] != $this->auth->_token() )
					{
						// retornamos un mensaje de error al usuario
						array_push( $this->errors, "Lo sentimos, tus permisos no coinciden. Por favor comunicarse con el administrador por la seguridad de la aplicacion." );
						// retornamos el valor de la variable de errores
						return $this->errors;
					}
				}
				else
				{
					// retornamos un mensaje de error al usuario
					array_push( $this->errors, "No tienes permisos para realizar esta acción, no cuentas con una certificación CSRF válida. Por favor recargue la página y comunicate con el administrador por la seguridad de la aplicacion." );					
					// retornamos el valor de la variable de errores
					return $this->errors;
				}
			}
			// agregamos al array vacio el nombre de la posicion con ayuda de la palabra reservada key
			array_push( $keys_request, key($request) );
			// pasamos a la siguiente posicion del array
			next($request);
		}

		// recorremos el elemento actual de las validaciones
		while ( current($validations) ) 
		{
			// explotamos la key del array para obtener el nombre del campo de la base de datos y el nombre del campo a retornar a la vista
			$key_validations = explode('|', key($validations) );
			// preguntamos si existe el nombre de la posicion de validaciones en el array que contiene los nombres de las posiciones de los datos a ser evaluados
			if( in_array( $key_validations[0], $keys_request ) )
			{
				// obtenemos el tipo de validacion de la posicion que se encontro en el array vacio dentro del array de validaciones
				$types = explode('|', $validations[ key($validations) ] );
				foreach( $types as $type )
				{
					// validacion para requeridos
					if( $type == 'required' )
					{
						// validamos que el campo no sea nulo ni vacio
						if( is_null( $request[ $key_validations[0] ] ) or empty( $request[ $key_validations[0] ] )  or !isset( $request[ $key_validations[0] ] ) )
							array_push( $this->errors, "El campo <b>". $key_validations[1] ."</b> es requerido" );
					}
					// validacion para numeros
					if( $type == 'number' )
					{
						// validamos que sea un campo numerico
						if( !is_numeric( $request[ $key_validations[0] ] ) )
							array_push( $this->errors, "El campo <b>". $key_validations[1] ."</b> no es un número" );
					}
					// validacion para emails
					if( $type == 'email' )
					{
						if ( !ValidateEmailTrait::check( $request[ $key_validations[0] ] ) ) {
							array_push( $this->errors, "El campo <b>". $key_validations[1] ."</b> no es una dirección de e-mail valida" );
						}
					}
					// explotamos la cadena para validar si es de tipo unique
					$type = explode(':', $type);
					// validamos si en la posicion 0 es unique de resto no entra
					if( $type[0] == 'unique' ){
						// creamos una instancia de la validacion para poder acceder a la clase conexion
						$validateunique = new ValidateUniqueTrait();
						// valido si existe algun id como parametro para evitar evaludar ese campo
						isset( $type[2] ) ? $type[2] = $type[2] : $type[2] = '';
						// preguntamos si encontro un registro 
						if( !$validateunique->check( $request[ $key_validations[0] ], $key_validations[0], $type[1], $type[2] ) )
							// retornamos un mensaje de error al usuario
							array_push( $this->errors, "El <b>" . $key_validations[1] . " ". $request[ $key_validations[0] ] ."</b> ya existe." );
					}
				}
			}
			// si no existe mandamos un error
			else
			{
				// enviamos un mensaje de que el campo es requerdio
				array_push( $this->errors, "El campo <b>". $key_validations[1] ."</b> es requerido" );
			}
			// pasamos a la siguiente posicion del array
			next($validations);
		}
		// retornamos el valor de la variable de errores
		return $this->errors;
	}

	// funcion para crear un textbox el _token oculto en un formulario
	protected function __csrf_field()
	{
		return '<input type="hidden" id="_token" name="_token" value="'.$this->auth->_token().'" />';
	}

	// funcion para crear un textbox el _token oculto en un formulario
	protected function __csrf_token()
	{
		return $this->auth->_token();
	}

	// funcion que nos devuelve la vista de error404
	private function page_error()
	{
		$this->redirect('Errors/Error404');
	}

	// funcion para validar que el metodo de envio sea post
	protected function __post()
	{
		// validamos si no existe la variable post o viene vacia
		if( !$_SERVER['REQUEST_METHOD'] || empty( $_SERVER['REQUEST_METHOD'] ) || $_SERVER['REQUEST_METHOD'] != "POST" )
			// redireccionamos a la página de error
			$this->page_error();
	}

	// función para mostrar los errores de usuario
	protected function errors( $type = "web" )
	{
		// validamos si existen errores, no sea vacio o nullo
		if( isset( $this->errors ) && !empty( $this->errors ) && !is_null( $this->errors ) )
		{
			// validamos si son para la web
			if( $type == "web" )
			{
				echo '
					<div class="container my-4">
						<div class="row justify-content-center">
							<div class="col-12 alert alert-danger pb-0" >
								<ul class="pb-0">
				';
									foreach ($this->errors as $error) 
									{
										echo "<li> $error </li>";
									} 
				echo '
								</ul>
							</div>
						</div>
					</div>
				';
			}
			else
			{
				// variable que contendra los errores
				$errors = '<div class="container my-4"><div class="row justify-content-center"><div class="col-12 alert alert-danger pb-0" ><ul class="pb-0">';
				// recorremos los errores
				foreach ($this->errors as $error) 
					// concatenanmos los errores
					$errors .= '<li>'.$error.'</li>';
				$errors .= '</ul></div></div></div>';
				// retornamos el array de errores
				return $errors;
			}
		}
	}

}
