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

class ConvertTrait
{
	// definimos una variable privada y estatica con los meses del año
	private static $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

	// función para convertir la fecha sin horas
	public static function date( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ]. " ".$fecha[2].", ".$fecha[0] ;
		}
		return '-';
	}

	// función para convertir la fecha sin horas
	public static function date_with_hour( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ]. " ".$fecha[2].", ".$fecha[0] . " a las " . $fecha[4] ;
		}
		return '-';
	}

	// función para convertir la fecha solo mes
	public static function month( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ];
		}
		return '-';
	}

	// función para convertir la fecha solo mes y día
	public static function month_and_day( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ]. " ".$fecha[2];
		}
		return '-';
	}

	// función para convertir la fecha solo mes y año
	public static function month_and_year( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ]. ", ".$fecha[0] ;
		}
		return '-';
	}

	// función para convertir la fecha solo mes abreviado y día
	public static function month_and_day_short( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return substr(self::$meses[ $fecha[1] - 1 ], 0, 3). " ".$fecha[2];
		}
		return '-';
	}

	// función para convertir la fecha solo mes abreviado y día
	public static function month_and_day_and_year_short( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return substr(self::$meses[ $fecha[1] - 1 ], 0, 3). " ".$fecha[2].", ".$fecha[0] ;
		}
		return '-';
	}

	// función para convertir la fecha solo mes abreviado y día
	public static function day_and_month_and_year_short( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return $fecha[2]." ".substr(self::$meses[ $fecha[1] - 1 ], 0, 3).", ".$fecha[0] ;
		}
		return '-';
	}

	// función para convertir la fecha con horas
	public static function date_and_hour( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return self::$meses[ $fecha[1] - 1 ]. " ".$fecha[2].", ".$fecha[0]." a las ".$fecha[4];
		}
		return '-';
	}

	// función para convertir la fecha con horas
	public static function hour( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			// explotamos la fecha para separarla
			$fecha = self::explode( $date );
			// devolvemos el resultado
			return $fecha[4];
		}
		return '-';
	}

	// función para devolver el nombre del día apartir de una fecha
	public static function day_to_name( $date )
	{
		if( !empty($date) && $date != "0000-00-00 00:00:00" && $date != "0000-00-00" )
		{
			//a timestamp 
			$dates = strtotime($date); 
			//el parametro w en la funcion date indica que queremos el dia de la semana 
			//lo devuelve en numero 0 domingo, 1 lunes,.... 
			switch (date('w', $dates)){ 
				case 0: return "Domingo"; break; 
				case 1: return "Lunes"; break; 
				case 2: return "Martes"; break; 
				case 3: return "Miércoles"; break; 
				case 4: return "Jueves"; break; 
				case 5: return "Viernes"; break; 
				case 6: return "Sábado"; break; 
			} 
		}
		return '-';
	}

	// función para darle formato a un numero de celular
	public static function cellphone_space( $cellphone )
	{
		if( !empty($cellphone) )
		{
			// obtenemos la cantidad de numeros
			$len = strlen( $cellphone );
			// validamos si es de 8 cifras
			if( $len == 9 )
				return wordwrap($cellphone, 3, " ", 1);
			else if( $len == 10 )
			{
				// explotamos el numero
				$cellphone_exp = str_split($cellphone, 1);
				// variable que contendra el numero nuevo
				$cellphone_new = '';
				// recorremos el vector con los números
				for ($i=0; $i < count( $cellphone_exp ); $i++) 
				{ 
					// concatenamos el nuevo valor
					$cellphone_new .= $cellphone_exp[$i];
					// validamos si es la pareja de 3 números
					if( $i == 2 || $i == 5 )
						// agregamos el campo vacio
						$cellphone_new .= ' ';
				}
				// retornamos el valor del celular
				return $cellphone_new;
			}
			else
				// retornamos el valor del celular
				return $cellphone;
		}
		return '-';
	}

	// función que devuelve en forma de directorio los datos de la hora a convertir
	public static function explode( $date )
	{
		// explotamos la fecha para separarla
		$fecha_exp = explode( ' ', $date );
		// explotamos la fecha para obtener y, m, d
		$fecha = explode( '-', $fecha_exp[0] );
		// validamos si existe la variable que controla la hora
		if( isset( $fecha_exp[1] ) )
			// asignamos a la posición 4 la hora
			$fecha[4] = $fecha_exp[1];
		// devolvemos el resultado
		return $fecha;
	}

}