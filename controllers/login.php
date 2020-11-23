<?php

use Modelos\Conexion;

session_start();
define('RUTA_UNILINE_APP','http://localhost/uniline/Views');
require_once '../Modelos/Conexion.php';

$conexion = new Modelos\Conexion();

$email = $_POST['TEmail'];
$password = $_POST['TPassword'];

$consulta = "SELECT * FROM usuario WHERE email = ?";
$datos = array($_POST['TEmail']);
$resultado = json_encode($conexion->consultaPreparada($datos,$consulta,2,'s', false, null));
$result = json_decode($resultado);


if ($resultado != "[]") {
    if (password_verify($password, $result[0][7])) {
        if($result[0][9] == 1 && $result[0][10] != 'CEO') {
            switch($result[0][10]){
                case 'Estudiante':
                    echo 1;
                break;
                case 'Maestro':
                    echo 2;
                break;
            }
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
            
        }else if($result[0][10] == 'CEO'){
            echo 'ceo';
            $_SESSION['CEO'] = $result[0][10];         
        }else{
            echo "NoVerificado";
        }
      
    } else {

        echo "passwordIncorrecta";
    }
}else{
        echo "no existe";
    }

    if (isset($_GET['cerrar_sesion'])) {
        session_unset();
        session_destroy();
        header('Location: ../Views/login.php');
        //se destruye la sesion al dar click en los botones de salir
    }
 ?>