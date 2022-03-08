<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/BreadcrumbTrait.php";                                               //
// función para convertir texto a breadcrumb                                                          //
// $breadcrumb = ConvertTrait::convert( $title = '', $links = [] );                                   //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

class BreadcrumbTrait
{

	// función para convertir un array a el estilo del breadcrumb
	// $title: titulo de la página
	// $links: array que contiene los datos de cada link
	public static function convert( $title = '', $links = [] )
	{
		// creamos variable que retornara el breadcrumb arreglado
		$content = '
			<div class="row w-100 align-items-center">
				<div class="col-12 col-md-6">
					<h4>'.$title.'</h4>
				</div>
				<div class="col-12 col-md-6">
					<div class="list-breadcrumb text-truncate text-md-right">
		';
		// variable que servira de contador
		$i = 0;
		// variable que contiene el número total de arreglos
		$count = count($links)-1;
		// variable que recorrera el array de los links
		foreach ($links as $link) 
		{
			// validamos si es la última posición del arreglo
			if( $i == $count )
				// agregamos el item al breadcrumb sin href
				$content .= '<a>'.$link['text'].'</a>';
			else
				// agregamos el item al breadcrumb con href
				$content .= '<a href="'.$link['url'].'">'.$link['text'].'</a>';
			// aumentamos la variable contadora
			$i++;
		}
		// concatenamos el div para cerrar la lista
		$content .= '
					</div>
				</div>
			</div>
		';
		// retornamos el el breadcrumb generado
		return $content;
	}


}