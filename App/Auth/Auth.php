<?php 

// requerimos el modelo de usuario
require_once APP."/Models/User.php";
// requerimos el trait de slug
require_once APP."/Traits/SlugTrait.php";

class Auth extends Model
{
	// campo por donde se inicia sesion
	private $username = "username";
	// campo por el cual se validara el correo ingresado por el usuario para obtener su nueva contraseña
	private $inpu_recover_pass = "username";
	// vista a la que se redirige si hay un login exitoso
	public $viewSuccess = URL."/Simulation/create";
	// vista a la que se redirige si no hay existe una session cuando se valide con el metodo guest
	private $viewRedirect = URL."/Auth/login";
	// variable que contiene la instancia de usuarios
	public $user;

	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();		
		// validamos si no existe una
		if( !isset( $_SESSION[ $this->primary_key ] ) || empty(  $_SESSION[ $this->primary_key  ]  ) || is_null(  $_SESSION[ $this->primary_key  ]  ) ) 
			// inicializamos la sesion
			@session_start();
		// creamos la instancia de usuarios
		$this->user = new User();
	}


	// funcion para realizar el logueo
	public function login( $username, $password )
	{
		// protegemos las variables para evitar el sql injection
		$username = parent::__real_escape_string( $username );
		$password = parent::__real_escape_string( $password );
		// buscamos si existe el usuario en la base de datos
		$result = parent::__query( ' SELECT ' . $this->selectInputs() . ' FROM ' . $this->user->table . ' WHERE ' . $this->username . ' = "' . $username .'" ' );;
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$result['status'] )
			// retornamos el mensaje de error
			return $result['message'];
		// contamos los registros obtenidos para saber si se encontro registros
		if( $result['data']->num_rows > 0 )
		{
			// ahora seleccionamos la contraseña para validar que sea la misma ingresada por el usuario
			$find_password = parent::__query(' SELECT password FROM ' . $this->user->table . ' WHERE ' . $this->username . ' = "' . $username . '" ' );
			// validamos si tenemos un error en la ejecución de la consulta
			if( !$find_password['status'] )
				// retornamos el mensaje de error
				return $find_password['message'];
			// recorremos los datos de la consulta anterior
			$data = parent::__fetch( $find_password['data'] );
			// validamos que las contraseñas sean iguales
			if( password_verify( $password, $data['password'] ) )
			{
				// validamos que el usuario no este bloqueado por exceder número de intentos permitidos
				if( !isset( $_SESSION['bloqueado'] ) || $_SESSION['bloqueado'] == 'no' ) 
				{
					// obtenemos los datos del usuario
					$data = parent::__fetch( $result['data'] );
					// obtenemos los campos que se pueden guardar
					$values = explode(',', $this->selectInputs() );
					// recorremos los campos que se pueden guardar para iniciar una sesion
					foreach( $values as $key )
					{
						// declaramos las variables de sesio que se dejan ver
						$_SESSION[ trim( $key ) ] = $data[ trim( $key ) ];
					}
					// inicializar una variable de sesión que contenga en _token de seguirdad
					$_SESSION['_token'] = $this->generar_password_complejo( 100 );
					// llamamos la función para actualizar el token del usuario
					$response = $this->update_token( $_SESSION['_token'] );
					// validamos que ocurre un error
					if( $response != "success" )
						// retornamos el error
						return $response;
					// retornamos un mensaje de exito
					return "logueado|".$this->viewSuccess;
				}
			}
			// validamos los intentos de acceso a la aplicación
			return $this->validateAttemps();
		}
		else
			// retornamos un mensaje de error
			return "El usuario " . $username . " no existe.";	
	}

	// función para actualizar el _token del usuario
	private function update_token( $_token )
	{
		// actualizamos el _token del usuario
		$request_token = [
			$this->user->primary_key => $_SESSION[ $this->user->primary_key ],
			'_token' => $_token
		];
		// hacemos la petición de actualización
		$response = $this->user->update( $request_token );
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$response )
			// retornamos el mensaje de error
			return $response;
		else
			// retornamos mensaje de exito
			return "success";
	}

	// funcion para cerrar la sesión
	public function logout()
	{
		// validamos si existe una sesion
		if( isset( $_SESSION[ $this->user->primary_key ] ) )
		{
			// eliminamos la variable de seguirdad
			unset( $_SESSION['_token'] );
			// desasemos la sesión
			session_unset();
			// destruimos la sesión
			session_destroy();
		}
	}

	// funcion para registrar un usuario en la base de datos
	public function register( $name, $username, $password, $role, $company, $telephone, $cc )
	{
		// protegemos el valor inicial de las variables
		$username_logueo = $username;
		$password_logueo = $password;
		// protegemos las variables para evitar el sql injection
		$name = parent::__real_escape_string( $name );
		$username = parent::__real_escape_string( $username );
		// encriptamos y protegemos la variable del password
		$password = password_hash( parent::__real_escape_string( $password ) , PASSWORD_BCRYPT );
		// array que pasara los datos a la vista
		$request = [
			'name' => $name,
			'username' => $username,
			'slug' => SlugTrait::generate( $username ),
			'password' => $password,
			'role' => $role,
			'company' => $company,
			'telephone' => $telephone,
			'cc' => $cc,
			'created_at' => date('Y-m-d h:i:s')
		];
		// ejecutamos el registro en el servidor
		$response = $this->user->store( $request );
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$response )
			// retornamos el mensaje de error
			return $response;
		// lo mandamos a loguearde si todo esta correcto
		return $this->login( $username_logueo, $password_logueo );
	}

	// funcion para cambiar contraseña de un usuario con el email en la base de datos
	public function recover_password( $email )
	{
		// protegemos el valor inicial de las variables
		$email_recover = $email;
		// protegemos las variables para evitar el sql injection
		$email = parent::__real_escape_string( $email );
		// buscamos el usuario en la base de datos
		$find_email = parent::customer(' SELECT name FROM '.$this->user->table.' WHERE '.$this->inpu_recover_pass.' = "'.$email.'" ');
		// validamos que obtengamos algún resultado
		if( $find_email->num_rows < 1 )
			// retornamos un mensaje de error
			return "El e-mail ".$email_recover." no se ha encontrado.";
		else
		{
			// creamos una contraseña totalmente aleatoria
			$password = $this->generar_password_complejo( 6, 'without' );
			// encriptamos y protegemos la variable del password
			$password_encriptada = password_hash( parent::__real_escape_string( $password ) , PASSWORD_BCRYPT);
			// buscamos los datos del usuario
			$user = $this->user->find_by_slug( SlugTrait::generate( $email ) );
			// actualizamos el _token del usuario
			$request = [
				$this->user->primary_key => $user[ $this->user->primary_key ],
				'password' => $password_encriptada
			];
			// hacemos la petición de actualización
			$response = $this->user->update( $request );
			// validamos si tenemos un error en la ejecución de la consulta
			if( !$response )
				// retornamos el mensaje de error
				return $response;
			// requerimos los archivos para enviar el correo
			require_once APP."/Traits/SendMailTrait.php";
			require_once APP."/Helpers/EmailTemplates/RecoverpasswordTemplate.php";
			// obtenemos la plantilla para enviar
			$template = RecoverpasswordTemplate::template( $user['name'], $password );
			// enviamos el correo y lo capturamos
			$send = SendMailTrait::send( SMTP['SENT_BY'], APP_NAME.': Sistema de recuperación de contraseña', $template, '', $email );
			// validamos si el mensaje se envio
			if( !$send )
				// retornamos mensaje de error
				return "Ha ocurrido un error al enviar su nueva contraseña a ".$email_recover;
			else
				// retornamos mensaje de exito
				return "enviado";
		}
	}

	// funcion para validar que exista una sesion
	public function check()
	{
		// obtenemos el dato de llave primaria del usuario
		$primary_key = $this->user->__get( $this->primary_key );
		// validamos que sea número, que exista, que no sea vacio o nulo
		if( is_numeric( $primary_key ) && isset( $primary_key ) && !empty( $primary_key ) && !is_null( $primary_key ) )
			// retornamos que existe
			return true;
		// retornamos que no existe
		return false;
	}

	// funcion para validar que exista una sesion y evitar que entren usuarios no deseados
	public function guest()
	{
		// validamos que no existe una sesión
		if( !$this->check() )
			// redirigimos a la vista correspondiente
			header('Location: ' . $this->viewRedirect );
		// retornamos que existe
		return true;
	}

	// funcion para validar que el role del usuario sesionado sea diferente al del enviado por parametro y evitamos que ingrese
	public function role_diff( $role )
	{	
		// validamos exista una sesion
		if( $this->guest() )
		{
			// buscamos el rol del usuario
			$user_role = $this->user->__get( 'role' );
			// validamos que el rol sea diferente, que este vacio, que no exista o que sea nullo
			if( $user_role != $role || empty( $user_role ) || !isset( $user_role ) || is_null( $user_role ) )
				// redirigimos a la vista correspondiente
				header('Location: ' . $this->viewRedirect );
		}
	}

	// funcion para validar que el role del usuario sesionado sea igual al del enviado por parametro y evitamos que ingrese
	public function role_equals( $role )
	{
		// validamos exista una sesion
		if( $this->guest() )
			// buscamos el rol del usuario
			$user_role = $this->user->__get( 'role' );
			// validamos que el rol sea diferente, que este vacio, que no exista o que sea nullo
			if( $user_role == $role || empty( $user_role ) || !isset( $user_role ) || is_null( $user_role ) )
				// redirigimos a la vista correspondiente
				header('Location: ' . $this->viewRedirect );
	}

	// funcion para validar que exista una sesion
	public function validate_role_user( $role )
	{
		// validamos si el rol sea igual y lo redireccionamos
		if( $this->user->__get( 'role' ) == $role )
			// retornamos mensaje de exito
			return true;
		// retornamos mensaje de error
		return false;
	}

	// funcion para obtener el _token del usuario
	public function _token()
	{
		// obteemos el token del usuario
		$_token = $this->user->__get( '_token' );
		// validamos si existe, no es vacio o nulo
		if( isset( $_token ) && !empty( $_token ) && !is_null( $_token ) )
			// retornamos el token
			return $_token;
	}

	// función para validar los intentos que ha hecho el usuario para entrar a la aplicación
	private function validateAttemps()
	{
		// variable que contiene el número de intentos de inicio de sesión
		if( !isset( $_SESSION['attempts'] ) || empty( $_SESSION['attempts'] ) || $_SESSION['attempts'] == 0 )
		{
			// declaramos un valor inicial de la variable de intentos
			$_SESSION['attempts'] = 1;
			// declaramos el momento en el que ingreso a la función de inicio de sesión
			$_SESSION['time_last_attempt'] = new DateTime("now");
			// declaramos la variable que contiene el tiempo de espera inicial
			$_SESSION['wait_time'] = 1;
			// retornamos un mensaje de error
			return "Datos de acceso incorrectos.";
		}
		else
		{
			if( $_SESSION['attempts'] < 3 )
			{
				// retornamos un mensaje de error al usuario
				$m = "Te quedan ".( 3 - $_SESSION['attempts'] )." intentos permitidos.";
				// aumentamos los intentos
				$_SESSION['attempts']++;
			}
			else
			{
				// aumentamos los intentos
				$_SESSION['attempts']++;
				// obtenemos la fecha de la sesión
				$date1 = $_SESSION['time_last_attempt'];
				// obtenemos la fecha de ahora
				$date2 = new DateTime("now");
				// calculamos la diferencia entre las dos fechas
				$diff = $date1->diff($date2);
				// convertimos la diferencia a un número entero
				$diff_time = ( ($diff->days * 24 ) * 60 ) + ( $diff->i );
				// validamos que el tiempo halla trascurrido
				if( $diff_time < $_SESSION['wait_time'] )
				{
					// cambiamos el estado de la variable de bloqueo
					$_SESSION['bloqueado'] = 'si';
					// retornamos un mensaje de espera al usuario
					$m = "Debes esperar ".( $_SESSION['wait_time'] - $diff_time )." minutos para poder realizar otro intento de acceso.";
				}
				else
				{
					// declaramos un valor inicial de la variable de intentos
					$_SESSION['attempts'] = 1;
					// declaramos la variable que contiene el tiempo de espera inicial
					$_SESSION['wait_time'] = ( $_SESSION['wait_time'] * 3 );
					// cambiamos el estado de la variable de bloqueo
					$_SESSION['bloqueado'] = 'no';
					// enviamos mensaje de desbloqueo
					return "Datos de acceso incorrectos.";
				}
			}
			return $m;
		}
	}

	// funcion para crear una contraseña aleatoria
	// $size: es el tamaño de la contraseña por defecto son 15 caracteres
	public function generar_password_complejo( $size = 15, $with_special_characters = 'with' )
	{
		// cadena de letras
		$cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		// adjuntamos los números
		$cadena_base .= '0123456789' ;
		// validamos si se desea tener caracteres especiales
		if( $with_special_characters == 'with' )
			// adjuntalos los caracteres especiales
			$cadena_base .= '!@#%^&*_,./?;:\|=+';
		// variable que contendra la password
		$password = '';
		// obtenemos el tamaño de la cadena de caracteres
		$limite = strlen( $cadena_base ) - 1;
		// recorremos la cadena hasta el tamaño deseado
		for ( $i=0; $i < $size; $i++ )
			// concatenamos el caracter seleccionado
			$password .= $cadena_base[ rand( 0, $limite ) ];
		// retornamos la contraseña creada
		return $password;
	}
}