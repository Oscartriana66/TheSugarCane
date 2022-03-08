<?php 


// nombre de la clase
class Route
{
	// declaramos la ruta de los controladores
	private $controllers = APP.'/Controllers/';
	// declaramos la variable vacia por si estan en la raiz del proyecto
	private $folderCurrent = '';
	// si no hay un controlador se cargara por defecto este
	private $controllerCurrent = 'index';
	// variable que contiene el nombre del controllador de errores 404
	private $error404 = 'Error404';
	// si no hay un metodo por defecto se cargara el index
	private $methodCurrent = 'index';
	// declaramos un array vacio para obtener los posibles parametros que se l pueden pasar a la vista
	private $params = [];

	// función constructora de la clase
	public function __construct()
	{
		// generamos la ruta
		$this->generate();
		// cargamos la ruta
		$this->load();
	}

	// funcion que define los parametros de la ruta a cargar
	private function generate()
	{
		// validamos que exista la variable url para saber que estan buscando otra ruta que no sea el index
		if ( isset( $_GET['url'] ) ) 
		{
			// cortamos los espacios que tenga hacia la derecha para dejarla limpia
			$url = rtrim( $_GET['url'], '/' );
			// filtramos para que la interprete como una url
			$url = $this->limpiarUrl( $url );
			// explotamos la variable para obtener los metodos requeridos
			$url = explode('/', $url);
			// declaramos un araray vacio que contendra los indices de los folders, controller, method para eliminarlos de la url para pasarlo como parametros
			$url_delete = [];
			// recorremos el contenido de la variable url
			for( $i = 0; $i < count( $url ); $i++ )
			{
				// validamos que exista algo en la variable
				if( isset( $url[$i] ) )
				{
					// recorremos todas las carpetas que se encuentren
					while ( file_exists( $this->controllers . $this->folderCurrent . '/' . ucwords( $url[$i] ) ) ) 
					{
						// concotenamos el folder por si es mas de uno
						$this->folderCurrent .= ucwords( $url[$i] ) . '/';
						// agregamos esta posicion al array para ser eliminado
						array_push( $url_delete, $i );
					}
					// validamos si no se encuentra el indice entre los ya recorridos
					if( !is_numeric( array_search( $i, $url_delete, true ) ) )
					{
						// validamos si el controlador existe 
						if( file_exists( $this->controllers . $this->folderCurrent . '/' . ucwords( str_replace("-", "_", $url[ $i ] ) ) . 'Controller.php' ) )
						{
							// asignamos este valor al controlador
							// reemplazamos los - por _ para generar rutas mas dinamicas
							$this->controllerCurrent = str_replace("-", "_", $url[ $i ]);
							// agregamos esta posicion al array para ser eliminado
							array_push($url_delete, $i);
							// de lo contrario tomara el valor por defecto
							if( isset( $url[ $i+1 ] ) )
							{
								// reemplazamos los - por _ para generar rutas mas dinamicas
								$this->methodCurrent = str_replace("-", "_", $url[ $i+1 ]);
								// agregamos esta posicion al array para ser eliminado
								array_push( $url_delete, $i+1 );
								// eliminamos los valores de los indices repetidos de la busqueda anterior
								$url_unicos = array_unique( $url_delete );
								// recorremos el array de los indices unicos
								for( $i = 0; $i < count( $url_unicos ); $i++ )
									// eliminamos de la url los valores de foldes, controller, metodo para pasar solo los parametos
									unset( $url[$i] );
								// obtener los posibles parametros
								// si existen para metros le pasamos un arreglo en caso de no tener nada lo dejamos vacio
								$this->params = $url ? array_values( $url ) : [];
								// rompemos el ciclo
								break;
							}
						}
						else
						{
							// si no existe un controlador dejamos el folder vacio para posicionarnos en la raiz de los controladores
							$this->folderCurrent = 'Errors';
							// asignamos el valor del controlador de la pagina de error 404
							$this->controllerCurrent = $this->error404;
						}
					}
				}
			}
		}
	}

	// función para cargar la ruta generada
	private function load()
	{
		// buscar en la carpeta controladores si el controlador existe
		// el ucwords pone la primera letra en mayuscula y el resto en minusculua
		if( file_exists( $this->controllers . ucwords( $this->folderCurrent ) . '/' . ucwords( $this->controllerCurrent ) . 'Controller.php' ) )
			// si existe se asigna como controlador actual
			$this->controllerCurrent = ucwords( $this->controllerCurrent ) . 'Controller';
		else
			// redireccionas al error 404
			header('Location: ' . URL . '/Errors/' . $this->error404 );	
		// cargamos el controlador que queremos ver
		require_once  $this->controllers . ucwords( $this->folderCurrent ) . '/' . ucwords( $this->controllerCurrent ) . '.php';
		// instanciamos el controlador para poder hacer uno de sus funcionalidades
		$this->controllerCurrent = new $this->controllerCurrent;

		// validamos que exista un metodo en la url
		if( isset( $this->methodCurrent ) )
			// validamos la segunda parte de la url que seria el metodo
			if( !method_exists( $this->controllerCurrent, $this->methodCurrent ) )
				// redireccionas al error 404
				header('Location: ' . URL . '/Errors/' . $this->error404 );
		// llamamos el callback con los parametros del array
		call_user_func_array( [ $this->controllerCurrent, $this->methodCurrent ], $this->params );
	}

	// funcion para limpiar la url de caracteres extraños
	private function limpiarUrl( $url )
	{
		// array que contiene los caracteres extraños para evitar problemas
		$order = array( "+", "!", "*", "'", "(", ")", ",", "{", "}", "|", "\\", "^", "~", "[", "]", "`", ">", "<", ";", ":", "&", "=", "%");
		// reemplazamos por vacio cada caracter extraño
		$url =  str_replace( $order, "", $url );
		// retornamos la nueva url
		return $url;
	}

}