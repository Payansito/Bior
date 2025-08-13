ListarProductos();
function ListarProductos(busqueda){
    fetch("listar.php",{
        method: "POST",
        body: busqueda    
    }).then(response => response.text()).then(response => {
        resultado.innerHTML = response;

    })
    .catch(error => {
        console.error('Error en ListarProductos:', error);
    });
}

document.getElementById('registrar').addEventListener('click', function() {
    console.log('Click en el botón registrar');

    // Obtén los datos del formulario
    var formData = new FormData(frm);
    console.log("Datos enviados:", formData);

    // Realiza la solicitud fetch
    fetch("registrar.php", {
        method: "POST",
        body: new FormData(frm)
    }).then(response => response.json()).then(response => {
        console.log('Server response:', response);
        
        // Verifica si el array contiene la clave "ok"
        if (response.hasOwnProperty("ok")) {
            ListarProductos();
            Swal.fire({
                icon: "success",
                title: "El cliente fue añadido",
                showConfirmButton: false,
                timer: 2500
            });
            frm.reset();
        } else {
            console.log('Error en la respuesta del servidor');
            console.log('Contenido de la respuesta (error):', response);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Los datos ingresados no fueron correctos"
            });
            ListarProductos();
        frm.reset();
        }
    }).catch(error => {
        Swal.fire({
            icon: "success",
            title: "Cliente modificado",
        });
        registrar.value = "Registrar";
        idp.value="";
        ListarProductos();
        frm.reset();
    });
});

function Eliminar(key){
    Swal.fire({
        title: "¿Estas seguro de eliminar el cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "NO"
      }).then((result) => {
        if (result.isConfirmed) {
            fetch("eliminar.php", {
                method: "POST",
                body: key
            }).then(response => response.text()).then(response =>{
                if(response == "ok"){
                    ListarProductos();
                    Swal.fire({
                        icon: "success",
                        title: "El cliente fue eliminado",
                        showConfirmButton: false,
                        timer: 2500
                      });
                }
                
            })  
        }
      });
}

function Editar(key){
    fetch("editar.php", {
        method: "POST",
        body: key
    }).then(response => response.json()).then(response =>{
        idp.value = response.key;
        folio.value = response.folio;
        cliente.value = response.Nombre;
        precio.value = response.precio;
        ubicacion.value = response.ubicacion;
        rutas.value = response.rutas;
        registrar.value = "Actualizar"
    })
}

buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    if (valor == "") {
        ListarProductos();
    }else{
        ListarProductos(valor);
    }
});

