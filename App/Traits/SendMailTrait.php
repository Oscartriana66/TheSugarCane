<?php 


////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                    //
// Para usar este trait se importa de igual manera que cualquier otro trait                           //
// Para hacer uno de las plantillas debe importarlas de la siguiente manera                           //
// ejemplo con la plantilla por defecto:                                                              //
// require_once RUTA_APP."/Traits/SendMailTrait.php";                                                 //
// require_once RUTA_APP."/Helpers/EmailTemplates/DefaultTemplate.php";                               //
// $template = DefaultTemplate::template( $nombre, $email, $telefono, $asunto, $mensaje );            //
// $sendEmail = SendMailTrait::send( $email, $nombre, $template, $mensaje, $address_mail, $subject ); //
//                                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

// requerimos los archivos de la libreria base
require_once APP."/Helpers/SMTP-PHPMailer/class.phpmailer.php";
require_once APP."/Helpers/SMTP-PHPMailer/class.smtp.php";

class SendMailTrait
{
	// funcion para enviar correos electronicos
	// $email: variable que contiene el correo electronico desde donde se envio
	// $nombre: nombre de la persona quein lo envio
	// $template: contiene el cuerpo con diseño html del correo electronico
	// // la template se importa desde la carpeta de helpers/emailtemplates, revisar la plantilla por defatul
	// $mensaje: contiene el mensaje que envio el usuario por si hay algun error con el $template
	// $address_mail: direccion de correo a quien sera enviado, por defecto contiene el de la variable global de config.php SMTP['SENT_BY']
	// $subject: contiene el asunto que se enviara al correo electronico, por defecto contiene "Formulario enviado desde el Sitio Web"
	// return: devuelve true si se envia y false si no se envia
	public static function send( $email, $nombre, $template, $mensaje, $address_mail = SMTP['SENT_BY'], $subject = "Formulario enviado desde el Sitio Web" )
	{
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Port = 587; 
		$mail->IsHTML(true); 
		$mail->CharSet = "utf-8";

		// VALORES A MODIFICAR //
		$mail->Host = SMTP['HOST'];
		$mail->Username = SMTP['USER'];
		$mail->Password = SMTP['PASSWORD'];

		// Email desde donde envío el correo.
		$mail->From = $email;
		// Nombre desde donde envío el correo.
		$mail->FromName = $nombre;
		// Esta es la dirección a donde enviamos los datos del formulario
		$mail->AddAddress( $address_mail ); 
		// Asunto del correo
		$mail->Subject = $subject;
		$mensajeHtml = nl2br($mensaje);

		// Texto del email en formato HTML
		$mail->Body = $template;
		
		// Texto sin formato HTML
		$mail->AltBody = "{$mensaje} \n\n ";
		// FIN - VALORES A MODIFICAR //

		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$estadoEnvio = $mail->Send();
		
		if( $estadoEnvio ){
		    return true;
		} else {
		    return false;
		}
	}
}