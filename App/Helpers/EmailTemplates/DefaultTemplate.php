<?php 


class DefaultTemplate
{
	// funcion para crear el contenido de la pagina
	// los parametros son los datos basicos que contendra el mensaje
	public static function template( $nombre, $email, $telefono, $mensaje )
	{
		$body = "
			<html> 
				<body>
					<div style='background: #12C551; color: white; text-align: center; padding: 10px;'>
						<h2>".APP_NAME."</h2>
					</div>
					<div style='background: #efefef; padding: 30px;'>
						<h3>Recibiste un nuevo mensaje desde el formulario de contacto</h3>
						<p>Informacion enviada por el usuario de la web:</p>
						<p><b>nombre:</b> {$nombre}</p>
						<p><b>email:</b> {$email}</p>
						<p><b>telefono:</b> {$telefono}</p>
						<p><b>mensaje:</b></p>
						<p>{$mensaje}</p>
						<h5 style='text-align:center'>
							** No responda a este mensaje, es generado automaticamente por el sistema de la página web **
						</h5>
					</div>
				</body> 
			</html>
			<br />
		";
		return $body; 
	}
}