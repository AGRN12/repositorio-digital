<?php 
//se incluye la verificacion
include("php/verifylg_in.php");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css?322">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?254"></script>
    
</head>
<?php
include("menus/menu_admin.html");
?>
<main>
<body>
<!--creamos la variable para pasar el id de js-->
<script>
    const user_id = "<?php echo $user_id; ?>"; // Pasar el ID de usuario a JavaScript
</script>    
<!--alerta de bienvenida-->
<div class="bsw">

 <img src="iconos/agregar.png" class="agre1" id="ag">

 <script>
document.getElementById("ag").addEventListener("click", agregar);
var btn = document.getElementById("ag");

function agregar() {
    Swal.fire({
        title: 'AGREGAR TAREA',
        html: 
        "<div class='contenedor'>" +
        "<input type='text' id='materia' placeholder='nombre de la materia' class='mt'>" +
        "<input type='text' id='tarea' placeholder='nombre de la tarea' class='ma'>" +
        "<input type='file' id='archivo' class='fl'>" +
        "</div>", 
        background: 'rgb(89, 0, 255,0.8)',
        color: 'white',
        showCancelButton: true,
        confirmButtonText: 'AGREGAR',
        preConfirm: () => {
            const materia = document.getElementById('materia').value;
            const tarea = document.getElementById('tarea').value;
            const archivo = document.getElementById('archivo').files[0];

            if (!materia || !tarea || !archivo) {
                Swal.showValidationMessage('POR FAVOR INGRESA TODOS LOS CAMPOS');
                return false;
            }

            const formData = new FormData();
            formData.append('materia', materia);
            formData.append('tarea', tarea);
            formData.append('archivo', archivo);
            formData.append('user_id', user_id);

            return fetch('php/agregar.php', { // Ajusta la ruta según tu estructura
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.text(); // Cambia a texto para depuración
            })
            .then(responseText => {
                console.log(responseText); // Imprime la respuesta en la consola
                let response;
                try {
                    response = JSON.parse(responseText); // Intenta parsear la respuesta a JSON
                } catch (e) {
                    throw new Error('La respuesta no es un JSON válido: ' + responseText);
                }
                return response;
            })
            .catch(error => {
                Swal.showValidationMessage(`Solicitud fallida: ${error}`);
                return false;
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('¡Enviado!', 'SE AGREGO CORRECTAMENTE', 'success').then(() => {
                location.reload();
            });
        }
    });
}
</script>
   
   <input type="text"  id="buscar" placeholder="BUSCADOR: INGRESA TU BUSQUEDA " name="bsc">


<!--DIV PARA MOSTRA TABLA CON ACTIVIDADES -->
<div id="datos" class="tabla-t">

</div>

</div>

<!--TERMINA EL DIV DE LA TABLA DE DATOS-->

    
    
        </main>

</body>
 <!--este script nos permitirar pasar datos en ajax-->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="javascript/busqueda.js?2322"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="javascript/delete.js?1223"></script>
<script src="javascript/editta.js?2422"></script>

 
</html>