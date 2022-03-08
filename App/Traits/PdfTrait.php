<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// Para hacer uno de las plantillas debe importarlas de la siguiente manera                           //
// ejemplo con la plantilla por defecto:                                                              //
// require_once RUTA_APP."/Traits/PdfTrait.php";                                                      //
// require_once RUTA_APP."/Helpers/PdfTemplates/DefaultTemplate.php";                                 //
// $template = DefaultTemplate::template();                                                           //
// Ejemplo para visualizar el pdf guardandolo en el servidor                                          //
// $pdf = PdfTrait::create( $template, $dir, $format, $orientation, $mt, $ml, $mr, $mb );             //
// Ejemplo para visualizar el pdf sin guardarlo en el servidor                                        //
// $pdf = PdfTrait::view( $template, $format, $orientation, $mt, $ml, $mr, $mb );                     //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

// requerimos el autoload de los archivos cargados con composer
require_once VENDOR . '/autoload.php';

class PdfTrait
{
	
	// funcion para crear archivos pdf
	// $template: plantilla del contenido del documento pdf
	// $dir: ubicación de donde se guardara el pdf, desde la carpeta file
	// $format: tipo de formato o tamaño del documento pdf
	// $orientation: 'P' para vertical y 'L' para horizontal
	// $mt: margen del extremo superior
	// $ml: margen del extremo izquierdo
	// $mr: margen del extremo derecho
	// $mb: margen del extremo inferior
	public static function create( $template = '', $dir = '', $format = 'A4', $orientation = 'P', $mt = 0, $ml = 0, $mr = 0, $mb = 0 )
	{
		// arreglamos la ruta dada por el usuario
		$dir = "./file/".$dir;
		// creamos una instancia la libreria de mpdf
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8', 
			'format' => $format, 
			'orientation' => $orientation,
			'margin_top' => $mt,
			'margin_left' => $ml,
			'margin_right' => $mr,
			'margin_bottom' => $mb,
			'mirrorMargins' => true
		]);
		$mpdf->WriteHTML( $template );
		$mpdf->Output( $dir );
	}

	// funcion para crear archivos pdf
	// $template: plantilla del contenido del documento pdf
	// $format: tipo de formato o tamaño del documento pdf
	// $orientation: 'P' para vertical y 'L' para horizontal
	// $mt: margen del extremo superior
	// $ml: margen del extremo izquierdo
	// $mr: margen del extremo derecho
	// $mb: margen del extremo inferior
	public static function view( $template = '', $format = 'A4', $orientation = 'P', $mt = 0, $ml = 0, $mr = 0, $mb = 0 )
	{
		// creamos una instancia la libreria de mpdf
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8', 
			'format' => $format, 
			'orientation' => $orientation,
			'margin_top' => $mt,
			'margin_left' => $ml,
			'margin_right' => $mr,
			'margin_bottom' => $mb,
			'mirrorMargins' => true
		]);
		$mpdf->WriteHTML( $template );
		$mpdf->Output();
	}
}