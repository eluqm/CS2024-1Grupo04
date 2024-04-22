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


			$sql = "SELECT * FROM `users` WHERE player_name='".$player_name."';";

			$resultado = $conexion->query($sql);

			if ($resultado->num_rows > 0){
				echo '{"codigo":404, "mensaje":"Ya existe un usuario registrado con ese nombre", "respuesta":"'.$resultado->num_rows.'"}';
			}else{

				$sql = "INSERT INTO `users` (`id`, `player_name`, `password`, `player`, `score`) VALUES (NULL, '".$player_name."', '".$password."', '".$player."', '".$score."');";

				if ($conexion->query($sql) === TRUE){
					$sql = "SELECT * FROM `users` WHERE player_name='".$player_name."';";
					$resultado = $conexion->query($sql);
					$texto = '';
					while ($row = $resultado->fetch_assoc()){
						$texto = 
						"{
						#id#:".$row['id'].", 
						#player_name#:#".$row['player_name']."#, 
						#password#:#".$row['password']."#,
						#player#: ".$row['player'].", 
						#score#: ".$row['score'].
						"}";
					}

					echo '{"codigo":201, "mensaje":"¡Usuario creado correctamente!", "respuesta":"'.$texto.'"}';
				}else{
					echo '{"codigo":401, "mensaje":"Error al intentar crear el usuario", "respuesta":""}';
				}	
			}
				
		}else{
			echo '{"codigo":402, "mensaje":"Faltan datos para crear el usuario", "respuesta":""}';

		}


	}
} catch (Exception $e) {
	echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';	
}

include 'footer.php';
