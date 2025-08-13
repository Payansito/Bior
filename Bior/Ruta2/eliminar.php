<?php
    $data = file_get_contents("php://input");
    require "../conexion.php";
    $query = $pdo->prepare("DELETE FROM clientes WHERE `key` = :id");
    $query->bindParam(":id", $data);
    $query->execute();
    echo "ok";
?>