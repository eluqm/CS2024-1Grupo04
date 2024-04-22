<?php
include 'index.php';

try {
	$conexion	= mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

	if (!$conexion)	{
		echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
	} else{

		if (isset($_GET['player_name']) &&
			isset($_GET['password']) &&
			isset($_GET['player']) &&
			isset($_GET['score'])) {

			$player_name 	= $_GET['player_name'];
			$password		= $_GET['password'];
			$player			= $_GET['player'];
			$score			= $_GET['score'];

			$sql = "INSERT INTO `users` (`id`, `player_name`, `password`, `player`, `score`) VALUES (NULL, '".$player_name."', '".$password."', '".$player."', '".$score."');";

			if ($conexion->query($sql) === TRUE){
				echo '{"codigo":201, "mensaje":"Usuario creado correctamente!", "respuesta":""}';
			}else{
				echo '{"codigo":401, "mensaje":"Error al intentar crear el usuario", "respuesta":""}';
			}	
				
		}else{
			echo '{"codigo":402, "mensaje":"Faltan datos para crear el usuario", "respuesta":""}';

		}


	}
} catch (Exception $e) {
	echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';	
}

include 'footer.php';
