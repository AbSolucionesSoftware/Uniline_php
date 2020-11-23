<?php
session_start();
require_once '../controllers/sesion.php';
if (!empty($_GET['session_id'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Success</title>


        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/icons/all.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>

    <style>
        .alertaspago {
            padding: 5rem;
            margin: auto;
            width: auto;
            height: auto;
            border-radius: .5rem;
        }
    </style>

    <body class="dash-area">
        <div class="overlay-bg">
            <div class="container fullscreen flex align-items-center justify-content-center">
                <div id="ventana-alerta" class="align-items-center justify-content-center bg-light alertaspago d-none">
                    <div id="mostrar">
                        <div class="imagen text-center">
                            <span style="font-size: 250px;"><i class="img-fluid fas fa-check-circle text-success"></i></span>
                        </div>
                        <div class="contenido text-center">
                            <h3 class="h2">¡Listo!</h3>
                            <h4 class="h3">Tu pago ha sido aprovado</h4>
                            <br>
                            <a class="btn btn-success" href="misCursos.php">Ir a curso!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/vendor/jquery-2.2.4.min.js"></script>
        <script src="../js/superfish.min.js"></script>
        <script src="../js/jquery.magnific-popup.min.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/main.js"></script>
        <script src="../js/animacion_pago.js"></script>
    </body>

    </html>

<?php } else {
    header('Location: mainpage.php');
}
?>