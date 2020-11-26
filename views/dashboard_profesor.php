<?php
session_start();
include '../controllers/sesion.php';

/* Damos formato a la url de la imagen del perfil */
$url = "";
if ($_SESSION['imagen_perfil'] != "../img/perfil.png") {
   $split = explode("/", $_SESSION['imagen_perfil']);
   $url = "../" . $split[1] . "/min_" . $split[2];
} else {
   $url = $_SESSION['imagen_perfil'];
}

/* Damos formato al nombre, lo que se mostrara será primer nombre y apellido paterno */
$nombres_separados = explode(" ", $_SESSION['nombre']);
$nombre = (sizeof($nombres_separados) > 2) ? $nombres_separados[0] . ' ' . $nombres_separados[2] : $_SESSION['nombre'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--FONT AWESOME-->

   <!--BOOTSTRAP 4--->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

   <title>Dashboard Cursos</title>

   <style type="text/css">
      #ir-arriba {
         color: #0275d8;
         font-size: 40px;
         bottom: 10px;
         left: 10px;
         display: none;
         cursor: pointer;
         max-width: 60px;
      }
   </style>
</head>

<body>

   <div class="row">

      <div class="col-lg-3 py-5 vh-100 border-right navbar-expand shadow">

         <div class="media mb-5">

            <span class="bg-dark overflow-hidden d-flex justify-content-center rounded-circle mx-3" style="width: 75px; height:75px;">
               <img src=<?php echo $url ?> alt="prof" class="align-self-center mw-25 h-100">
            </span>

            <div class="media-body">
               <h5 class="mt-2"><?php echo $nombre ?></h5>
               <p class="mb-0"><?php echo $_SESSION['tipo'] ?></p>

            </div>

         </div>

         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="cursos-tab" data-toggle="pill" href="#cursos" role="tab" aria-controls="v-pills-cursos" aria-selected="true">Cursos</a>
            <a class="nav-link" id="contenido-curso-tab" data-toggle="pill" href="#contenido-curso" role="tab" aria-controls="v-pills-contenido-curso" aria-selected="false">Contenido del Curso</a>
            <!-- <a class="nav-link" id="estadisticas-tab" data-toggle="pill" href="#v-pills-estadisticas" role="tab"
               aria-controls="v-pills-estadisticas" aria-selected="false">Estadísticas</a>
            <a class="nav-link" id="v-pills-ayuda-tab" data-toggle="pill" href="#v-pills-ayuda" role="tab"
               aria-controls="v-pills-ayuda" aria-selected="false">Ayuda</a> -->
            <br>
            <a class="nav-link" href="mainpage.php" aria-selected="false">Pagina principal</a>
            <a class="nav-link" href="misCrusos" aria-selected="false">Mis cursos</a>
            <a class="nav-link" href="editProfile.php" aria-selected="false">Editar mi perfil</a>
            <a class="nav-link" href="../controllers/sesion-destroy.php?cerrar=true" aria-selected="false">Cerrar sesion</a>
         </div>
      </div>

      <!--MAIN CONTENT-->

      <div class="col-lg-9 p-4">

         <!-- COMBO BOX SUPERIORES -->
         <div class="row mb-5">

            <div class="col-lg-6">

               <p class="small m-0">&nbsp;</p>
               <select class="shadow custom-select form-control custom-select-lg text-danger" name="cursos" id="cursos-select">

               </select>
            </div>

            <div class="col-lg-6">
               <p id="info-select-bloque" class="small text-danger m-0">*Selecciona un curso para mostrar bloques</p>
               <select class="shadow custom-select form-control custom-select-lg text-danger" name="bloques" id="bloques-select">
               </select>
            </div>
         </div>


         <div class="tab-content" id="v-pills-tabContent">

            <!-- CURSOS TAB -->
            <div class="tab-pane fade show active" id="cursos" role="tabpanel" aria-labelledby="cursos-tab">

               <div class="accordion" id="accordionCurso">
                  <div class="card bg-light shadow">
                     <div class="card-header" id="headingOne">
                        <h2 class="mb-0 text-center">
                           <div class="row">

                              <div class="col-md-4">
                                 <button class="btn btn-link add-edit" type="button" id="nuevo-curso" data-toggle="collapse" data-target="#collapseNewCurso" aria-expanded="true" aria-controls="collapseOne">
                                    <h5><i class="fas fa-plus-circle"></i> Nuevo Curso</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link add-edit disabled" type="button" id="editar-curso" data-toggle="collapse" data-target="#collapseEditCurso" aria-expanded="true" aria-controls="collapseOne" name="edit-curso">
                                    <h5><i class="fas fa-edit"></i> Editar Curso</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link" type="button" href="#seccion-tablas" id="ver-cursos">
                                    <h5><i class="fas fa-eye"></i> Ver Cursos</h5>
                                 </button>
                              </div>
                           </div>

                        </h2>
                     </div>

                     <div id="collapseNewCurso" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="registrar-curso">
                              <div class="text-center" id="imagen-default">
                                 <img src="../img/cursos/no_course.png" id="foto-curso" alt="curso" class="img align-self-center  mb-3 w-25" />
                              </div>
                              <div class="form-group">
                                 <div class="custom-file" id="archivo-default">
                                    <input type="file" class="input-curso custom-file-input imagen" id="file-image-curso" name="imagen-curso">
                                    <label class="custom-file-label" for="file-image-curso" id="image-name-curso">Subir
                                       Imagen del Curso
                                    </label>
                                 </div>
                              </div>


                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <input type="text" class="input-curso form-control form-control-sm" name="nombre-curso" placeholder="Nombre del Curso">
                                 </div>
                                 <div class="form-group col-md-12">
                                    <textarea class="input-curso form-control form-control-sm" name="descripcion-curso" placeholder="Descripción del curso"></textarea>
                                 </div>
                              </div>
                              <div class="form-row">
                                 <div class="form-group col-md-6">
                                    <input type="number" id="horas-curso" name="horas-curso" placeholder="Horas del Curso" class="input-curso form-control form-control-sm">
                                 </div>
                                 <div class="form-group col-md-6">
                                    <input type="number" id="costo-curso" name="costo-curso" placeholder="Costo de Curso" class="input-curso form-control form-control-sm">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <input type="text" class="input-curso form-control form-control-sm" name="video-curso" placeholder="URL video">
                              </div>

                              <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-nuevo-curso">
                                 <p>¡<b>CURSO CREADO:</b> se ha registrado el curso con éxito.!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>
                                 <button type="submit" name="submit" class="col-lg-4 offset-lg-6 btn btn-success btn-md" id="boton-curso">Crear</button>
                              </div>

                           </form>

                        </div>
                     </div>

                     <div id="collapseEditCurso" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="editar-curso-form">
                              <div class="text-center">
                                 <img src="../img/cursos/no_course.png" id="foto-curso-edit" alt="curso" class="img align-self-center  mb-3 w-25" />
                              </div>
                              <div class="form-group">
                                 <label>Imagen del curso</label>
                                 <div class="custom-file">
                                    <input type="file" class=" custom-file-input imagen" id="file-image-edit-curso" name="imagen-curso-edit">
                                    <label class="custom-file-label" for="file-image-edit-curso" id="image-name">Cambiar
                                       Imagen</label>
                                 </div>
                              </div>


                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <label>Nombre del curso</label><input type="text" class="input-curso-edit form-control form-control-sm" name="nombre-curso" placeholder="Nombre del Curso">
                                 </div>
                                 <div class="form-group col-md-12">
                                    <label>Descripción del curso</label><textarea class="input-curso-edit form-control form-control-sm" name="descripcion-curso" placeholder="Descripción del curso"></textarea>
                                 </div>
                              </div>
                              <div class="form-row">
                                 <div class="form-group col-md-6">
                                    <label>Horas del curso</label><input type="number" id="horas-curso-edit" name="horas-curso" placeholder="Horas del Curso" class="input-curso-edit form-control form-control-sm">
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label>Costo del curso</label><input type="number" id="costo-curso-edit" name="costo-curso" placeholder="Costo de Curso" class="input-curso-edit form-control form-control-sm">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Video de introducción</label><input type="text" class="input-curso-edit form-control form-control-sm" name="video-curso" placeholder="URL video">
                              </div>

                              <div class="alert alert-primary mt-3 d-none" role="alert" id="alerta-curso-editado">
                                 <p>¡<b>CURSO ACTUALIZADO:</b> se han realizado los cambios con éxito!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>
                                 <button type="submit" name="submit" class="col-lg-4 offset-lg-6 btn btn-info btn-md" id="boton-curso-edit"><i class="fas fa-check"></i> Terminar Edicion</button>
                              </div>

                           </form>

                        </div>
                     </div>
                  </div>

                  <!-- AÑADIR BLOQUES -->
                  <div class="card bg-light shadow">
                     <div class="card-header" id="headingTwo">
                        <h2 class="mb-0 text-center">

                           <div class="row">

                              <div class="col-md-4">
                                 <button id="aniadir-bloque" class="btn btn-link collapsed add-edit disabled" type="button" data-toggle="collapse" data-target="#collapseBloque" aria-expanded="false" aria-controls="collapseBloque">
                                    <h5><i class="fas fa-plus-circle"></i> Añadir Bloques</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link add-edit disabled" type="button" id="editar-bloque" data-toggle="collapse" data-target="#collapseBloqueEdit" aria-expanded="true" aria-controls="collapseBloqueEdit">
                                    <h5><i class="fas fa-edit"></i> Editar Bloque</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link disabled" type="button" id="ver-bloques">
                                    <h5><i class="fas fa-eye"></i> Ver Bloques</h5>
                                 </button>
                              </div>

                           </div>

                        </h2>
                     </div>
                     <div id="collapseBloque" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="registrar-bloque">

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <input type="text" name="nombre-bloque" id="nombre-bloque" placeholder="Nombre del Bloque" class="input-bloque form-control form-control-sm">
                                 </div>
                              </div>

                              <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-bloque">
                                 <p>¡<b>BLOQUE CREADO:</b> se ha añadido el bloque con éxito!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>

                                 <button type="submit" name="submit" id="boton-bloque" class="col-lg-4 offset-lg-6 btn btn-success btn-md">Crear</button>
                              </div>

                           </form>
                        </div>
                     </div>

                     <!-- EDITAR BLOQUE -->
                     <div id="collapseBloqueEdit" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="editar-bloque-form">

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <label>Nombre del bloque</label><input type="text" name="nombre-bloque" id="nombre-bloque-edit" placeholder="Nombre del Bloque" class="input-bloque-edit form-control form-control-sm">
                                 </div>
                              </div>

                              <div class="alert alert-primary mt-3 d-none" role="alert" id="alerta-bloque-edit">
                                 <p>¡<b>BLOQUE ACTUALIZADO:</b> se han realizado los cambios con éxito!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>

                                 <button type="submit" name="submit" id="boton-bloque-edit" class="col-lg-4 offset-lg-6 btn btn-info btn-md"><i class="fas fa-check"></i>
                                    Terminar Edición</button>
                              </div>

                           </form>
                        </div>
                     </div>
                  </div>

                  <!-- AÑADIR EXAMEN -->
                  <div class="card bg-light shadow">
                     <div class="card-header" id="headingThree">
                        <h2 class="mb-0 text-center">

                           <div class="row">

                              <div class="col-md-4">
                                 <button id="aniadir-examen" class="btn btn-link add-edit collapsed disabled" type="button" data-toggle="collapse" data-target="#collapseExamen" aria-expanded="false" aria-controls="collapseExamen">
                                    <h5><i class="fas fa-plus-circle"></i> Añadir Examen</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link add-edit disabled" type="button" id="editar-examen" data-toggle="collapse" data-target="#collapseExamenEdit" aria-expanded="true" aria-controls="collapseExamenEdit">
                                    <h5><i class="fas fa-edit"></i> Editar Exámen</h5>
                                 </button>
                              </div>

                              <div class="col-md-4">
                                 <button class="btn btn-link disabled" type="button" href="#seccion-tablas" id="ver-examen">
                                    <h5><i class="fas fa-eye"></i> Ver Examen</h5>
                                 </button>
                              </div>

                           </div>

                        </h2>
                     </div>
                     <!-- NUEVO EXAMEN -->
                     <div id="collapseExamen" class="collapse" aria-labelledby="headingThree" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="registrar-examen">

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <input type="text" name="nombre-examen" id="nombre-examen" placeholder="Nombre del Examen" class="input-examen form-control form-control-sm">
                                 </div>
                              </div>

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <textarea name="descripcion-examen" class="input-examen form-control form-control-sm" placeholder="Descripción del exámen"></textarea>
                                 </div>
                              </div>

                              <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-examen">
                                 <p class="m-0"> ¡<b>EXÁMEN CREADO:</b> se ha creado el exámen con éxito!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>

                                 <button type="submit" name="submit-examen" class="col-lg-4 offset-lg-6 btn btn-success btn-md">Crear</button>
                              </div>


                           </form>
                        </div>
                     </div>

                     <!-- EDITAR EXAMEN -->
                     <div id="collapseExamenEdit" class="collapse" aria-labelledby="headingThree" data-parent="#accordionCurso">
                        <div class="card-body">
                           <form id="editar-examen-form">

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <label>Nombre del examen</label><input type="text" name="nombre-examen-edit" id="nombre-examen-edit" placeholder="Nombre del Examen" class="input-examen-edit form-control form-control-sm">
                                 </div>
                              </div>

                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <label>Descripción del examen</label><textarea name="descripcion-examen-edit" class="input-examen-edit form-control form-control-sm" placeholder="Descripción del exámen"></textarea>
                                 </div>
                              </div>

                              <div class="alert alert-primary mt-3 d-none" role="alert" id="alerta-examen-edit">
                                 <p class="m-0"> ¡<b>EXÁMEN ACTUALIZADO:</b> se han realizado los cambios con éxito!</p>
                              </div>

                              <div class="form-row mt-3">
                                 <div class="col-lg-2 text-center">
                                    <div class="spinner-border text-primary d-none" role="status">
                                       <span class="sr-only">Loading...</span>
                                    </div>
                                 </div>

                                 <button type="submit" name="submit-examen" class="col-lg-4 offset-lg-6 btn btn-success btn-md"><i class="fas fa-check"></i>
                                    Terminar Edición</button>
                              </div>


                           </form>
                        </div>
                     </div>

                  </div>

               </div>

               <div class="alert alert-primary mt-3 d-none alerta-elim" role="alert"></div>
               <div class="alert alert-danger mt-3 d-none alerta-error" role="alert"></div>

               <h2 class="titulo-tablas mt-5"></h2>

               <table class="table my-5 w-100 shadow table-responsive-sm">
                  <thead class="bg-info">
                     <tr id="tr-tablagrupo1">

                     </tr>
                  </thead>
                  <tbody id="tbodygrupo1">

                  </tbody>
               </table>

            </div>




            <!-- CONTENIDO CURSOS TAB -->
            <div class="tab-pane fade" id="contenido-curso" role="tabpanel" aria-labelledby="contenido-curso-tab">




               <!-- ACCORDION -->
               <div class="row">
                  <div class="col-lg-12">
                     <div class="accordion" id="accordionContenido">
                        <div class="card bg-light shadow">
                           <div class="card-header" id="headingOne">
                              <h2 class="mb-0 text-center">
                                 <div class="row">

                                    <div class="col-md-4">
                                       <button id="aniadir-tema" class="btn btn-link disabled" type="button" data-toggle="collapse" data-target="#collapseTema" aria-expanded="true" aria-controls="collapseTema">
                                          <h5 class="text-success"><i class="fas fa-plus-circle"></i> Añadir Temas
                                          </h5>
                                       </button>
                                    </div>

                                    <div class="col-md-4">
                                       <button id="editar-temas" class="btn btn-link disabled" type="button" data-toggle="collapse" data-target="#collapseTemaEdit" aria-expanded="true" aria-controls="collapseTemaEdit">
                                          <h5 class="text-success"><i class="fas fa-edit"></i> Editar Temas</h5>
                                       </button>
                                    </div>

                                    <div class="col-md-4">
                                       <button id="ver-temas" class="btn btn-link disabled" type="button" data-target="#tabla-contenido">
                                          <h5 class="text-success"><i class="fas fa-eye"></i> Ver Temas</h5>
                                       </button>
                                    </div>

                                 </div>

                              </h2>
                           </div>

                           <!-- AÑADIR TEMA DE BLOQUE -->
                           <div id="collapseTema" class="collapse" aria-labelledby="headingOne" data-parent="#accordionContenido">
                              <div class="card-body">
                                 <form id="registrar-tema">

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <input type="text" class="input-tema form-control form-control-sm" id="nombre-tema" name="nombre-tema" placeholder="Nombre del Tema">
                                       </div>
                                       <div class="form-group col-md-12">
                                          <textarea class="input-tema form-control form-control-sm" id="descripcion-tema" name="descripcion-tema" placeholder="Descripción del Tema"></textarea>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <input type="text" class="input-tema form-control form-control-sm" id="video-tema" name="video-tema" placeholder="URL video">
                                    </div>

                                    <div class="form-group">
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input" name="archivo-tema" id="archivo-tema">
                                          <label id="archivo-tema-name" class="custom-file-label" for="customFile">Subir
                                             Archivo</label>
                                       </div>
                                    </div>


                                    <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-tema">
                                       <p class="m-0"> ¡<b>TEMA CREADO:</b> se ha creado el tema con éxito!</p>
                                    </div>

                                    <div class="form-row mt-3">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" name="submit-tema" class="col-lg-4 offset-lg-6 btn btn-success btn-md">Añadir</button>
                                    </div>

                                 </form>

                              </div>
                           </div>

                           <!-- EDITAR TEMAS BLOQUE -->
                           <div id="collapseTemaEdit" class="collapse" aria-labelledby="headingOne" data-parent="#accordionContenido">
                              <div class="card-body">

                                 <div class="row my-3">
                                    <div class="col-md-12">
                                       <select class="shadow custom-select form-control custom-select-sm text-danger" id="temas-select">
                                       </select>
                                    </div>
                                 </div>

                                 <form id="editar-tema-form" class="d-none">

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <label>Nombre del tema</label><input type="text" class="input-tema-edit form-control form-control-sm" id="nombre-tema-edit" name="nombre-tema-edit" placeholder="Nombre del Tema">
                                       </div>
                                       <div class="form-group col-md-12">
                                          <label>Descripción del tema</label><textarea class="input-tema-edit form-control form-control-sm" id="descripcion-tema-edit" name="descripcion-tema-edit" placeholder="Descripción del Tema"></textarea>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label>Video del tema</label><input type="text" class="input-tema-edit form-control form-control-sm" id="video-tema-edit" name="video-tema-edit" placeholder="URL video">
                                    </div>

                                    <div class="form-group">
                                       <label>Archivo de este tema</label>
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input" name="archivo-tema-edit" id="archivo-tema-edit">
                                          <label id="archivo-tema-name" class="custom-file-label" for="customFile">Cambiar Archivo</label>
                                       </div>
                                    </div>


                                    <div class="alert alert-primary mt-3 d-none" role="alert" id="alerta-tema-edit">
                                       <p class="m-0"> ¡<b>TEMA ACTUALIZADO:</b> se ha actualizado el contenido con
                                          éxito!</p>
                                    </div>

                                    <div class="form-row mt-3">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" name="submit-tema" class="col-lg-4 offset-lg-6 btn btn-primary btn-md"><i class="fas fa-check"></i> Terminar Edición</button>
                                    </div>

                                 </form>

                              </div>
                           </div>
                        </div>

                        <!-- AÑADIR PREGUNTA DE EXAMEN -->
                        <div class="card bg-light shadow">
                           <div class="card-header" id="headingTwo">

                              <h2 class="mb-0 text-center">
                                 <div class="row">
                                    <div class="col-md-4"><button id="aniadir-pregunta" class="btn btn-link collapsed disabled" type="button" data-toggle="collapse" data-target="#collapsePregunta" aria-expanded="false" aria-controls="collapsePregunta">
                                          <h5 class="text-success"><i class="fas fa-plus-circle"></i> Añadir Preguntas al Examen
                                          </h5>
                                       </button>
                                    </div>

                                    <div class="col-md-4"><button id="editar-pregunta" class="btn btn-link collapsed disabled" type="button" data-toggle="collapse" data-target="#collapsePreguntaEdit" aria-expanded="false" aria-controls="collapsePreguntaEdit">
                                          <h5 class="text-success"><i class="fas fa-edit"></i> Editar Preguntas
                                          </h5>
                                       </button>
                                    </div>

                                    <div class="col-md-4">
                                       <button id="ver-preguntas" class="btn btn-link collapsed disabled" type="button" data-target="#tablas-contenido">
                                          <h5 class="text-success"><i class="fas fa-eye"></i> Ver Preguntas
                                          </h5>
                                       </button>
                                    </div>
                                 </div>
                              </h2>
                           </div>
                           <!-- CREAR PREGUNTA -->
                           <div id="collapsePregunta" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionContenido">
                              <div class="card-body">

                                 <form id="registrar-pregunta">

                                    <!-- PREGUNTA -->
                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <input type="text" name="pregunta-examen" id="pregunta-examen" placeholder="Escriba la pregunta" class="form-control form-control-sm input-preg-resp">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA A -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input radio-pregunta radio-in" data-correcta="1">
                                             <label class="custom-control-label" for="customRadio1"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta1" id="respuesta1" placeholder="Respuesta A" class="form-control form-control-sm input-preg-resp">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA B -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input radio-pregunta radio-in" data-correcta="2">
                                             <label class="custom-control-label" for="customRadio2"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta2" id="respuesta2" placeholder="Respuesta B" class="form-control form-control-sm input-preg-resp">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA C -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input radio-pregunta radio-in" data-correcta="3">
                                             <label class="custom-control-label" for="customRadio3"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta3" id="respuesta3" placeholder="Respuesta C" class="form-control form-control-sm input-preg-resp">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA D -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input radio-pregunta radio-in" data-correcta="4">
                                             <label class="custom-control-label" for="customRadio4"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta4" id="respuesta4" placeholder="Respuesta D" class="form-control form-control-sm input-preg-resp">
                                       </div>
                                    </div>

                                    <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-pregunta">
                                       <p class="m-0"> ¡<b>PREGUNTA REGISTRADA:</b> se han se ha añadido la pregunta con
                                          éxito!</p>
                                    </div>

                                    <div class="form-row">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" class="col-lg-4 offset-lg-8 btn btn-success btn-md">Añadir</button>
                                    </div>

                                 </form>
                              </div>
                           </div>

                           <!-- EDITAR PREGUNTA -->
                           <div id="collapsePreguntaEdit" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionContenido">
                              <div class="card-body">
                                 <div class="row my-3">
                                    <div class="col-md-12">
                                       <select class="shadow custom-select form-control custom-select-sm text-danger" id="preguntas-select">
                                       </select>
                                    </div>
                                 </div>
                                 <form id="editar-pregunta-form" class="d-none">

                                    <!-- PREGUNTA -->
                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <label>Pregunta</label><input type="text" name="pregunta-examen-edit" id="pregunta-examen-edit" placeholder="Escriba la pregunta" class="form-control form-control-sm input-preg-resp-edit">
                                       </div>
                                    </div>
                                    <div>Respuestas</div>
                                    <br>
                                    <!-- RESPUESTA A -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio1-edit" name="customRadio1" class="custom-control-input radio-pregunta-edit radio-in" data-correcta="1">
                                             <label class="custom-control-label" for="customRadio1-edit"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta1-edit" id="respuesta-1" placeholder="Respuesta A" class="form-control form-control-sm input-preg-resp-edit">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA B -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio2-edit" name="customRadio2" class="custom-control-input radio-pregunta-edit radio-in" data-correcta="2">
                                             <label class="custom-control-label" for="customRadio2-edit"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta2-edit" id="respuesta-2" placeholder="Respuesta B" class="form-control form-control-sm input-preg-resp-edit">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA C -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio3-edit" name="customRadio3" class="custom-control-input radio-pregunta-edit radio-in" data-correcta="3">
                                             <label class="custom-control-label" for="customRadio3-edit"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta3-edit" id="respuesta-3" placeholder="Respuesta C" class="form-control form-control-sm input-preg-resp-edit">
                                       </div>
                                    </div>
                                    <!-- RESPUESTA D -->
                                    <div class="form-row">
                                       <div class="form-group col-lg-1">
                                          <div class="custom-control custom-radio">
                                             <input type="radio" id="customRadio4-edit" name="customRadio4" class="custom-control-input radio-pregunta-edit radio-in" data-correcta="4">
                                             <label class="custom-control-label" for="customRadio4-edit"></label>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-11">
                                          <input type="text" name="respuesta4-edit" id="respuesta-4" placeholder="Respuesta D" class="form-control form-control-sm input-preg-resp-edit">
                                       </div>
                                    </div>

                                    <div class="alert alert-primary mt-3 d-none" role="alert" id="alerta-pregunta-edit">
                                       <p class="m-0"> ¡<b>PREGUNTA ACTUALIZADA:</b> se han realizado los cambios con
                                          éxito!</p>
                                    </div>

                                    <div class="form-row">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" class="col-lg-4 offset-lg-8 btn btn-success btn-md"><i class="fas fa-check"></i>Terminar Edición</button>
                                    </div>

                                 </form>
                              </div>
                           </div>

                        </div>


                        <!-- AÑADIR TAREA -->
                        <div class="card bg-light shadow">
                           <div class="card-header" id="headingThree">
                              <h2 class="mb-0 text-center">

                                 <div class="row">
                                    <div class="col-md-4"> <button id="aniadir-tarea" class="btn btn-link collapsed disabled" type="button" data-toggle="collapse" data-target="#collapseTarea" aria-expanded="false" aria-controls="collapseTarea">
                                          <h5 class="text-success"><i class="fas fa-plus-circle"></i> Añadir Tarea</h5>
                                       </button>
                                    </div>
                                    <div class="col-md-4"> <button id="editar-tarea" class="btn btn-link collapsed disabled" type="button" data-toggle="collapse" data-target="#collapseTareaEdit" aria-expanded="false" aria-controls="collapseTareaEdit">
                                          <h5 class="text-success"><i class="fas fa-edit"></i> Editar Tarea</h5>
                                       </button>
                                    </div>
                                    <div class="col-md-4"> <button id="ver-tareas" class="btn btn-link collapsed disabled" type="button" data-target="#tabla-contenido">
                                          <h5 class="text-success"><i class="fas fa-eye"></i> Ver Tarea</h5>
                                       </button>
                                    </div>
                                 </div>

                              </h2>
                           </div>
                           <div id="collapseTarea" class="collapse" aria-labelledby="headingThree" data-parent="#accordionContenido">
                              <div class="card-body">

                                 <form id="registrar-tarea">

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <input type="text" name="nombre-tarea" id="nombre-tarea" placeholder="Nombre de la Tarea" class="input-tarea form-control form-control-sm">
                                       </div>
                                    </div>

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <textarea class="input-tarea form-control form-control-sm" placeholder="Descripción de la Tarea" name="descripcion-tarea"></textarea>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <div class="custom-file">
                                          <input type="file" class="input-tarea custom-file-input" id="archivo-tarea" name="archivo-tarea">
                                          <label id="archivo-tarea-name" class="custom-file-label" for="customFile">Seleccionar Archivo</label>
                                       </div>
                                    </div>

                                    <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-tarea">
                                       <p class="m-0"> <b>¡TAREA REGISTRADA:</b> se ha añadido la tarea al bloque!</p>
                                    </div>

                                    <div class="form-row">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" class="col-lg-4 offset-lg-8 btn btn-success btn-md">Añadir</button>
                                    </div>

                                 </form>
                              </div>
                           </div>

                           <!-- EDITAR TAREA -->
                           <div id="collapseTareaEdit" class="collapse" aria-labelledby="headingThree" data-parent="#accordionContenido">
                              <div class="card-body">

                                 <form id="editar-tarea-form">

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <label>Nombre de la tarea</label><input type="text" name="nombre-tarea-edit" id="nombre-tarea-edit" placeholder="Nombre de la Tarea" class="input-tarea-edit form-control form-control-sm">
                                       </div>
                                    </div>

                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <label>Descripción de la tarea</label><textarea class="input-tarea-edit form-control form-control-sm" placeholder="Descripción de la Tarea" name="descripcion-tarea-edit"></textarea>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label>Archivo de tarea</label>
                                       <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="archivo-tarea" name="archivo-tarea-edit">
                                          <label id="archivo-tarea-name" class="custom-file-label" for="customFile">
                                             Cambiar Archivo</label>
                                       </div>
                                    </div>

                                    <div class="alert alert-success mt-3 d-none" role="alert" id="alerta-tarea-edit">
                                       <p class="m-0"> <b>¡TAREA ACTUALIZADA:</b> se han realizado los cambios con
                                          éxito!</p>
                                    </div>

                                    <div class="form-row">
                                       <div class="col-lg-2 text-center">
                                          <div class="spinner-border text-primary d-none" role="status">
                                             <span class="sr-only">Loading...</span>
                                          </div>
                                       </div>

                                       <button type="submit" class="col-lg-4 offset-lg-8 btn btn-primary btn-md"><i class="fas fa-check"></i> Terminar Edición</button>
                                    </div>

                                 </form>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>

               <div class="alert alert-primary mt-3 d-none alerta-elim" role="alert"></div>
               <div class="alert alert-danger mt-3 d-none alerta-error" role="alert"></div>

               <h2 class="titulo-tablas mt-5"></h2>

               <table class="table my-5 w-100 shadow" id="tabla-contenido">
                  <thead class="bg-success">
                     <tr id="tr-tablagrupo2">

                     </tr>
                  </thead>
                  <tbody id="tbodygrupo2">

                  </tbody>
               </table>
            </div>



            <!-- ESTADÍSTICAS TAB -->
            <div class="tab-pane fade" id="v-pills-estadisticas" role="tabpanel" aria-labelledby="estadisticas-tab">
               <h1>ESTADISTICAS</h1>
            </div>

            <!-- AYUDA -->
            <div class="tab-pane fade" id="v-pills-ayuda" role="tabpanel" aria-labelledby="ayuda-tab">
               <h1>AYUDA</h1>
            </div>
         </div>




      </div>
   </div>


   <i id="ir-arriba" class="fas fa-arrow-alt-circle-up fixed-bottom "></i>


   <!--JAVASCRIPT BOOTSTRAP 4-->
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
   </script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
   </script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
   </script>
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   <!-- jQUERY -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <!-- sweet alert -->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   

   <!-- LOCAL SCRIPTS -->
   <script src="../js/dashboard_profesor.js"></script>

</body>

</html>