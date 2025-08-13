<?php
header('Content-Type: application/json');
try {
    require "conexion.php";
    $data = isset($_POST['buscar']) ? $_POST['buscar'] : '';

    if ($data == "") {
        $consulta = $pdo->prepare("SELECT * FROM clientes ORDER BY id_cliente DESC");
    }

    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1' id='tableinfo'>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Precio</th>
                <th>Ubicación</th>
                <th>Ruta</th>
                <th>Acciones</th>
            </tr>";

    foreach ($resultado as $data) {
        echo "<tr> 
            <td>" . (isset($data['folio']) ? $data['folio'] : '') . "</td>
            <td>" . (isset($data['Nombre']) ? $data['Nombre'] : '') . "</td>
            <td>" . (isset($data['precio']) ? $data['precio'] : '') . "</td>
            <td>" . (isset($data['ubicacion']) ? $data['ubicacion'] : '') . "</td>
            <td>" . (isset($data['rutas']) ? $data['rutas'] : '') . "</td>
            <td>
                <button type='button' class='btn btn-success' onclick=Editar('" . $data['id_cliente'] . "')>Editar</button> 
                <button type='button' class='btn btn-danger' onclick=Eliminar('" . $data['id_cliente'] . "')>Eliminar</button> 
            </td>
        </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en el servidor: " . $e->getMessage()]);
}
?>
<script src="home.js"></script>