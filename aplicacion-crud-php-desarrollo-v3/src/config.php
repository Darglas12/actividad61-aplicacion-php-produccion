<?php
/*Define los parámetros de conexión a la base de datos.
Los parámetros básicos de la BD se toma del fichero de variables de entorno: .env. 
Esos parámetros son: nombre o dirección del gestor de BD MariaDB, nombre de la BD, usuario de la BD y su contraseña. 
Se guardan respectivamente en las siguientes constantes: DB_HOST, DB_NAME, DB_USER y DB_PASSWORD. Por lo tanto:

DB_HOST: nombre o dirección del gestor de BD, en nuestro caso MariaDB
DB_NAME: Nombre de la BD
DB_USER: Usuario de la BD
DB_PASSWORD: Contraseña del usuario e la BD

*/

/*¿Cómo se obtiene el valor de una variable de entorno en PHP?
A través de la función: gentenv*/
define('DB_HOST', getenv('MARIADB_HOST'));
define('DB_NAME', getenv('MARIADB_DATABASE'));
define('DB_USER', getenv('MARIADB_USER'));
define('DB_PASSWORD', getenv('MARIADB_PASSWORD'));

/*
Otra alternativa es definir directamente los parámetros de conexión en vez de copiarlos de las variables de entorno:
define('DB_HOST', 'mariadb');
define('DB_PORT', '3307');
define('DB_NAME', 'electroshop');
define('DB_USER', 'usuario');
define('DB_PASSWORD', 'usuario@1');
*/


//Abre una nueva conexión al servidor MySQL/MariaDB
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//$mysqli = new mysqli('mariadb', 'usuario', 'usuario1', 'electroshop');
//Devuelve una descripción del último error producido en la conexión a la BD
if ($mysqli->connect_error) {
    printf('Falló la conexión: %s\n', mysqli_connect_error());
    exit();
}
?>
