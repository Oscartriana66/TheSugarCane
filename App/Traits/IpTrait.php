<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/ConvertTrait.php";                                                  //
// función para convertir la fecha sin horas                                                          //
// $date = ConvertTrait::date( $date );                                                               //
// función para convertir la fecha solo mes y día                                                     //
// $date = ConvertTrait::month_and_date( $date );                                                     //
// función para convertir la fecha con horas                                                          //
// $date = ConvertTrait::date_and_hour( $date );                                                      //
// función para devolver el nombre del día apartir de una fecha                                       //
// $date = ConvertTrait::day_to_name( $date );                                                        //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

class IpTrait
{

	// funcion para obtener la ip del usuario
	public static function __get() 
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

}