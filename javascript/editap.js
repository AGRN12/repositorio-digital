function editarap(proyecto, id_ar, id_usuario) {
    var proyecto = proyecto;
    var id_usuarioe = id_usuario;
    var idarchivoe = id_ar;
    
    Swal.fire({
        title: "EDITAR PROYECTO",
        html:
            "<div class='contenedor'>" +
            "<input type='text' id='proyecto' class='mt' value='" + proyecto + "'>" +
            "<input type='file' id='archivo' class='fl'>" +
            "<input type='hidden' id='id_archivo' value='" + idarchivoe + "'>" +
            "</div>",
        background: 'rgb(89, 0, 255,0.8)',
        color: 'white',
        showCancelButton: true,
        confirmButtonText: 'CAMBIAR',
        preConfirm: () => {
            const proyecto = document.getElementById('proyecto').value;
            const archivo = document.getElementById('archivo').files[0];

            if (!proyecto) {
                Swal.showValidationMessage('POR FAVOR LOS CAMPOS DE TEXTO NO DEBEN ESTAR VACIOS');
                return false;
            }

            const formData = new FormData();
            formData.append('proyecto', proyecto);
            if (archivo) { // Solo agregar si hay un archivo seleccionado
                formData.append('archivo', archivo);
            }
            formData.append('id_usuarioe', id_usuarioe);
            formData.append('idarchivoe', idarchivoe);

            return fetch('php/editap.php', { // Ajusta la ruta según tu estructura
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
            Swal.fire('¡Enviado!', 'SE MODIFICO CORRECTAMENTE', 'success').then(() => {
                // Redirigir a la misma página con el modo de consulta del usuario activado
                window.location.href = window.location.href.split('?')[0] + "?consulta_usuario=true";
            });
        }
    });
}
