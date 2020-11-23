<?php
use Modelos\Conexion;
require_once '../Modelos/Conexion.php'; 
session_start();

$conexion = new Modelos\Conexion();
$vkey=$_GET['vkey'];
$consulta = "SELECT * FROM usuario WHERE vkey = ?";
$datos = array($vkey);
$resultado = json_encode($conexion->consultaPreparada($datos,$consulta,2,'s', false, null));
$result = json_decode($resultado);

if($resultado != '[]'){
    $update = "UPDATE usuario SET verificado = 1 WHERE vkey = ?";
    $datos2 = array($vkey);
    $resultUp = $conexion->consultaPreparada($datos2,$update,1,'i', false, null);
    $_SESSION['acceso'] = $result[0][1];
    $_SESSION['idusuario'] = $result[0][0];
    $_SESSION['verificado'] = $resultUp;
    $_SESSION['imagen_perfil'] = "../img/perfil.png";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cuenta verificada</title>
    <style>
                
               /*sm*/
                @media (min-width: 300px) {
                    .responsive{
                        width: 100%; 
                        height: 60%; 
                        border-radius: 1rem;
                    }

                }
                @media (min-width: 377px) {
                    .responsive{
                        width: 100%; 
                        height: 60%; 
                        border-radius: 1rem;
                    }

                }
                @media (min-width: 768px) {
                    .responsive{
                        width: 100%; 
                        height: 60%; 
                        border-radius: 1rem;
                    }

                }
                @media (min-width: 992px) {
                    .responsive{
                        width: 40%; 
                        height: 70%!important; 
                        border-radius: 1rem;
                    }

                }
                @media (min-width: 1440px) {
                    .responsive{
                        width: 40%; 
                        height: 50%!important; 
                        border-radius: 1rem;
                    }

                }
            </style>

    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/icons/all.css">

</head>

<body class="pass-area">
    <div class="overlay-bg">
        <div class="container fullscreen flex align-items-center justify-content-center">
            <div id="ventana" class="align-items-center justify-content-center bg-white responsive">               
                <div id="mostrar">
                    <div class="imagen text-center">
                        <img class="img-fluid" src="../img/uniline3.png" alt="uniline" width="60%" style="margin-top: 1rem;">
                    </div>
                    <br>
                    <div class="contenido text-center">
                        <div class="container p-3 my-3">
                            <h2 class="h2">¡Cuenta verificada!</h2>
                            <br>
                            <i class="fas fa-check-circle d-block text-success" style="font-size: 100px;"></i>
                            <br>
                            <a class="btn btn-success" href="../views/mainpage.php">¡Comienza ya!</a>
                        </div>
                    </div>  
                </div>           
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>