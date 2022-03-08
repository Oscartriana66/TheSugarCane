<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/ValidateUniqueTrait.php";                                           //
// $validateUnique = ValidateUniqueTrait::check( $str, $input, $table, $id );                //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////


class ValidateUniqueTrait extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// funcion para validar la existencia de un dato campo en una tabla
	public function check( $str, $input, $table, $id )
	{
		// buscamos el texto ingresado por el usuario de la tabla deseada para el campo ingresado 
		// si existe un $id quiere decir que busque en todos menos en ese registro
		$result = parent::customer( ' SELECT ' . $input . ' FROM ' . $table . ' WHERE ' . $input . ' = "' . $str . '" and id != "' . $id . '" ' );
		// validamos si se contraron resultados
		if( $result->num_rows > 0 )
			// retornamos que se encontro resultados
			return false;
		else
			// retornamos que no se encontro resultados
			return true;
	}

}