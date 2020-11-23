<?php 
require_once '../Modelos/Archivos.php';
require_once '../Modelos/Conexion.php';

session_start();

//traer datos de la base
if(isset($_POST['datos'])){
    $id = $_SESSION['idusuario'];
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT * FROM usuario WHERE idusuario = ?";
    $datos = array($id);
    $resultado = json_encode($conexion->consultaPreparada($datos,$consulta,2,'i', false, null));
    echo $resultado;
}

if(isset($_POST['updatePass'])){
    $password = $_POST['updatePass'];
    $conexion = new Modelos\Conexion();
    $consulta = "SELECT password FROM usuario WHERE idusuario = ?";
    $datos = array($_SESSION['idusuario']);
    $resultado = $conexion->consultaPreparada($datos,$consulta,2,'s',false,null);
      if(password_verify($password,$resultado[0][0])){
        echo "true";
    }else{
        echo "";
    }  
    
}
 //actualizar datos de la base

 if(isset($_POST['TNombre']) && isset($_POST['TTelefono']) 
 && isset($_POST['TEmail']) && isset($_POST['TEdad'])) {
    
    function actualizar($archivo){
        $conexion = new Modelos\Conexion();
        if(isset($_POST['TPassNew'])){
            $password = $_POST['TPassNew'];
            $encriptado = trim(password_hash($password, PASSWORD_DEFAULT));
        }else{
            $consulta = "SELECT password FROM usuario WHERE idusuario = ?";
            $datos = array($_SESSION['idusuario']);
            $resultado = $conexion->consultaPreparada($datos,$consulta,2,'i', false, null);
            $encriptado = $resultado[0][0];
        }
        $trabajo = null;
        if($_POST['TPuesto'] != "" || $_POST['TDescripcion'] != ""){
            $trabajo = $_POST['TPuesto'].'###'.$_POST['TDescripcion'];
        }
        $consultaUP = "UPDATE usuario SET nombre = ?, edad = ?, escolaridad = ?, telefono = ?, email = ?, password = ?, imagen = ?, estado = ?, municipio = ?, trabajo = ? WHERE idusuario = ?";
        $datos = array($_POST['TNombre'],$_POST['TEdad'],$_POST['TGrado'], $_POST['TTelefono'], $_POST['TEmail'],
        $encriptado,$archivo,$_POST['TEstado'],$_POST['TMunicipio'],$trabajo,$_SESSION['idusuario']);

        $resultado = $conexion->consultaPreparada($datos,$consultaUP,1,'sssssssssss',false,5);
        if($resultado != 0){
            if($archivo == ""){
                $_SESSION['imagen_perfil'] = "../img/perfil.png";
            }else{
                $_SESSION['imagen_perfil'] = $archivo;
            }
        }
        return $resultado; 
    }

    $encriptado = "";
    $archivo = $_SESSION['imagen_perfil'];
    if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
        $archivo = subir_imagen('Fimagen');
        if ($archivo == "error al subir"){
            echo "ErrorImagen";
        } else if ($archivo == "img no valida"){
            echo "imagenNoValida";
        } else {
            if($_SESSION['imagen_perfil'] != "../img/perfil.png"){
                $exlpode = explode("/",$_SESSION['imagen_perfil']);
                $url_1 = "../".$exlpode[1]."/min_".$exlpode[2];
                $url_2 = "../".$exlpode[1]."/res_".$exlpode[2];
                unlink($url_1);
                unlink($url_2);
            }
            if(actualizar($archivo) == 1){
                echo 1;
            }else{
                echo actualizar($archivo);
            }
        }
    }else{
        $conexion = new Modelos\Conexion();
        $consulta = "SELECT imagen FROM usuario WHERE idusuario = ?";
        $datos = array($_SESSION['idusuario']);
        $resultado = $conexion->consultaPreparada($datos,$consulta,2,'i', false, null);
        $imagen = $resultado[0][0];
        echo actualizar($imagen);
    }
}
?>