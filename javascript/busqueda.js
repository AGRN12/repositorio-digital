$(document).ready(function(){
    // Asegúrate de que user_id está definido
    console.log(user_id); // Verificar que user_id tiene un valor

    // Ejecutar la función buscar_datos al cargar la página
    buscar_datos();

    // Pasar los valores al archivo PHP para que haga la consulta
    function buscar_datos(consulta) {
        $.ajax({
            url: 'php/consultac.php',
            type: 'POST',
            dataType: 'html',
            data: {
                consulta: consulta,
                user_id: user_id // Pasar el ID de usuario como parte de los datos
            }
        })
        // Esta parte se ejecutará si la consulta se realiza con éxito
        .done(function(respuesta) {
            console.log(respuesta); // Ver la respuesta completa del servidor
            $("#datos").html(respuesta);
        })
        // Este es el caso contrario si no se puede hacer la consulta
        .fail(function() {
            console.log("error");
        });
    }

    // Crear la función para ejecutar una consulta dependiendo del dato ingresado en la caja de texto
    $(document).on('keyup', '#buscar', function() {
        // Declarar variable de la caja de texto para ver qué valor tiene
        var busqueda = $(this).val();
        // Preguntar si la caja de texto no está vacía para hacer la consulta
        if (busqueda != "") {
            buscar_datos(busqueda);
        // En caso contrario, si la caja de texto está vacía, mostrar todos los datos
        } else {
            buscar_datos();
        }
    });
});
