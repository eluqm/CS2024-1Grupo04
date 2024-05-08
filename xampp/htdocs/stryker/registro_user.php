<?php
include 'index.php';

try {
    $conexion = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

    if (!$conexion) {
        echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
    } else {

        if (
            isset($_POST['player_name']) &&
            isset($_POST['password'])
        ) {
            $player_name = $_POST['player_name'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM `users` WHERE player_name='" . $player_name . "';";

            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                echo '{"codigo":404, "mensaje":"Ya existe un usuario registrado con ese nombre", "respuesta":"' . $resultado->num_rows . '"}';
            } else {
                // Obtener el número total de registros para generar el ID del jugador
                $sql_count = "SELECT COUNT(*) as total FROM `users`";
                $resultado_count = $conexion->query($sql_count);
                $total_registros = $resultado_count->fetch_assoc()['total'];

                // Incrementar el ID del jugador en 1
                $player = $total_registros + 1;

                // Valor inicial del puntaje
                $score = 0;

                $sql = "INSERT INTO `users` (`id`, `player_name`, `password`, `player`, `score`) VALUES (NULL, '" . $player_name . "', '" . $password . "', '" . $player . "', '" . $score . "');";

                if ($conexion->query($sql) === TRUE) {
                    $sql = "SELECT * FROM `users` WHERE player_name='" . $player_name . "';";
                    $resultado = $conexion->query($sql);
                    $texto = '';
                    while ($row = $resultado->fetch_assoc()) {
						$texto = 
						"{#id#:".$row['id'].
						",#player_name#:#".$row['player_name'].
						"#,#password#:#".$row['password'].
						"#,#player#:".$row['player'].
						",#score#:".$row['score'].
						",#chapter#:".$row['chapter'].
						"}";
					}

                    echo '{"codigo":201, "mensaje":"¡Usuario creado correctamente!", "respuesta":"' . $texto . '"}';
                } else {
                    echo '{"codigo":401, "mensaje":"Error al intentar crear el usuario", "respuesta":""}';
                }
            }
        } else {
            echo '{"codigo":402, "mensaje":"Faltan datos para crear el usuario", "respuesta":""}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
}

include 'footer.php';
