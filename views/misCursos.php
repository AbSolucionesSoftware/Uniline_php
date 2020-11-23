<?php
session_start();
include '../controllers/sesion.php';
$pagina = "general";
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="ABsoluciones">
  <link rel="icon" type="image/png" href="/img/favicon.png" />
  <meta name="description" content="Lista de los cursos adquiridos">
  <meta charset="UTF-8">

  <title>Escuela Al Revés</title>

  

  <!--
    CSS
    ============================================= -->


  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/main_styles.css">
  <link rel="stylesheet" href="../css/styles/login.css">
  <link rel="stylesheet" href="../css/stylo.css">
  <link rel="stylesheet" href="../css/icons/all.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


</head>

<body>
  <!-- #header -->
  <?php include "../Components/header.php"; ?>
  <!-- #header -->

  <!-- Popular -->

  <div class="popular page_section" style="min-height: 80rem;">
    <div class="container">
      <div class="section_title text-center">
        <h2 id="hay-cursos" class="h1"></h2>
      </div>
      <hr>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th colspan="2">Cursos</th>
            </tr>
          </thead>
          <tbody id="lista-tabla-cursos">
            <!-- carga de la lista de cursos de bd -->
          </tbody>
        </table>
      </div>

    </div>
  </div>
  </div>

  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/vendor/bootstrap.min.js"></script>
  <script src="../js/superfish.min.js"></script>
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/main.js"></script>
  <script src="../js/miscursos.js"></script>

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>