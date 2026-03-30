//llamamos la funcion del onclick
const validar_lg=async()=>{
    var user_lg=document.querySelector("#user-l").value;
    var pass_lg=document.querySelector("#pass-l").value;
if(user_lg.trim()==='' || pass_lg.trim()===''){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'ICEL: LLENA TODOS LOS CAMPOS',
        background: 'rgb(89, 0, 255,0.8)',
        color: 'white'
    })

}else{
    //verificar si es correcta la contraseña
    const datos_lg= new FormData();
    datos_lg.append("user-l",user_lg);
    datos_lg.append("pass-l",pass_lg);
    var respuestalg= await fetch("php/funcionlg.php",{
        method:"POST",
        body:datos_lg
    });
    //recojemos los resultados de las consultas en php
var resultado = await respuestalg.json();
//preguntamos si el resultado que arroja php es success o false
if(resultado.success=="false"){
    Swal.fire({
        icon: 'error',
        title: 'ERROR',
        text: resultado.mensaje,
        background: 'rgb(89, 0, 255,0.8)',
        color: 'white'
    })
}else{
    if(resultado.success=='true'){
    
       window.location.href="usuarios.php";
    }

}
  }
}