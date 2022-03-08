<?php 


class RecoverpasswordTemplate
{
	// funcion para crear el contenido de la pagina
	// los parametros son los datos basicos que contendra el mensaje
	public static function template( $nombre, $password )
	{
		$body = "
			<html> 
				<body>
					<div style='background: #12C551; color: white; text-align: center; padding: 10px;'>
						<h2>".APP_NAME."</h2>
					</div>
					<div style='background: #efefef; padding: 30px;'>
						<h4>¡Hola ".ucwords($nombre)."!, hemos recibido una solicitud de actualización de contraseña.</h3>
						<h4>Nueva contraseña: ".$password."</h4>
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