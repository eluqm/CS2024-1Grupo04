<?php

$servidor	= 'localhost';
$Database 	= 'stryker_database';
$usuario	= 'root';
$pass		= '';
try {
	$conexion	= mysqli_connect($servidor, $usuario, $pass, $Database);

	if (!$conexion)	{
		echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
	} else{
		echo '{"codigo":200, "mensaje":"¡Conexión realizada correctamente!", "respuesta":""}';
	}
} catch (Exception $e) {
	echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';	
}


