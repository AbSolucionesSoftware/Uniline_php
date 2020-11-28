<?php  
session_start();
require_once '../Modelos/Conexion.php';
include '../Modelos/Email.php';
include '../Modelos/Archivos.php';

if(isset($_POST['sesion'])){
  if(isset($_SESSION['idusuario'])){
    echo $_SESSION['idusuario'];
  }else{
    echo "";
  }
}

/* if(isset($_POST['agregar-sesion'])){
  $_SESSION['idcurso'] = $_POST['agregar-sesion'];
  echo $_SESSION['idcurso'];
} */


if(isset($_POST['TEmail']) && !empty($_POST['TPass']) && !empty($_POST['TNombre'])){
    $emailClass = new Modelos\Email();

    $email = $_POST['TEmail'];
    $password = $_POST['TPass'];
    $nombre = $_POST['TNombre'];
    $telefono = $_POST['TTelefono'];
    $vkey = $emailClass->setEmail($email);
    $verificado = 1;
    $encriptado = trim(password_hash($password,PASSWORD_DEFAULT));

    $conexion = new Modelos\Conexion();
    $consulta_verificar = "SELECT * FROM usuario WHERE email = ?";
    $datos_verificar = array($_POST['TEmail']);
    $resultado = json_encode($conexion->consultaPreparada($datos_verificar,$consulta_verificar,2,'s', false, null));

    if($resultado != '[]'){
        echo 'Existe';
    }else{
      if(isset($_FILES['Fimagen'])){
        if(strlen($_FILES['Fimagen']['tmp_name']) != 0){
          $archivo = subir_imagen('Fimagen',1);
          if ($archivo == "error al subir"){
              echo "Error";
          } else if ($archivo == "img no valida"){
              echo "imagenNoValida";
          } else {
              $profecion = $_POST['TProfesion']."###";
              $consulta_registro_maestros= "INSERT INTO usuario (nombre,edad,escolaridad,imagen,telefono,email,password,vkey,verificado,tipo,estado,municipio,trabajo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
              $datos_registro_maestro = array($nombre,$_POST['TEdad'],$_POST['TGrado'],$archivo,$telefono,$email,$encriptado,$vkey,$verificado,"Maestro",$_POST['TEstado'],$_POST['TMunicipio'],$profecion);
              $resultado = $conexion->consultaPreparada($datos_registro_maestro,$consulta_registro_maestros,1,'sissssssissss',false,6);
              if($resultado == 1){
                $enviar = $emailClass->enviarEmailConfirmacion($_POST['TNombre']);
                echo $resultado;
              }else{
                echo "errorconsulta";
              }
          }
       }
      }else{
          if(strlen($password) >= 8){
            $consulta_registro = "INSERT INTO usuario (nombre, telefono, email, password, vkey, verificado,tipo) VALUES (?, ?, ?, ?, ?, ?, ?)";
             $datos_registro = array($nombre, $telefono, $email, $encriptado, $vkey, $verificado, 'Estudiante');
             $resultado = $conexion->consultaPreparada($datos_registro,$consulta_registro,1,'sssssis', false, 3);
             if($resultado == 1){
              
              $consulta = "SELECT * FROM usuario WHERE email = ?";
              $datos = array($email);
              $resultado3 = json_encode($conexion->consultaPreparada($datos,$consulta,2,'s', false, null));
              $result = json_decode($resultado3);

              $_SESSION['acceso'] = $email;
              $_SESSION['idusuario'] = $result[0][0];
              $_SESSION['nombre'] = $result[0][1];
              $_SESSION['emailusuario'] = $result[0][6];
              $_SESSION['verificado'] = $result[0][9];
              $_SESSION['tipo'] = $result[0][10];
              $_SESSION['CEO'] = '';
              if($result[0][4] != ""){
                  $_SESSION['imagen_perfil'] = $result[0][4];
              }else{
                  $_SESSION['imagen_perfil'] = "../img/perfil.png";
              }
             echo "user";
             //$enviar = $emailClass->enviarEmailConfirmacion($_POST['TNombre']);
             }else{
              echo 'errorpass';  
             }
          } else{
          echo 'errorminorpass';
         }
         }
      }
}

?>