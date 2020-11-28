<?php
session_start();
$pagina = "mainpage";
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="/img/favicon.png" />
  <meta name="author" content="AB soluciones empresariales">
  <meta name="description" content="En UNILINE, la escuela al reves encontraras los mejores cursos de calidad y a buen precio, y lo mejor es que puedes aprender a tu ritmo!">
  <meta name="keywords" content="">
  
  <!-- meta character set -->
  <meta charset="UTF-8">
  <meta property="og:title" content="Escuela Al Revés UNILINE">
  <meta property="og:description" content="Aprende en nuestra escuela en linea.">
  <meta property="og:image" content="https://www.escuelaalreves.com/img/inicio.jpg">
  <meta property="og:url" content="https://www.escuelaalreves.com">
  <!-- Site Title -->
  <title>Escuela Al Revés</title>

  <!--
    CSS
    ============================================= -->

  <link rel="stylesheet" href="../css/bootstrap.css"> <!--  importante! -->
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/main_styles.css">
  <link rel="stylesheet" href="../css/styles/login.css">
  <!-- <link rel="stylesheet" href="../css/style.css"> -->
  <link rel="stylesheet" href="../css/stylo.css">
  <link rel="stylesheet" href="../css/stylo-responsive-editPerfil.css">
  <link rel="stylesheet" href="../css/icons/all.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> <!--  importante! -->

</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W9KKRW5" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div id="alertas-registro" class="alert alert-danger fixed-top text-center" style="max-height:54px; display: none;">
  </div>

  <!-- #header -->
  <?php include "../Components/header.php"; ?>
  <!-- #header -->

  <!-- Modal Contenido del curso-->
  <div class="modal fade" id="modal-cursos" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content ">
        <div class="modal-header header-curso"></div>
        <div class="modal-body">
          <div class="view-curso"></div>
        </div>
        <div class="modal-footer boton-footer"></div>
      </div>
    </div>
  </div>


  <!-- start banner Area -->
  <section class="banner-area relative" id="home-banner">
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-between">
        <?php
        if (isset($_SESSION['acceso'])) {
        ?>
          <div class="banner-content col-lg-11">
            <h2 class="text-white text-center titulo">
              APRENDE DESDE CASA EN EL MOMENTO QUE TÚ QUIERAS.
            </h2>
            <p class="text-white text-center" style="font-family: Century Gothic; font-weight: 400; font-size: 22px; line-height: 25px;">
              Tu salón de clases está en tu casa..
            </p>
            <br>
          </div>
        <?php
        } else {
        ?>
          <div class="banner-content col-lg-11">
            <h2 class="text-white text-center titulo">
              APRENDE DESDE CASA EN EL MOMENTO QUE TÚ QUIERAS.
            </h2>
            <p class="text-white text-center" style="line-height: 25px; font-family: Century Gothic; font-weight: 400; font-size: 22px">
              Tu salón de clases está en tu casa..
            </p>
            <br>
            <div class="flex justify-content-center">
              <a href="#" data-toggle="modal" data-target="#modal-registro" class="btn btn-primary text-uppercase" style="width: 40rem; font-size: 30px; font-weight: 600;">
                COMENZAR AHORA <i class="fas fa-chevron-right ml-1"></i></a>
            </div>
            <br>
          </div>
      </div>
    <?php
        }
    ?>

  </section>

  <!-- End banner Area -->





  <!-- Popular -->

  <div id="all-cursos" class=" mt-5">
    <div class="container-custom">
      <div class="text-center">
        <p class="h1" style="font-weight: bold;">Nuestros cursos</p>
      </div>
      <div class="cursos"></div>
    </div>
    <button id="date-modal" type="button" class="btn btn-info btn-lg d-none" data-toggle="modal" data-target="#modal-cursos"></button>
  </div>

  <!-- <section class="dash-area" style="height: 250px;">
    <div class="row overlay-bg p-0 px-md-5 px-sm-3" style="background: linear-gradient(transparent, rgba(0, 0, 0, 0.664));">
      <div class="col-lg-3 col-md-12 p-5 d-lg-block d-md-none d-none">
        <i style="font-size: 200px" class="fas fa-laptop-code text-white"></i>
      </div>
      <div class="col-lg-6 col-md-12">
        <form class="form-group" id="FCupones">
          <p class="text-center h2 text-white" style="text-shadow: 0.1em 0.1em 0.1em #000!important;">Canjea tu Codigo</p>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-lg-6 col-md-12 mb-3 mb-md-2">
                  <input name="INCodigo" class="form-control" type="text" placeholder="Codigo" id="codigo">
                </div>
                <div class="col-lg-6 col-md-12">
                  <select name="SCurso" class="form-control" style="height:50px;
                                    line-height:30px;
                                    border-radius: 5px;" id="curso">
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-12 pt-5">
              <button class="btn btn-block text-white" style="height:50px; font-size: 20px; background-color: #fd5601;" type="submit">Canjear codigo</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-md-12 p-5">
        <p class="h3" style="color: #fd5601;text-shadow: 0.1em 0.1em 0.1em #000!important;">Ingresa tu código</p>
        <p class="h3 text-white" style="text-shadow: 0.1em 0.1em 0.1em #000!important;">y comienza a disfrutar sus beneficios.</p>
      </div>
    </div>
  </section> -->




  <!-- start banner Area -->
  <section class="banner-area relative" style="min-height: 30rem;">
    <div class="overlay overlay-bg-footer"></div>
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center mt-10">
        <div class="col-lg-12 text-center">
          <h1 class="text-white">
            Contacto
          </h1>
          <br>
          <br>

          <div class="col-lg-12 d-lg-flex d-sm-inline-block text-white justify-content-between" style="margin-left: 0">
            <div class="single-contact-address d-inline-block" style="max-width: 20rem;">
              <div class="icon">
                <span class="fa fa-home" style="font-size: 30px"></span>
              </div>
              <div class="contact-details">
                <h5>Autlán de Navarro, Jalisco</h5>
                <p>
                  Corona Araiza #540 Col.IPEVI C.P.48900
                </p>
              </div>
            </div>
            <div class="single-contact-address d-inline-block" style="max-width: 20rem;">
              <div class="icon">
                <span class="fa fa-phone" style="font-size: 30px"></span>
              </div>
              <div class="contact-details">
                <h5>3171035768</h5>
                <p>Lunes a Viernes con atención de 9:00 a 16:00 horas</p>
              </div>
            </div>
            <div class="single-contact-address d-inline-block" style="max-width: 20rem;">
              <div class="icon">
                <span class="fa fa-envelope" style="font-size: 30px"></span>
              </div>
              <div class="contact-details">
                <p>Atención a clientes</p>
                <h5>atencionaclientes@escuelaalreves.com</h5>
                <p>¡No dudes en escribirnos!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- End contact-page Area -->
  <div id="home-contacto"></div>


  <script src="https://js.stripe.com/v3/" async></script>
<!--   <script src="../js/jquery.js"></script>  --><!--  importante! -->
  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" async> </script>
<!--   <script src="https://player.vimeo.com/api/player.js" async></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="../js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/vendor/bootstrap.min.js"></script>
<!--   <script src="../js/easing.min.js"></script> -->
  <script src="../js/superfish.min.js"></script>
<!--   <script src="../js/jquery.ajaxchimp.min.js"></script> -->
  <script src="../js/jquery.magnific-popup.min.js"></script> <!--  importante! -->
  <script src="../js/owl.carousel.min.js"></script>
  <script async src="../js/main.js"></script>
<!--   <script async src="../js/popper.js"></script> -->
  <!-- #Scripts -->

  <script src="../js/registro32.js"></script>
  <script src="../js/login9.js"></script>

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>