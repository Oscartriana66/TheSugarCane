<?php 

// clase para conectarse a la base de datos y ejecutar las consultas con PDO

class Conex
{
	// definimos las variables de conexion
	private $host = DB['HOST'];
	private $user = DB['USER'];
	private $pass = DB['PASSWORD'];
	private $name = DB['NAME'];
	private $charset = DB['CHARSET'];

	// creamos una variable que contiene la conexion
	protected $conex;

	// función constructora de la clase
	public function __construct()
	{
	    // definimos la zona horaria
	    date_default_timezone_set( DB['TIMEZONE'] );
	}

	// función para ejecutar consultas al servidor
	// $query: sentenseia sql a ejecutar
	protected function __query( $query )
	{
		// variable que contendra el estado de respuesta de la consulta
		$response = [ 'status' => false ];
		// corremos la conexion con el servidor de bases de datos
		$this->__run();
		// ejecutamos el query y validamos que sea exitoso
		if( !$result = $this->conex->query( $query ) )
		{
			// validamos si estamos en entorno de producción 
			if( APP_ENV === "production" )
				// asignamos mensaje de errror
				$response['message'] = 'Lo sentimos, estamos experimentando problemas. Intentalo nuevamente.';
			else
				$response['message'] = 'Error: La ejecución de la consulta. <br> Query: ' . $query . ' <br> Errno: ' . $this->conex->errno . ' <br> Error: ' . $this->conex->error;
		}
		else
		{
			// cambiamos el estado de ejecución
			$response['status'] = true;
			// asignamos el mensaje de respuesta
			$response['data'] = $result;
		}
		// cerramos la conexion con el servidor de bases de datos
		$this->__close();
		// retornamos ejecutado correctamente
		return $response;
	}

	// función para convertir un array sql en php
	// $result: resultado de una sentencia ejecutada
	protected function __fetch( $result )
	{
		// validamos si contiene datos el resultado de la sentencia ejecutada
		if( $this->__num_rows( $result ) )
			// retornamos los datos convertidos
			return $result->fetch_assoc();
		else
			// retornamos vacio
			return [];
	}

	// función para escapar y evitar SQL Injection
	// $str: string a escapar
	protected function __real_escape_string( $str )
	{
		// corremos la conexion con el servidor de bases de datos
		$this->__run();
		// retornamos el valor escapado
		$response =  $this->conex->real_escape_string( $str );
		// cerramos la conexion con el servidor de bases de datos
		$this->__close();
		// retornamos ejecutado correctamente
		return $response;
	}

	// función para validar que contenga resultados la ejecución
	// $result: resultado de una sentencia ejecutada
	private function __num_rows( $result )
	{
		// validamos si no contiene resultados
		if( $result->num_rows === 0 )
			// retornamos mensaje de errror
			return false;
		// retornamos ejecutado correctamente
		return true;
	}

	// función para ejecutar la conexión con el servidor
	private function __run()
	{
		// validamos que se encuentre habalitada la conexión
		if( DB['STATUS'] == 'on' )
		{
			// realizamos la conexion a la base de datos
			$this->conex = new mysqli( $this->host, $this->user, $this->pass, $this->name );
			// validamos que no se conecte bien
	        if ( $this->conex->connect_errno )
	        	// redireccionamos a la vista de error
	            header("Location: ".URL."/Errors/Conex");
	        // asignamos el charset por defecto a la base de datos
	        $this->conex->set_charset( $this->charset );
		}
	}

	// función para cerrar la conexión a un servidor
	private function __close()
	{
		// cerramos la conexión creada anteriormente
		$this->conex->close();
	}

}