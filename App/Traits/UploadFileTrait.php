<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// ejemplo su uso:                                                                                    //
// require_once RUTA_APP."/Traits/UploadFileTrait.php";                                               //
// $uploadImg = UploadFileTrait::uploadImg( $file, $folder);                                          //
// $uploadFile = UploadFileTrait::uploadFile( $file, $folder);                                        //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

// requerimos el trait de los slugs
require_once APP."/Traits/SlugTrait.php";

class UploadFileTrait
{
	// funcion para subir imagenes al servidor
	public static function uploadImg( $file, $folder )
	{
		// obtenemos el nombre con los segundos y el nombre arreglado por el slug
		$name = date('i-s-') . SlugTrait::slug( $file['name'] );
		// obtenemos el tipo de imagen
		$type = $file['type'];
		// obtenemos el nombre temporal del archivo
		$tmp_name = $file['tmp_name'];
		// obtenemos el tamaño del archivo
		$size = $file['size'];
		// validamos que sea una imagen
		if( UploadFileTrait::validateImg( $type ) )
		{
			// validamos que el tamaño de la archivo sera el permitido
			if( $size <= MAX_SIZE_FILE )
			{
				// asignamos nombre a la carpeta
				$carpeta = PUBLIC_FOLDER . '/' . 'img' . '/' . $folder;
					// creamos la carpeta si no existe
				if (!file_exists($carpeta))
					mkdir($carpeta, 0777, true);
						// creamos la ruta de acuerdo a la varible global public
				$ruta = $carpeta . '/' . $name;
						// subimos el archivo a la ruta correspondiente
				move_uploaded_file($tmp_name, $ruta);
						// retornamos el nombre
				return [$name];
			}
			// si el tamaño es mayor al del permito retornamos un mensae de error
			return ['error', 'Tamaño máximo: '. MAX_SIZE_FILE .' Mb y el tamaño del archivo es de: ' . $size / 1000000  .' Mb'];
		}
		// si no es una imagen retornamos un mensae de error
		return ['error', 'Archivos aceptados .jpg, .jpeg, .png, .gif'];
	}

	// funcion para subir archivos al servidor
	public static function uploadFile( $file, $folder )
	{
		// obtenemos el nombre con los segundos y el nombre arreglado por el slug
		$name = date('i-s-') . SlugTrait::slug( $file['name'] );
		// obtenemos el tipo de archivo
		$type = $file['type'];
		// obtenemos el nombre temporal del archivo
		$tmp_name = $file['tmp_name'];
		// obtenemos el tamaño del archivo
		$size = $file['size'];
		// validamos que sea un archivo
		if( UploadFileTrait::validateFile( $type ) )
		{
			// validamos que el tamaño de la archivo sera el permitido
			if( $size <= MAX_SIZE_FILE )
			{
				// asignamos nombre a la carpeta
				$carpeta = PUBLIC_FOLDER . '/' . 'file' . '/' . $folder;
				// creamos la carpeta si no existe
				if (!file_exists($carpeta))
					mkdir($carpeta, 0777, true);
				// creamos la ruta de acuerdo a la varible global public
				$ruta = $carpeta . '/' . $name;
				// subimos el archivo a la ruta correspondiente
				move_uploaded_file($tmp_name, $ruta);
				// retornamos el nombre
				return [$name];
			}
			// si el tamaño es mayor al del permito retornamos un mensae de error
			return ['error', 'Tamaño máximo: '. MAX_SIZE_FILE .' Mb y el tamaño del archivo es de: ' . $size / 1000000  .' Mb'];
		}
		// si no es un archivo retornamos un mensae de error
		return ['error', 'Archivos aceptados .pdf, .word, .xls, .zip, .ppt, .txt'];
	}

	// funcion para validar si el archivo es una imagen
	private function validateImg( $type )
	{
		if( $type == 'image/jpg' or $type == 'image/jpeg' or $type == 'image/png' or $type == 'image/gif' )
			return true;
		return false;
	}

	// funcion para validar si es un archivo permitido
	private function validateFile( $type )
	{
		if( $type == 'application/pdf' or $type == 'application/msword' or $type == 'application/excel' or $type == 'application/vnd.ms-excel' or $type == 'application/x-excel' or $type == 'application/x-msexcel' or $type == 'text/plain' or $type == 'application/x-compressed' or $type == 'application/x-zip-compressed' or $type == 'application/zip' or $type == 'multipart/x-zip' or $type == 'application/mspowerpoint' or $type == 'application/powerpoint' or $type == 'application/vnd.ms-powerpoint' or $type == 'application/x-mspowerpoint' )
			return true;
		return false;
	}

}