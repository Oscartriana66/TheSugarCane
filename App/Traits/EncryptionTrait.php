<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/EncryptionTrait.php";                                               //
// funcion para encriptar un texto                                                                    //
// $encryption = EncryptionTrait::encryption( $text );                                                //
// funcion para desencriptar un texto                                                                 //
// $decryption = EncryptionTrait::decryption( $text );                                                //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

class EncryptionTrait
{
	// funcion para encriptar un texto
	public static function encryption( $text )
	{
		// declaramos una variable de salida
		$output = false;
		// creamos una clave secreta para ser combinada
		$key = hash( 'sha256', ENCRYPTION['SECRET_KEY'] );
		// obtenemos los primeros 16 caracteres de la combiancion
		$iv = substr( hash( 'sha256', ENCRYPTION['SECRET_IV'] ), 0, 16 );
		// creamos la encriptación
		$output = openssl_encrypt( $text, ENCRYPTION['MHETOD'], $key, OPENSSL_RAW_DATA, $iv );
		// la codificamos en base64
		$output = base64_encode( $output );
		// retornamos el resultado
		return $output;
	}


	// funcion para desencriptar un texto
	public static function decryption( $text )
	{
		// creamos una clave secreta para ser combinada
		$key = hash( 'sha256', ENCRYPTION['SECRET_KEY'] );
		// obtenemos los primeros 16 caracteres de la combiancion
		$iv = substr( hash( 'sha256', ENCRYPTION['SECRET_IV'] ), 0, 16 );
		// creamos la desencriptación
		$output = openssl_decrypt( base64_decode( $text ), ENCRYPTION['MHETOD'], $key, OPENSSL_RAW_DATA, $iv );
		// retornamos el resultado
		return $output;
	}
}