<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bior</title>
    <link rel="stylesheet" href="style.css?v=1.6"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>
<body class="authenticated">
 <div id="mainContent">
 <div class="sidebar">
     <div class="logo"></div>
     <ul class="menu">
     <li class="activ">
            <a href="../index.php" >
                <i><ion-icon name="home"></ion-icon></i>
                <span>Home</span>
            </a>
        </li>
        <li class="activ">
            <a href="../Ruta1/index.php" >
                <i><ion-icon name="car"></ion-icon></i>
                <span>Ruta1</span>
            </a>
        </li>
        <li class="active">
            <a href="#" >
                <i><ion-icon name="car"></ion-icon></i>
                <span>Ruta2</span>
            </a>
        </li>
        <li class="activ">
            <a href="../RutaRMP/index.php" >
                <i><ion-icon name="car"></ion-icon></i>
                <span>RutaRMP</span>
            </a>
        </li>
     </ul>
    </div>
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <img src="../Assets/bior.png" id="Logo" alt="">
            </div>
            <div class="user--info">

            </div>
        </div>


            <div class="tabular--wrapper">
                <h3 class="main--title"> Procesos completados </h3>
                <div class="table--container">
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cantidad de aceite por litro</th>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Precio por litro</th>
                                <th>Ubicación</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Conexión a la base de datos
                                $host = "localhost";
                                $usuario = "root";
                                $contrasena = "";
                                $base_de_datos = "BIOR";
                                $conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);
                                if ($conexion->connect_error) {
                                    die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
                                }
                            
                                 // Realizar la consulta a la base de datos
                                $consulta = "SELECT * FROM rutas_completadas WHERE rutas = '2'";
                                $resultado = $conexion->query($consulta);
                                                        
                                // Mostrar los datos en filas de la tabla HTML
                                if ($resultado->num_rows > 0) {
                                    while($fila = $resultado->fetch_assoc()) {

                                        $fechaOriginal = $fila["Fecha"];

                                        // Convierte la fecha al formato deseado "día mes año"
                                        $fechaFormateada = date("d/m/Y", strtotime($fechaOriginal));

                                        echo "<tr>";
                                        
                                        // Mostrar los datos en la tabla
                                        echo "<td>" . $fechaFormateada . "</td>";
                                        echo "<td>" . $fila["Cantidad"] . "</td>";
                                        echo "<td>" . $fila["Folio"] . "</td>";
                                        echo "<td>" . $fila["Cliente"] . "</td>";
                                        echo "<td>" . $fila["Precio"] . "</td>";
                                        echo "<td><a target = '_blank' href = 'https://maps.google.com/?q=" . $fila["Locacion"] ."'>" . $fila["Locacion"] . "</a></td>";
                                    
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No se encontraron resultados en la base de datos.</td></tr>";
                                }
                            
                                // Cerrar la conexión
                                $conexion->close();
                                ?>
                            </tbody>
                    </table>
                </div>
            </div>

    <div id="tabular--wrapper2">
        <h3 class="main--title"> Modificacion de clientes </h3>
        <div id="table--container2">
            <div class="container">
                <div class="row" id="cuadro">
                    <div class="col-lg-4 mb-5 mb-lg-0 mt-4 " id="anadircliente">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class= "text-center" id="titleclientes">Registro de clientes</h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" id="frm">
                                    <div class="form-group">
                                        <label for="folio">Folio</label>
                                        <input type="hidden" name = "idp" id = "idp" value = "">
                                        <input type="text" name="folio" id="folio" placeholder="Numero de Folio" class= "form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cliente">Cliente</label>
                                        <input type="text" name="cliente" id="cliente" placeholder="Nombre del Cliente" class= "form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="precio">Precio</label>
                                        <input type="text" name="precio" id="precio" placeholder="Precio por litro" class= "form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ubicacion">Ubicacion</label>
                                        <input type="text" name="ubicacion" id="ubicacion" placeholder="Ubicación" class= "form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="button" value="Registrar" id = "registrar" class="btn btn-primary btn-block">
                                    </div>
                                </form>

                                
                            </div>
                        </div>
                    </div>
                <div class="col-lg-8" id="verclientes">
                    <div class="row">
                        <div class="col-lg-6 ml-auto">
                            <form action="" method = "post">
                                <div class="form-group">
                                    <input type="text" name = "buscar" id= "buscar" placeholder = "Buscar..." class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="table-container" >
                        <div id="table-wrapper">
                                <table class="table" id="tablacliente">
                                    <thead class="thead-dark">
                                        <tr>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="resultado">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                </div> 
            </div>

        </div>
    </div>
  </div>

   
     
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>