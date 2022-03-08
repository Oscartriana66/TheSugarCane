<?php 

// requerimos el autoload del sistema
require_once '../App/autoload.php';
// instanciamos el autocargador del sistema
$kernel = new Autoload;
// inicializamos el sistema a través del kernel
// para forzar certificado ssl debe agregar al run del kernel un paramtro en ssl (por defecto se encuentra en without_ssl) de la siguiente manera: $kernel->run( 'ssl' );
$kernel->run();