<?php
include 'index.php';

try {
    $conexion = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_Database);

    if (!$conexion) {
        echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
    } else {

        if (
            isset($_POST['id']) &&
            isset($_POST['chapter'])
        ) {
            $id = $_POST['id'];
            $chapter = $_POST['chapter'];

            // Actualizar el capítulo del usuario
            $sql = "UPDATE `users` SET `chapter` = '" . $chapter . "' WHERE `id` = '" . $id . "';";

            if ($conexion->query($sql) === TRUE) {
                // Seleccionar y devolver los datos actualizados del usuario
                $sql_select = "SELECT * FROM `users` WHERE `id` = '" . $id . "';";
                $resultado = $conexion->query($sql_select);

                if ($resultado->num_rows > 0) {
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

                    echo '{"codigo":208, "mensaje":"¡Capítulo actualizado correctamente!", "respuesta":"'.$texto.'"}';
                } else {
                    echo '{"codigo":401, "mensaje":"Error al obtener los datos actualizados del usuario", "respuesta":""}';
                }
            } else {
                echo '{"codigo":407, "mensaje":"Error al intentar actualizar el capítulo", "respuesta":""}';
            }
        } else {
            echo '{"codigo":408, "mensaje":"Faltan datos para actualizar el capítulo", "respuesta":""}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje":"¡Error de conexión!", "respuesta":""}';
}

include 'footer.php';
?>
