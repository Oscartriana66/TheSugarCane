<?php

// nombre de la clase
class Kernel
{
	// constructor
	public function __construct( $status_ssl = 'without_ssl' )
	{
		// llamamos la función que contiene las variables globales del sistema
		$this->__globlas();
		// llamamos al archivo de configuraciones
		$this->__config();
		// llamamos la función de formarzar el certificado ssl
		$this->__forze_ssl( $status_ssl );
		// validamos el estado de depuración del sistema
		$this->__debug();
		// llamamos el archivo de generación de rutas
		$this->__route();
	}

	// función que contendra las variables globales del sistema
	private function __globlas()
	{
		// separador de directorios para rutas reales \
		define( 'DS' , DIRECTORY_SEPARATOR);
		// definimos el directorio de la carpeta app
		define( 'APP', dirname(__DIR__) );
		// ruta publica del real del sistema, evitar usarla lo mas posible
		define( 'PUBLIC_FOLDER', dirname( APP ) . '/Public/' );
		// ruta publica para acceder a los paquetes instalados con composer
		define( 'VENDOR', dirname( APP ) . '/Vendor/' );
		// ruta para la carpeta privada de las vistas
		define( 'RESOURCES', APP . '/Resources' );
	}

	// función que corre el sistema
	private function __config()
	{
		// instanciamos el kernel
		$config = Config::__setup();
		// ruta para la carpeta publica css
		$config['CSS'] = $config['URL'] . '/css';
		// ruta para la carpeta publica js
		$config['JS'] = $config['URL'] . '/js';
		// ruta para la carpeta publica img
		$config['IMG'] = $config['URL'] . '/img';
		// ruta para la carpeta publica img
		$config['FILE'] = $config['URL'] . '/file';
		// recorremos los datos de configuracion
		foreach ( $config as $key => $value ) 
			// definimos la varible globarl URL
			$this->__set_global( $key, $value );
	}

	// función para definir variables globales
	private function __set_global( $name, $value )
	{
		// función para crear variables globales
		define( $name , $value );
	}
	
	// función para generar la ruta
	private function __route()
	{
		// retornamos la instancia del controlador de rutas
		return new Route;
	}	

	// validamos si estamos en modo de depuración
	private function __debug()
	{
		// validamos si tenemos activo el estado de depuración
		if( APP_DEBUG )
			// permitimos mostrar todos los errores de códificación
			error_reporting( E_ALL );
		else
			// ocultamos todos los errores de códificación
			error_reporting( 0 );
	}

	// función para forzar conexión ssl
	private function __forze_ssl( $status )
	{
		// validamos si el estado esta encendido
		if( $status == 'ssl' )
			// validamos si aun no se encuentra en https
			if ( !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' )
				// redireccionamos a la misma vista pero con ssl activo
				header( 'Location: https://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
	}

}