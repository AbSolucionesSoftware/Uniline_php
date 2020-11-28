<?php
session_start();
require_once '../Modelos/Conexion.php';
include '../controllers/sesion.php';
$_SESSION['idcurso'] = $_GET['idcurso'];
$pagina = "general";
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="/img/favicon.png" />
  <meta name="author" content="AB soluciones empresariales">
  <meta name="description" content="Dashboard del curso">
  <meta charset="UTF-8">
  <!-- Site Title -->
  <title>Escuela Al Revés</title>



  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--   <link rel="stylesheet" href="../css/bootstrap.css"> -->
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/main_styles.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/icons/all.css">
  <link rel="stylesheet" href="../css/stylo.css">

</head>

<body>

  <div class="modal fade" id="modalCalificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5" id="exampleModalLabel">Calificacion del curso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-lg-12">

            <div class="container text-center">
              <h6 class="h3">Calidad del curso</h6>
              <div class="">
                <div class="star m-5" style="color: gray">
                  <i id="1" class="fa fa-star start estrella h2 m-2" style="cursor: pointer;"></i>
                  <i id="2" class="fa fa-star start estrella h2 m-2" style="cursor: pointer;"></i>
                  <i id="3" class="fa fa-star start estrella h2 m-2" style="cursor: pointer;"></i>
                  <i id="4" class="fa fa-star start estrella h2 m-2" style="cursor: pointer;"></i>
                  <i id="5" class="fa fa-star start estrella h2 m-2" style="cursor: pointer;"></i>
                </div>
              </div>
            </div>



            <div class="form-group text-center">
              <label for="exampleFormControlTextarea1">Deja tu comentario</label>
              <textarea maxlength="500" id="text_area_curso" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div id="alertas-curso" class="alert alert-danger" role="alert">
              Ups! Algo salio mal.
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="guardarCurso" type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <div id="alertas" class="alert alert-danger fixed-top text-center" style="max-height:85px;display: none;">
  </div>

  <div class="modal fade" id="examenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Examen de diagnostico</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body calificacion">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary final" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- #header -->
  <?php include "../Components/header.php"; ?>
  <!-- #header -->
  <br><br>

  <div class="device-container">
    <section class="relative">
      <div class="contenedor">
        <div id="div-original" class="row">

          <div id="cambiar-a-examen" class="col-lg-9 col-md-7 col-sm-12 no-padding">
            <div id="contenido-examen" class="ml-5 p-5 d-none" style="min-height: 100rem;margin-left:120px!important;">

            </div>
            <div id="cambio-examen-video">
              <div id="jalaporfa2" class="flex bg-color justify-content-center">
                <iframe src="" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
              </div>


              <div class="col details-content no-padding" style="min-height: 27rem;border-bottom: rgb(0,0,0);">
                <div class="jq-tab-wrapper no-padding" id="horizontalTab">
                  <nav class="navbar navbar-expand-lg navbar-light bg-light no-padding nav-style">
                    <ul class="nav no-padding" id="nav-barra" style="padding-left: 2rem;">
                      <li class="nav-item no-padding">
                        <a id="nav-status" class="nav-link" data-toggle="tab" href="#descripcion">Descripción</a>
                      </li>
                      <li class="nav-item no-padding d-none">
                        <a class="nav-link" data-toggle="tab" href="#archivos">Recursos y Archivos</a>
                      </li>
                      <li class="nav-item no-padding">
                        <button id="calificacion-curso-user" type="button" class="btn btn-primary" style="font-size: 18px;" data-toggle="modal" data-target="#modalCalificacion">Caificar el curso</button>
                      </li>
                    </ul>
                  </nav>

                  <div id="scroll-responsive" class="tab-content container pr-0" style="height: 10rem;">
                    <div class="tab-pane container fade" id="contenido-cursos">
                      <!--contenido de los cursos cuando es responsive-->
                    </div>
                    <div class="tab-pane container text-justify h-scroll" id="descripcion" style=" padding-top:2rem; font-family: 'Poppins:100', sans-serif; font-size: 16px; color: rgb(87, 87, 87);">
                      <div class="row sm-d-block">
                        <div class="col-lg-6 sm-col-12">
                          <h2 id="titulo-curso" class="h2">Acerca de este curso</h2>
                          <br>
                          <div class="container descripcion-tema">

                          </div>
                        </div>

                        <div class="col-lg-6 sm-col-6">
                          <h2 class="font-weight-bold text-center h3">Progreso del curso</h2>
                          <div class=" single-sidebar-widget tag_cloud_widget m-0 ">
                            <div class="loaders m-0 flex justify-content-center">
                              <div class=" elements_loaders_container col-lg-4">
                                <!-- Loader -->
                                <?php
                                $conexion = new Modelos\Conexion();
                                $datos_tema = array($_SESSION['idcurso']);
                                $cosulta_temas_curso = "SELECT COUNT(idtema) AS cantidadTemas FROM tema t 
            INNER JOIN bloque b ON t.bloque = b.idbloque WHERE b.curso = ?";
                                $result = $conexion->consultaPreparada($datos_tema, $cosulta_temas_curso, 2, "i", false, null);

                                $temas_curso = $result[0][0];

                                $consulta_temas_alumno = "SELECT COUNT(tema) FROM tema_completado tm 
            INNER JOIN tema t ON t.idtema = tm.tema 
            INNER JOIN bloque b ON b.idbloque = t.bloque WHERE b.curso = ? AND tm.usuario = ?";
                                $datos_temas_vistos = array($_SESSION['idcurso'], $_SESSION['idusuario']);

                                $result2 = $conexion->consultaPreparada($datos_temas_vistos, $consulta_temas_alumno, 2, "ii", false, null);

                                $temas_vistos = $result2[0][0];
                                $calculo = (100 / intval($temas_curso)) * intval($temas_vistos);
                                $colculo = round($calculo);
                                if ($colculo == 100) {
                                  $colculo = 1;
                                } else if ($colculo < 10) {
                                  $colculo = ".0" . $colculo;
                                } else {
                                  $colculo = "." . $colculo;
                                }
                                ?>
                                <div id="progreso" class="loader mb-0" data-perc="<?php echo $colculo ?>"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane container fade" id="archivos" style=" padding-top:2rem;">
                      Descargar archivos
                      <br>
                      <br>
                      En este apartado podrás descargar los archivos de cada tema <a class="descarga" href="download/pack.txt" download="Pack.txt"> descargar</a>
                      </p>
                    </div>
                    <div class="tab-pane container fade" id="contenido-comentarios">
                      <!--contenido de los cursos cuando es responsive-->
                    </div>
                  </div>
                  <!--</div>-->
                </div>
              </div>

              <!-- seccion de comentarios -->
              <div id="div-original-comentarios">
                <div id="mov-coments" class="container col" style="min-height: 30rem; height: 45rem; background-color: rgb(243, 243, 243); padding: 2rem 5rem;">
                  <h3 class="h3">Comentarios</h3>
                  <br>
                  <section id="area-comentarios" class="c-scroll area-comentarios border">

                  </section>

                  <section id="area-agregar-comentario" class="container flex justify-content-center" style="padding: 0;">
                    <div class="row d-inline-flex" style="width: 100%;">
                      <form action="" style="width: 100%;">
                        <input maxlength="500" class="col-lg-10 col-md-8 col-sm-7 input-field comment-curso" type="text" placeholder="Escribe un comentario..">
                        <input class="col-lg-2 col-md-3 col-sm-2  btn-primary" type="submit" name="enviar" id="enviar" value="Enviar" style="height: 5rem;">
                      </form>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>

          <div id="mov-div" class="col-lg-3 col-md-5 col-sm-12 search-course-right section-gap fondo-lista">
            <div class="col bg-color-lista no-padding">
              <div id="tam-pantalla" class="lista-curso-aside single_sidebar_widget post_category_widget mover h-scroll sticky-aside" style="height: 50%; padding-right: 1rem;">
                <!--loades lista-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- area de tareas -->

  <div id="seccion-tareas" class="area-tareas pl-5 pr-5" style="display:none;">
    <div id="tareas">
      <h4 class="h4">Sube tus tareas aquí</h4>
      <p>Recuerda que calificar la tarea de tus compañeros te dará un panorama diferente</p>
      <form id="subir-tareas" class="form-control d-inline-flex col-lg-6 col-sm-12" style="background-color: white; border:0;">
        <div class="input-group">
          <div class="custom-file col-lg-10 col-sm-12 border no-padding" style="height: 4rem;">
            <input type="file" name="Fimagen" class="text-black col-lg-10 col-sm-5 no-padding" id="customFile" style="height: 4rem;">
            <input type="hidden" name="archivo" value="3">
            <input class="actuali-homework" type="hidden" name="tarea">
            <input class="bloque-archivo" type="hidden" name="bloque-tarea">
          </div>
          <div class="input-group-append">
            <button class="btn btn-outline-primary texce" type="submit" style="height: 4rem;">Subir</button>
          </div>
        </div>
      </form>
      <br><br>
      <hr>

      <br>
      <div class="table-responsive">
        <p class="ml-3 h3">Tu tarea del bloque</p>
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th>Usuarios</th>
              <th>Descargar tarea</th>
            </tr>
          </thead>
          <tbody class="bg-light cuerpo-tb-user">
          </tbody>
        </table>
      </div>
    </div>
    <br>
    <h4 class="h4">
      Sección de tareas
    </h4>
    <p class="h6">En este apartado puedes calificar las tareas de otros usuarios que estan en este curso</p>
    <br>
    <div class="contenedor-tareas table-responsive">

      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th>Usuarios</th>
            <th>Tarea</th>
            <th>Calificaciones recividas</th>
            <th>Calificacion</th>
            <th>Calificar</th>
          </tr>
        </thead>
        <tbody class="bg-light tabla-tareas-completadas">
        </tbody>
      </table>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <div class="text-center">
                <h4 class="modal-title h4 ">Califica esta tarea</h4>
              </div>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body no-padding">
              <div class="hide-calific text-center">
                <div class="calificar">
                  <p class="clasificacion">
                    <input class="calificar-tarea" id="radio1" type="radio" name="estrellas" value="1">
                    <label for="radio1">★</label>
                    <input class="calificar-tarea" id="radio2" type="radio" name="estrellas" value="2">
                    <label for="radio2">★</label>
                    <input class="calificar-tarea" id="radio3" type="radio" name="estrellas" value="3">
                    <label for="radio3">★</label>
                    <input class="calificar-tarea" id="radio4" type="radio" name="estrellas" value="4">
                    <label for="radio4">★</label>
                    <input class="calificar-tarea" id="radio5" type="radio" name="estrellas" value="5">
                    <label for="radio5">★</label>
                  </p>
                </div>

                <div class="cometario p-3">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Deja tu comentario</label>
                    <textarea maxlength="500" id="coment-user" class="form-control rounded-0" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>
                </div>

              </div>
              <div class="mostrar-comentario m-3">

              </div>
            </div>

            <div class="modal-footer">
              <button id="btn-cali" type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!--   <script src="../js/jquery.js"></script> -->
  <script src="../js/jquery-3.2.1.min.js"></script>
  <!--   <script src="../js/stellar.js"></script> -->
  <!--   <script src="../vendors/nice-select/js/jquery.nice-select.min.js"></script> -->
  <!--   <script src="../vendors/owl-carousel/owl.carousel.min.js"></script> -->
  <!--   <script src="../js/owl-carousel-thumb.min.js"></script> -->
  <!--   <script src="../js/jquery.ajaxchimp.min.js"></script> -->
  <!--   <script src="../vendors/counter-up/jquery.counterup.js"></script> -->
  <!--   <script src="../js/mail-script.js"></script> -->
  <!--gmaps Js-->
  <!--   <script src="../js/gmaps.min.js"></script> -->
  <!--   <script src="../js/theme.js"></script> -->
  <!--   <script src="../js/popper.js"></script> -->
  <script src="../js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/vendor/bootstrap.min.js"></script>

  <!--   <script src="../js/easing.min.js"></script> -->
  <!--   <script src="../js/hoverIntent.js"></script> -->
  <script src="../js/superfish.min.js"></script>
  <!--   <script src="../js/jquery.ajaxchimp.min.js"></script> -->
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/jquery.tabs.min.js"></script>
  <!--   <script src="../js/jquery.nice-select.min.js"></script> -->
  <script src="../js/owl.carousel.min.js"></script>
  <!--   <script src="../js/mail-script.js"></script> -->
  <script src="../js/main.js"></script>

  <!-- Course/Elements -->

  <!--   <script src="../plugins/greensock/TweenMax.min.js"></script> -->
  <!--   <script src="../plugins/greensock/TimelineMax.min.js"></script> -->
  <script src="../plugins/scrollmagic/ScrollMagic.min.js"></script>
  <!--   <script src="../plugins/greensock/animation.gsap.min.js"></script> -->
  <!--   <script src="../plugins/greensock/ScrollToPlugin.min.js"></script> -->
  <script src="../plugins/progressbar/progressbar.min.js"></script>
  <!--   <script src="../plugins/scrollTo/jquery.scrollTo.min.js"></script> -->
  <!--   <script src="../plugins/easing/easing.js"></script> -->
  <script src="../js/elements_custom.js"></script>
  <script src="../js/jquery.confetti.js"></script>
  <script src="https://player.vimeo.com/api/player.js"></script>
  <script src="../js/dashboard46.js"></script>


  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>

</body>


<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>