<?php
include 'index.php';

try {
	$conexion	= mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

	if (!$conexion)	{
		echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
	} else{

		if (isset($_GET['player_name']) && isset($_GET['password'])) {

			$player_name 	= $_GET['player_name'];
			$password 		= $_GET['password'];

			$sql = "SELECT * FROM `users` WHERE player_name='".$player_name."' and password='".$password."';";

			$resultado = $conexion->query($sql);

			if ($resultado->num_rows > 0){
				# Sí existe un usuario con esos datos
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

				echo '{"codigo":205, "mensaje":"Inicio de sesión exitoso", "respuesta":"'.$texto.'"}';

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