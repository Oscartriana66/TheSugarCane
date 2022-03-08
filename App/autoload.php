<?php

// nombre de la clase
class Autoload
{
	// función constructora del sistema
	public function __construct()
	{
		// cargamos las librerias de la biblioteca
		spl_autoload_register( function( $class ) 
		{
			// instanciamos las clases de la biblioteca
			require_once 'Library/'.$class . '.php';
		});
	}

	// función que corre el sistema
	public function run( $status_ssl = 'without_ssl' )
	{
		// instanciamos el kernel
		new Kernel( $status_ssl );
	}

}


			