<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

include "config.php";
include "utils.php";

$db_conexion = connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $sql = $db_conexion->prepare("SELECT nombre, precio FROM clientes WHERE id_cliente = :id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        http_response_code(200);
        echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
        exit();
    } else {
        $sql = $db_conexion->prepare("SELECT nombre, precio FROM clientes");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode($sql->fetchAll());
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $fecha = date("Y-m-d", strtotime($input['fecha']));
    $sql = "INSERT INTO bior (fecha, cantidad, folio, cliente, precio, locacion) 
            VALUES (:fecha, :cantidad, :folio, :cliente, :precio, :locacion)";
    $statement = $db_conexion->prepare($sql);
    $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    bindAllValues($statement, $input);
    $result = $statement->execute();
    if ($result) {
        $postID = $db_conexion->lastInsertId();
        $input['id'] = $postID;
        http_response_code(200);
        echo json_encode($input);
        exit();
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al insertar datos en la base de datos"]);
        exit();
    }
}

http_response_code(400);
echo json_encode(["error" => "Bad Request"]);
