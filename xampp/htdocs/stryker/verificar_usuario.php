<?php
include 'index.php';

try {
	$conexion	= mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

	if (!$conexion)	{
		echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
	} else{

		if (isset($_GET['player_name'])) {

			$player_name 	= $_GET['player_name'];

			$sql = "SELECT * FROM `users` WHERE player_name='".$player_name."';";

			$resultado = $conexion->query($sql);

			if ($resultado->num_rows > 0){
				echo '{"codigo":202, "mensaje":"El usuario existe en el sistema", "respuesta":"'.$resultado->num_rows.'"}';
			}else{
				echo '{"codigo":203, "mensaje":"El usuario no existe en el sistema", "respuesta":"0"}';
			}	
				
		}else{
			echo '{"codigo":403, "mensaje":"Faltan datos para ejecutar la acción solicitada", "respuesta":""}';

		}


	}
} catch (Exception $e) {
	echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';	
}

include 'footer.php';
