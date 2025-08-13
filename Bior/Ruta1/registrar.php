<?php
header('Content-Type: application/json');

try {
    if (isset($_POST['folio'], $_POST['cliente'], $_POST['precio'], $_POST['ubicacion'])) {
        $folio = $_POST['folio'];
        $nombre = $_POST['cliente'];
        $precio = $_POST['precio'];
        $ubicacion = $_POST['ubicacion'];

        require("../conexion.php");

        if (empty($_POST['idp'])) {
            
            $query = $pdo->prepare("INSERT INTO clientes (`key`, folio, Nombre, precio, ubicacion, rutas) VALUES (NULL, :fol, :cli, :pre, :ubi, '1')");
            $query->bindParam(":fol", $folio);
            $query->bindParam(":cli", $nombre);
            $query->bindParam(":pre", $precio);
            $query->bindParam(":ubi", $ubicacion);
            $query->execute(); 
            $pdo = null;
    
            echo json_encode(["ok" => true]);
        }else{
            $key = $_POST['idp'];
            $query = $pdo->prepare("UPDATE clientes SET folio = :fol, Nombre = :cli, precio = :pre, ubicacion = :ubi WHERE `key` = :id");
            $query->bindParam(":fol", $folio);
            $query->bindParam(":cli", $nombre);
            $query->bindParam(":pre", $precio);
            $query->bindParam(":ubi", $ubicacion);
            $query->bindParam(":id", $key);
            $query->execute(); 
            $pdo = null;
            echo "modificado";
    
            echo json_encode(["modificado" => true]);
        }


    } else {
        echo json_encode(["error" => "Datos incompletos en el formulario."]);  // Solo envía la respuesta como JSON
    }

} catch (PDOException $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);  // Solo envía la respuesta como JSON
}
?>
