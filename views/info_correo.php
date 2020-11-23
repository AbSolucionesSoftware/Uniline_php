<?php
$pagina = "mainpage";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar contraseña</title>
    <style>
        .responsive {
            padding: 3rem;
            margin: 0 20rem 0 20rem;
            width: auto;
            height: auto;
            border-radius: .5rem;
        }
    </style>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/icons/all.css">

</head>


<body class="pass-area">
    <!-- #header -->
    <?php include "../Components/header.php"; ?>
    <!-- #header -->

    <div class="overlay-bg">
        <div class="container fullscreen flex align-items-center justify-content-center">
            <div id="ventana" class="align-items-center justify-content-center bg-white responsive">
                <div class="imagen text-center">
                    <img class="img-fluid" src="../img/uniline3.png" alt="uniline" width="60%">
                </div>
                <br>
                <p>Te hemos enviado un correo para verificar tu cuenta.</p>

                <p>Una vez confirmada, podrás acceder a UNILINE.</p>

                <p>En caso de que no veas nuestro correo, puedes revisar tu bandeja
                    de correo no deseado o SPAM.</p>

                <p>Si aún tienes problemas, comunícate con nosotros o envíanos un
                    correo a <span class="text-primary">atencionalcliente@escuelaalreves.com</span>
                    tu eres muy importante para nosotros, permítenos ser parte de ti.
                </p>
                <p>Atte: Equipo de UNILINE</p>
            </div>
        </div>
    </div>

    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script src="../js/easing.min.js"></script>
    <script src="../js/superfish.min.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/restPass11.js"></script>
    <script src="../js/registro32.js"></script>
    <script src="../js/login9.js"></script>

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>