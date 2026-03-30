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
    <link rel="stylesheet" href="estilos.css?566e6">
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

<h2>APORTACIONES DE ESTUDIANTES</h2>

 <img src="iconos/agregar.png" class="agre1" id="ag2">
<script>
    document.getElementById("ag2").addEventListener("click",agrega);
    var btn = document.getElementByID("ag2");

    function agrega(){
        Swal.fire({
            title: 'AGREGAR APORTACION',
            html:
            "<div class='contenedor'>"+
            "<input type='text' id='pro2' placeholder='nombre del proyecto' class='mt'> "+
            "<input type='file' id='archivo2' class='fl'>" +
            "</div>", 
            background: 'rgb(89, 0, 255,0.8)',
            color: 'white',
            showCancelButton: true,
            confirmButtonText: 'AGREGAR',
            preConfirm:()=>{
            const pro2 = document.getElementById('pro2').value;
            const archivo2 = document.getElementById('archivo2').files[0];

            if (!pro2 || !archivo2) {
                Swal.showValidationMessage('POR FAVOR INGRESA TODOS LOS CAMPOS');
                return false;
            }

            const formData = new FormData();
            formData.append('pro2', pro2);
            formData.append('archivo2', archivo2);
            formData.append('user_id', user_id);

            return fetch('php/agregarpro.php', { // Ajusta la ruta según tu estructura
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
 <input type="text"  id="buscarap" placeholder="BUSCADOR: INGRESA TU BUSQUEDA " name="bsc">
<div id="datos2" class="tabla-t">

</div>
<img src="iconos/mios.png" class="agre3" id="ag3">
<img src="iconos/ojo.png" class="mt2" id="mostrarTodo">
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="javascript/busqueda.js?232"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="javascript/delete.js?1223"></script>
<script src="javascript/editta.js?2422"></script>
<script src="javascript/busquedaap.js?246345"></script>
<script src="javascript/editap.js?23456"></script>
<script src="javascript/deleteap.js?34"></script>
</html>