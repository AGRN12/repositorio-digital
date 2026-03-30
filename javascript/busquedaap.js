$(document).ready(function() {
    var mostrarSoloUsuario = false;

    // Verificar si la URL contiene el parámetro de consulta del usuario
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('consulta_usuario')) {
        mostrarSoloUsuario = true;
    }

    // Ejecutar la función buscar_datos al cargar la página para mostrar todos los datos
    buscar_datos();

    // Pasar los valores al archivo PHP para que haga la consulta
    function buscar_datos(consulta) {
        var url = mostrarSoloUsuario ? 'php/consultaap_usuario.php' : 'php/consultaap.php';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            data: {
                consulta: consulta,
                user_id: user_id // Pasar el ID de usuario como parte de los datos
            }
        })
        .done(function(respuesta) {
            console.log(respuesta); // Ver la respuesta completa del servidor
            $("#datos2").html(respuesta);
        })
        .fail(function() {
            console.log("error");
        });
    }

    // Crear la función para ejecutar una consulta dependiendo del dato ingresado en la caja de texto
    $(document).on('keyup', '#buscarap', function() {
        var busqueda = $(this).val();
        if (busqueda != "") {
            buscar_datos(busqueda);
        } else {
            buscar_datos();
        }
    });

    // Evento para mostrar solo los datos del usuario
    $('#ag3').click(function() {
        mostrarSoloUsuario = true;
        buscar_datos();
    });

    // Evento para mostrar todos los datos
    $('#mostrarTodo').click(function() {
        mostrarSoloUsuario = false;
        buscar_datos();

        // Eliminar el parámetro consulta_usuario de la URL y recargar la página
        urlParams.delete('consulta_usuario');
        window.history.replaceState({}, document.title, window.location.pathname + "?" + urlParams.toString());
    });
});
