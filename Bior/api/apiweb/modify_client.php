<?php
include "../config.php";
include "../utils.php";

$db_conexion = connect($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $json_data = file_get_contents("php://input");
    $input = json_decode($json_data, true);
    if (isset($input["folio"])) {
        $folio = $input["folio"];
        $fields_to_update = array();
        foreach ($input as $key => $value) {
            if ($key !== "folio") {
                $fields_to_update[$key] = $value;
            }
        }

        if (!empty($fields_to_update)) {
            $set_clause = implode(', ', array_map(function ($key) {
                return "`$key` = :$key";
            }, array_keys($fields_to_update)));

            $sql = "UPDATE clientes SET $set_clause WHERE folio = :folio";
            $statement = $db_conexion->prepare($sql);
            $statement->bindParam(':folio', $folio, PDO::PARAM_INT);
            foreach ($fields_to_update as $key => $value) {
                $statement->bindParam(":$key", $value);
            }

            $result = $statement->execute();
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Cliente modificado correctamente');
                header("HTTP/1.1 200 OK");
            } else {
                $response = array("status" => "error", "message" => "No se pudo modificar correctamente.");
                header("HTTP/1.1 500 Internal Server Error");
            }
        } else {
            $response = array("status" => "error", "message" => "No hay campos para actualizar en el JSON");
            header("HTTP/1.1 400 Bad Request");
        }
    } else {
        $response = array("status" => "error", "message" => "El folio no está presente en el JSON");
        header("HTTP/1.1 400 Bad Request");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}

$db_conexion = null;
?>
