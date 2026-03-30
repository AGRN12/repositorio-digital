<?php 
include("conexion.php");
session_start();
$valido_lg['success']=array('success' => false , 'mensaje'=> '');
if($_POST){
    $user_lg = $_POST['user-l'];
    $pass_lg = $_POST['pass-l'];
   /*preguntar si existe el usuarios */
    $sql2="SELECT * FROM usuarios WHERE usuario = '$user_lg'";
    $resultados1 = mysqli_query($conexion,$sql2);
    $num2 = $resultados1->num_rows;
  
    if($num2 == 1){
        $sql4="SELECT id, usuario, pass From usuarios WHERE usuario='$user_lg'";
        $resultado=mysqli_query($conexion,$sql4);
        if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $user_id = $fila['id'];  // Obtener el ID del usuario
    $hash = $fila['pass'];
    $users = $fila['usuario'];
        }
        /* verificae si su contraseña es correcta  */
        if(password_verify($pass_lg,$hash)){
                $_SESSION['user_id'] = $user_id;
                $_SESSION['usuario']=$user_lg;
                $valido_lg['success']='true';
                $valido_lg['mensaje']='user';

        }else{
            $valido_lg['success']='false';
            $valido_lg['mensaje']='LA CONTRASEÑA O USUARIO SON INCORRECTOS';
        }
}else{
    $valido_lg['success']='false';
    $valido_lg['mensaje']='EL USUARIO NO ESTA REGISTRADO';
}
}
echo json_encode($valido_lg);
?>