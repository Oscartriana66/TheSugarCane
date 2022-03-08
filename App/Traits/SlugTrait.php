<?php 


////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/SlugTrait.php";                                                     //
// $slug = SlugTrait::generate( $text );                                                              //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

class SlugTrait
{
	// funcion para convertir un texto en un slug
	public static function generate( $text )
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d.]+~u', '-', $text);
		 // transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		 // remove unwanted characters
		$text = preg_replace('~[^-\w.]+~', '', $text);

		 // trim
		$text = trim($text, '-');

		  // remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		  // lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
}