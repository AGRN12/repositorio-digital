function editar(materia,titulo,id_usuario,id_archivo){
    var materiae = materia;
    var tituloe = titulo;
    var id_usuarioe = id_usuario;
    var idarchivoe = id_archivo;
    Swal.fire({
        title: "EDITAR TAREA",
        html:
        "<div class='contenedor'>"+
        "<input type='text' id='materia' class='mt' value='"+materiae+"'>" +
        "<input type='text' id='tarea' class='ma' value='"+tituloe+"'>" +
        "<input type='file' id='archivo' class='fl'>" +
        "<input type='hidden' id='id_archivo' value='"+idarchivoe+"'>"+
        "</div>", 
        background: 'rgb(89, 0, 255,0.8)',
        color: 'white',
        showCancelButton: true,
        confirmButtonText: 'CAMBIAR',
        preConfirm:() =>{
            const materia = document.getElementById('materia').value;
            const tarea = document.getElementById('tarea').value;
            const archivo = document.getElementById('archivo').files[0];
        
            if(!materia || !tarea){
                Swal.showValidationMessage('POR FAVOR LOS CAMPOS DE TEXTO NO DEBEN ESTAR VACIOS');
                return false;
            }
            const formData = new FormData();
            formData.append('materia',materia);
            formData.append('tarea',tarea);
            formData.append('archivo',archivo);
            formData.append('id_usuarioe',id_usuarioe);
            formData.append('idarchivoe',idarchivoe);

            return fetch('php/edit.php', { // Ajusta la ruta según tu estructura
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
            Swal.fire('¡Enviado!', 'SE MODIFICO CORRECTAMENTE CORRECTAMENTE', 'success').then(() => {
                location.reload();
            });

        }
    }) 
}