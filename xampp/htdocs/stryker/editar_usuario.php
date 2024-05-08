<?php
include 'index.php';

try {
	$conexion	= mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

	if (!$conexion)	{
		echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
	} else{

		if (isset($_POST['player_name']) &&
			isset($_POST['password']) &&
			isset($_POST['password2']) &&
			isset($_POST['player']) &&
			isset($_POST['score'])) {

			$player_name 	= $_POST['player_name'];
			$password		= $_POST['password'];
			$password2		= $_POST['password2'];
			$player			= $_POST['player'];
			$score			= $_POST['score'];

			$sql = "SELECT * FROM `users` WHERE player_name='".$player_name."' and password='".$password."';";
			$resultado = $conexion->query($sql);

			if ($resultado->num_rows > 0){
				# Sí existe un usuario con esos datos
				$sql = "UPDATE `users` SET `password` = '".$password2."', `player` = '".$player."', `score` = '".$score."' WHERE player_name='".$player_name."';";
				$conexion->query($sql);

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

				echo '{"codigo":206, "mensaje":"Usuario editado con exito", "respuesta":"'.$texto.'"}';

			}else{
				# No existe un usuario con esos datos
				echo '{"codigo":204, "mensaje":"El usuario o la contraseña son incorrectos", "respuesta":""}';
			}	
				
		}else{
			echo '{"codigo":403, "mensaje":"Faltan datos para ejecutar la acción solicitada", "respuesta":""}';

		}


	}
} catch (Exception $e) {
	echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';	
}

include 'footer.php';