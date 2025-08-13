<?php
    include "../config.php";
    include "../utils.php";

    $db_conexion = connect($db);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['folio'])) {
            $sql = "DELETE FROM clientes WHERE folio = :folio";
            $statement = $db_conexion->prepare($sql);
            bindAllValues($statement, $input);
            $result = $statement->execute();
            if ($result) {
                $postID = $db_conexion->lastInsertId();
                $response = array('status' => 'success', 'message' => 'Cliente insertado exitosamente', 'id' => $postID);
                header("HTTP/1.1 200 OK");
            } else {
                $response = array('status' => 'error', 'message' => 'Error al insertar el cliente');
                header("HTTP/1.1 500 Internal Server Error");
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Datos incompletos en la solicitud');
            header("HTTP/1.1 400 Bad Request");
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header("HTTP/1.1 405 Method Not Allowed");
    }
    header("HTTP/1.1 500 Internal Server Error");
    
    $db_conexion = null;
?>