# blue_ghost 2.0

Realiza la configuración para entorno local de la siguiente manera:

1. Copia la carpeta raiz del proyecto en xampp/htdocs/
2. Inicia el xampp e ingresa al localhost en su navegador web
3. Ubique la carpeta del proyecto en el listado proveido por xampp
4. Copie la URL del navegador que contiene el localhost/nombre-proyecto
5. Ve a la carpeta ubicada en xampp/htdocs e ingresa a la carpeta App/Library y ubica el archivo Config.php
6. En la linea 24 pegue la URL del localhost previamente copiado
7. Para cambiar los datos de conexión al servidor de base de datos verifique:
7.1 Linea 28 que se encuentre en 'on'
7.2 Linea 30 servidor de bases de datos: Normalmente es localhost
7.3 Linea 32 Ingrese el usuario del servidor de base de datos
7.4 Linea 34 Ingrese la pass del servidor de base de datos
7.5 Linea 36 Ingrese el nombre de la base de datos a usar

Con estos cambios debe funcionar correctamente el servicio.