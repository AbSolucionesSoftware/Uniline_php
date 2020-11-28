<?php
session_start();
$_SESSION['idcurso'] = $_GET['idcurso'];
$pagina = "general";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../controllers/metadatos.php";
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta name="author" content="AB soluciones empresariales">
    <meta name="description" content="Descripcion de los cursos">

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/main_styles.css">
    <link rel="stylesheet" href="../css/styles/login.css">
    <!--     <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="../css/stylo.css">
    <link rel="stylesheet" href="../css/style-descripcion-cursos.css">
    <link rel="stylesheet" href="../css/stylo-responsive-editPerfil.css">
    <link rel="stylesheet" href="../css/icons/all.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>
    <!-- #header -->
    <?php include "../Components/header.php"; ?>
    <!-- #header -->

    <div class="container-fluid relative" style="margin-top: 3rem;">
        <div class="contenido-titulo banner-area row">
            <div class="overlay overlay-bg"></div>
            <div class="d-sm-block d-lg-flex">
                <div id="imagen-curso" class="col-12 col-lg-3">
                    <!-- imagen del curso -->
                </div>
                <div class="col-12 col-lg-9 d-flex align-items-center">
                    <div class="col">
                        <div id="titulo-curso" class="titulo-curso col-12 col-lg-12">
                            <!-- titulo del curso -->
                        </div>
                        <div id="botones-curso" class="botones-curso col-12 col-lg-6">
                            <!-- botones del curso -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contenido-informacion">
        <div class="row mx-lg-5 mw-100 mx-auto">
            <!-- <div class="d-sm-block d-lg-flex mx-lg-5"> -->
                <div class="detalles-curso col-12 col-lg-3 pt-3 px-5">
                    <div class="sticky">
                        <div id="informacion-curso">
                            <!-- informacion del curso -->
                        </div>
                        <hr>
                        <h3 class="text-center">¡Canjea tu código aqui!</h2>
                            <div class="mt-3 text-center">
                                <p class="h4" style="color: #fd5601;">Ingresa tu código</p>
                                <p class="h4">y comienza a disfrutar sus beneficios.</p>
                                <form class="form-group" id="FCupones">
                                    <input name="INCodigo" class="form-control" type="text" placeholder="Codigo" id="codigo">
                                    <button class="btn btn-block text-white mt-3" style="height:50px; font-size: 20px; background-color: #fd5601;" type="submit">Canjear codigo</button>
                                </form>
                            </div>
                            <h3 class="text-center">¡Compártelo con tus amigos!</h2>
                                <div class="mt-3 text-center">
                                    <a class="whatsapp" href="whatsapp://send?text=https://www.escuelaalreves.com/views/descripcioncursos.php?idcurso=<?php echo $_SESSION['idcurso'] ?>"><i class="fab fa-whatsapp"></a></i>

                                    <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fwww.escuelaalreves.com%2Fviews%2Fdescripcioncursos.php%3Fidcurso%3D<?php echo $_SESSION['idcurso'] ?>&layout=button&size=large&width=103&height=28&appId" width="103" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                                </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div id="contenido-video" class="mt-3">
                        <!-- Contenido video y descripcion -->
                    </div>
                </div>
                <div class="contenido-curso text-center col-12 col-lg-3">
                    <div class="titulo-contenido">
                        <h3 class="text-white">Contenido del curso</h2>
                    </div>
                    <br>
                    <div class="contenido-informacion pb-5">
                        <br>
                        <ul id="contenido-contenido">
                            <!-- Contenido -->
                        </ul>
                    </div>
                </div>
         <!--    </div> -->
        </div>
    </div>

    <!-- #Scripts -->
    <script src="https://js.stripe.com/v3/" async></script>
    <!--     <script src="../js/jquery.js"></script> -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" async> </script>
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <!--     <script src="../js/easing.min.js"></script> -->
    <script src="../js/superfish.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
    <!--     <script src="../js/popper.js"></script> -->
    <script src="../js/descripcion-cursos3.js"></script>
    <script src="../js/registro.js"></script>
    <script src="../js/login9.js"></script>
    <!-- #Scripts -->

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>