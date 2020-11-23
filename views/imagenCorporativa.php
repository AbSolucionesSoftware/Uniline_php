<?php
session_start();
$pagina = "general";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Imagen corporativa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="ABsoluciones">
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta name="description" content="Imagen corporativa, Quieres saber quienes somos, aqui te lo decimos!">
    <meta charset="UTF-8">

    <title>Escuela Al Revés</title>

    <link rel="stylesheet" href="../css/bootstrap.css"> <!--  importante! -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/main_styles.css">
    <link rel="stylesheet" href="../css/styles/login.css">
    <link rel="stylesheet" href="../css/stylo.css">
    <link rel="stylesheet" href="../css/icons/all.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> <!--  importante! -->

    <style>
        @media (min-width: 377px) {
            .contenido {
                margin-left: 10rem;
                margin-right: 10rem;
                padding-left: 5rem;
                padding-right: 5rem;
            }
        }

        a {
            font-size: 15px;
        }

        p {
            text-align: justify;
            color: black;
        }

        h1 {
            text-align: center;
            font-weight: bold;
        }

        h5 {

            font-size: 20px;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }

        #contenedorimg img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }

        .contenido {

            padding-left: 5rem;
            padding-right: 5rem;
        }

        .foter {
            color: white;
        }

        .texto {
            padding-left: 1rem;
            padding-right: 1rem;
            line-height: 20px;
            font-size: 16px;
        }

        .hover {
            position: relative;
            display: inline-block;
            background-color: green;
            margin-right: 10px;
            transition: all 0.4s ease;
        }

        .hover:hover {
            transform: scale(1.1);
            margin-right: 40px;
            margin-left: 26px;
        }
    </style>
</head>

<body>

    <!-- #header -->
    <?php include "../Components/header.php"; ?>
    <!-- #header -->

    <div class="card contenido">
        <div class="card-body">
            <div id="contenedorimg" style="margin-top: 3rem;">
                <img class="img-fluid" src="../img/imagenCorporativa.png" alt="imagen corporativa">
            </div>
            <br>
        </div>
        <div class="text-center">
            <div id="divparrafo1" style=" margin-bottom: 5rem;">
                <h3 style="font-weight: bold;">Nuestro Sueño </h3>
                <h3 class="">Ayudar a trabajadores, empresarios, emprendedores,
                    profesores, alumnos y toda persona que quiera desarrollarse y
                    crecer profesionalmente a través de nuestros cursos en línea.
                </h3>
                <br>
                <h3 style="font-weight: bold">Valores</h3>
                <br>
                <div class="row text-center justify-content-between d-lg-flex d-sm-inline-block">

                    <div class="col-lg-3 text-white hover" style="background: #08917a; border-radius: 1rem;">
                        <h3>Coherencia</h3>
                        <i class="fas fa-puzzle-piece text-white" style="font-size: 80px"></i>
                        <br>
                        <br>
                        <p class="texto text-white">Cada curso ofrecido dentro de nuestra plataforma será por una
                            persona experta en el área la cual tiene conocimientos y experiencia,
                            la mezcla entre estas dos partes nos permite ofrecer cursos con un alto
                            contenido de valor profesional.
                        </p>
                    </div>

                    <div class="col-lg-3 text-white hover" style="background: #016693; border-radius: 1rem;">
                        <h3>Innovación</h3>
                        <i class="far fa-lightbulb text-white" style="font-size: 80px"></i>
                        <br>
                        <br>
                        <p class="texto text-white">Siempre en búsqueda de ofrecer la mejor experiencia hacia el usuario,
                            en UNILINE nos dedicamos a crear metodologías tanto de navegación como
                            de aprendizaje para ofrecer una experiencia agradable en cada segundo
                            que nos visualices.
                        </p>
                    </div>

                    <div class="col-lg-3 text-white hover" style="background: #014765; border-radius: 1rem;">
                        <h3>Actualización</h3>
                        <i class="fas fa-redo-alt text-white" style="font-size: 80px"></i>
                        <br>
                        <br>
                        <p class="texto text-white">Trabajaremos todos los días en la actualización de contenido,
                            buscando ofrecer las mejores herramientas a cualquiera que tome
                            uno de nuestros cursos, con la finalidad de que pueda sentir un
                            verdadero cambio al termino de estos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script async src="../js/main.js"></script>
    <script src="../js/superfish.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/registro32.js"></script>
    <script src="../js/login9.js"></script>

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>