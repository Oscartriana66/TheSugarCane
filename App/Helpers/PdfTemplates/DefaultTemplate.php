<?php 


class DefaultTemplate
{
	// funcion para crear el contenido de la pagina
	// los parametros son los datos basicos que contendra el mensaje
	public static function template()
	{
		$body = "
			<html> 
				<body style='background: #efefef;'>
					<div style='background: rgb(27, 176, 224); color: white; text-align: center; padding: 10px;'>
						<h2>".APP_NAME."</h2>
					</div>
					<div style='padding: 30px;'>
						<h3 style='text-align:center'>Ejemplo de pdf</h3>
						<p>Este es un ejemplo de una plantilla para generar pdf's.</p>
					</div>
				</body> 
			</html>
			<br />
		";
		return $body; 
	}
}