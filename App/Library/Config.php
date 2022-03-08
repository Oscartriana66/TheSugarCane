<?php

// Versión de Blue Ghost 2.0
// Documentación disponible en https://framework.hyperlinkse.com


// nombre de la clase
class Config
{
	// función constructora de la clase
	public static function __setup()
	{
		// variable de configuraciones
		return [
			// modo de ejecución de la aplicación
			// development => muestra los mensajes de error con ejecución de peticiones MySQL en entorno de desarrollo
			// production => elimina los mensajes de error con ejecución de peticiones MySQL en entorno de producción
			'APP_ENV' => 'production',
			// modo de depuración para alertas de posibles errores de códificación
			'APP_DEBUG' => false,
			// nombre de la aplicación
			'APP_NAME' => 'the sugarcane',
			// url de la aplicación
			'URL' => 'http://thesugarcane.bucaramanga.upb.edu.co',
			// datos de conexion
			'DB' => [
				// estado de la conexión
				'STATUS' => 'on',
				// servidor de base de datos
				'HOST' => 'localhost:3306',
				// usuario del servidor de base de datos
				'USER' => 'root',
				// contraseña del servidor de base de datos
				'PASSWORD' => '1234',
				// nombre de la base de datos
				'NAME' => 'SugarCane',
				// cotejamiento de la base de datos
				'CHARSET' => 'utf-8',
				// zona horaria de la base de datos
				'TIMEZONE' => 'America/Bogota',
			],
			// datos de conexión smtp para envio de correos
			'SMTP' => [
				// servidor de correos
				'HOST' => 'mail.hyperlinkse.com',
				// usuario del servidor de correos
				'USER' => 'comercial@hyperlinkse.com',
				// contraseña del servidor de correos
				'PASSWORD' => 'empresa2018',
				// usuario de envio por defecto
				'SENT_BY' => 'comercial@hyperlinkse.com',
			],
			// datos para el sistema de encriptación
			'ENCRYPTION' => [
				// método de encriptación
				'MHETOD' => 'AES-256-CBC',
				// clave secreta de encriptación
				'SECRET_KEY' => 'aeiou',
				// clave externa de encriptación
				'SECRET_IV' => '123456789',
			],
			// limite de registros por página
			'LIMIT_PER_PAGE' => 10,
			// tamaño máximo de archivos: 1MB, cambie el 1 para aumentar las megas
			'MAX_SIZE_FILE' => ( 1 * 100 ) * 1000,
		];
	}
}
