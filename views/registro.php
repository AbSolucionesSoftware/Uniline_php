<?php
include '../controllers/sessionCEO.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    

</head>

<body>

    <div class="cont">
        <div class="contenedor-registro">
            <h2>Registro a la Base de Datos</h2>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Profesores</a></li>
                        <li><a data-toggle="tab" href="#menu1">Cursos</a></li>
                        <li><a data-toggle="tab" href="#mas">Contenido del curso</a></li>
                        <li><a data-toggle="tab" href="#cupones">Cupones</a></li>
                        <li class="col-2" style="margin-right: -2rem;">
                            <select id="select-profe-tema" name="SProfesor" class="form-control m-1" style="height: 35px!important">
                                <option value="0">Selecciona profesor</option>
                            </select>
                        </li>
                        <li class="col-2" style="margin-right: 2rem;">
                            <select id="select-curso" name="SCurso" class="form-control m-1" style="height: 35px!important; width: 20rem; margin-left: 1rem;">
                                <option value="0">Selecciona un curso</option>
                            </select>
                        </li>
                        <li class="col-2" style="margin-right: 4rem;">
                            <select id="select-bloque" name="SBloque" class="form-control m-1" style="height: 35px!important; width: 20rem; margin-left: 1rem;">
                                <option value="0">Selecciona bloque</option>
                            </select>
                        </li>
                        <li><a class="bg-primary" href="../controllers/sesion-destroy.php?cerrar=true">Cerrar sesión</a></li>

                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div id="cupones" class="tab-pane fade">
                    <div class="container d-lg-flex d-block">
                        <div class="col-lg-3 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-group" id="FCupones">
                                        <input name="INCupones" class="form-control mt-3" type="number" placeholder="Cupones" min="1" id="cupones-input">
                                        <select name="SCurso" class="form-control mt-2" id="curso">
                                        </select>
                                        <button class="btn btn-primary btn-block mt-2" type="submit">Generar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 mt-4">
                            <div class="input-group mb-2">
                                <input class="form-control" type="search" id="buscador">
                            </div>
                            <table class="table table-borderless table-responsive-md table-hover">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Canjeo</th>
                                        <th>Curso</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="cuerpotabla">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="mas" class="tab-pane fade">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li><a data-toggle="tab" href="#menu2">Bloques</a></li>
                            <li><a data-toggle="tab" href="#menu3">Temas</a></li>
                            <li><a data-toggle="tab" href="#menu4">Examen</a></li>
                            <li><a data-toggle="tab" href="#menu5">Preguntas examen</a></li>
                            <li><a data-toggle="tab" href="#menu6">Tareas</a></li>
                        </ul>

                    </div>
                    <div class="tab-content">
                        <div id="menu2" class="tab-pane fade">
                            <!-- REGISTRO DE BLOQUES -->
                            <h3 style="margin-left: 1rem;">Registro de Bloques</h3>
                            <hr>
                            <div class="form col-lg-5">
                                <form class="form-wrap" id="registro-bloques">
                                    <input type="text" id="nombre-bloque" class="form-control inden-bloque" name="TBloques" placeholder="Nombre del Bloque">
                                    <br>
                                    <button id="btn-bloque" class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Añadir</button>
                                    <div class="spinner-border text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </form>
                            </div>
                            <div class="form col-lg-7">
                                <table id="tabla-bloques" class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Curso</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos-bloque">
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <!-- REGISTRO DE TEMAS -->
                            <h3>Registro de Temas</h3>
                            <hr>
                            <div class="form col-lg-5">
                                <form class="form-wrap" id="registro-temas">
                                    <input id="accion-tema" type="hidden" value="insertar" name="accion">
                                    <input id='idtema' type="hidden" value="" name="idtema">
                                    <input type="text" id="nombre-tema" class="form-control inden-tema" name="TNombre" placeholder="Nombre del tema">
                                    <textarea rows="5" cols="50" id="descripcion-tema" class="form-control inden-tema" name="TADescripcion" placeholder="Descripcion del tema"></textarea>
                                    <input type="text" id="video-tema" class="form-control inden-tema" name="TVideo" placeholder="URL video"></<input>
                                    <div>Archivo *opcional<input type="file" id="archivo-tema" class="form-control" name="FArchivo"></div>
                                    <br>
                                    <button id="btn-tema" class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Añadir tema</button>
                                    <div class="spinner-border text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </form>
                            </div>
                            <div class="form col-lg-7">
                                <table class="table" id="tabla-temas">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Video</th>
                                            <th scope="col">Archivo</th>
                                            <th><button id="btnorden" class="btn btn-primary" disabled>Cambiar orden</button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos-tema">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="menu4" class="tab-pane fade">
                            <!-- REGISTRO DE EXAMENES -->
                            <h3>Registro de Examenes</h3>
                            <hr>
                            <div class="form col-lg-5">
                                <form class="form-wrap" id="registro-examen">
                                    <input type="text" id="nombre-examen" class="form-control inden-examen" name="TNombre" placeholder="escribe el nombre del examen">
                                    <textarea rows="5" cols="50" id="descripcion-examen" class="form-control inden-examen" name="TADescripcion" placeholder="escribe una descripcion de este examen"></textarea>
                                    <br>
                                    <button id="btn-examen" class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Enviar datos</button>
                                    <div class="spinner-border text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </form>
                                <hr>
                            </div>
                            <div class="form col-lg-7">
                                <table class="table" id="tabla-examen">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos-examen">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="menu5" class="tab-pane fade">
                            <!-- REGISTRO DE PREGUNTAS EXAMENEN -->
                            <h3>Registro de preguntas</h3>
                            <h2 id="labelexamen">
                            </h2>
                            <hr>
                            <div class="form col-lg-5">
                                <form class="form-wrap" id="registro-preguntas">
                                    <hr>
                                    <p>Escribe la pregunta y selecciona cual de tus respuestas es la correcta</p>
                                    <div class="col-lg-6">
                                        <input type="text" id="pregunta" class="form-control inden-preguntas" name="TPregunta" placeholder="pregunta"> <br>

                                        <div>
                                            <input class="radio-in radio-preguntas" type="radio" id="resp1" name="TCorrecta" data-correcta="1">
                                            <label><input type="text" id="respuesta1" class="form-control inden-preguntas" name="TRespuesta" placeholder="respuesta 1"></label>
                                        </div>
                                        <div>
                                            <input class="radio-in radio-preguntas" type="radio" id="resp2" name="TCorrecta" data-correcta="2">
                                            <label><input type="text" id="respuesta2" class="form-control inden-preguntas" name="TRespuesta" placeholder="respuesta 2"></label>
                                        </div>
                                        <div>
                                            <input class="radio-in radio-preguntas" type="radio" id="resp3" name="TCorrecta" data-correcta="3">
                                            <label><input type="text" id="respuesta3" class="form-control inden-preguntas" name="TRespuesta" placeholder="respuesta 3"></label>
                                        </div>
                                        <div>
                                            <input class="radio-in radio-preguntas" type="radio" id="resp4" name="TCorrecta" data-correcta="4">
                                            <label><input type="text" id="respuesta4" class="form-control inden-preguntas" name="TRespuesta" placeholder="respuesta 4"></label>
                                        </div>
                                        <button class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Registrar</button>
                                        <div class="spinner-border text-primary d-none" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            </div>
                            <div class="form col-lg-7">
                                <table class="table" id="tabla-preguntas">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Pregunta</th>
                                            <th scope="col">Respuestas</th>
                                            <th scope="col">valor respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos-preguntas">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="menu6" class="tab-pane fade">
                            <!-- REGISTRO DE TAREAS -->
                            <h3>Registro de tareas</h3>
                            <hr>
                            <div class="form col-lg-5">

                                <form class="form-wrap" id="registro-tarea">
                                    <input id="accion-tarea" type="hidden" value="insertar" name="accion">
                                    <input id="idtarea" type="hidden" value="" name="idtarea">
                                    <input type="text" id="nombre-tarea" class="form-control inden-tareas" name="TNombre" placeholder="Tarea">
                                    <textarea rows="5" cols="50" id="descripcion-tarea" class="form-control inden-tareas" name="TADescripcion" placeholder="Descripcion de la tarea"></textarea>
                                    <div>archivo<input type="file" id="archivo-tarea" class="form-control inden-tareas" name="FArchivo"></div>
                                    <button class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Registrar</button>
                                    <div class="spinner-border text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </form>
                                <hr>
                            </div>
                            <div class="form col-lg-7">
                                <table class="table" id="tabla-tareas">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">archivo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos-tarea">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="home" class="tab-pane fade in active">
                    <!-- REGISTRO DE PROFESORES -->
                    <h3>Registro de Profesores</h3>
                    <hr>
                    <div class="form col-lg-3 col-md-6">
                        <form class="form-wrap" id="registro-profesor">
                            <div class="imagen flex">
                                <div id="preview" class="text-center">

                                </div>
                                <div id="preview-final" class="text-center">
                                    <img id="foto-perfil" class="rounded-circle" width="200" height="200" src="../img/perfil.png" alt="foto de profesor">
                                </div>
                                <input type="file" name="Fimagen" class="inden-profesores" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            </div>
                            <input type="text" id="registrar-nombre" class="form-control inden-profesores" name="TNombre" placeholder="Nombre">
                            <input type="text" id="registrar-edad" class="form-control inden-profesores" name="TEdad" placeholder="Edad">
                            <select id="registrar-grado" name="TGrado" class="form-control inden-profesores" style="height: 35px!important">
                                <option value="">Selecciona grado de estudios</option>
                                <option value="Secundaria">Secundaria</option>
                                <option value="Bachillerato">Bachillerato</option>
                                <option value="Universidad">Universidad</option>
                                <option value="Superior">Superior</option>
                            </select>
                            <input type="phone" id="registrar-tel" class="form-control inden-profesores" name="TTelefono" placeholder="Telefono">
                            <input type="email" id="registrar-email" class="form-control inden-profesores" name="TEmail" placeholder="Email">
                            <input type="password" id="registrar-pass" class="form-control inden-profesores" name="TPass" placeholder="Password">
                            <select id="registrar-estado2" name="TEstado" class="form-control inden-profesores" style="height: 35px!important">
                            </select>
                            <input type="text" id="registrar-municipio" class="form-control inden-profesores" name="TMunicipio" placeholder="Municipio">
                            <input type="text" id="registrar-profesion" class="form-control inden-profesores" name="TProfesion" placeholder="Profesion">
                            <br>
                            <button class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Registrar</button>
                            <div class="spinner-border text-primary d-none" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>

                    </div>
                    <div class="form col-lg-9">
                        <table id="tabla-profesores" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Escolaridad</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Municipio</th>
                                    <th scope="col">Trabajo</th>
                                </tr>
                            </thead>
                            <tbody id="datos-profesores">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <!-- REGISTRO DE CURSOS -->
                    <h3>Registro de Cursos</h3>
                    <hr>
                    <div class="form col-lg-3">
                        <form class="form-wrap" id="registro-curso">
                            <input type="hidden" id="idcurso" name="idcurso" value="">
                            <input type="hidden" id="accion" name="accion" value="insertar">
                            <div class="imagen flex">
                                <div id="preview2" class="text-center">

                                </div>
                                <div id="preview-final2" class="text-center">
                                    <img id="foto-curso" width="200" height="200" src="../img/anadir.png" alt="foto de profesor">
                                </div>
                                <input type="file" name="Fimagen" class="inden-curso" id="inputGroupFile02" aria-describedby="inputGroupFileAddon01">
                            </div>
                            <input type="text" id="nombre-curso" class="form-control inden-curso" name="TNombre" placeholder="Nombre del curso">
                            <textarea rows="5" cols="50" id="descripcion-curso" class="form-control inden-curso" name="TADescripcion" placeholder="Descripcion del curso"></textarea>
                            <input type="text" id="horas-curso" class="form-control inden-curso" name="THoras" placeholder="Horas del curso">
                            <input type="text" id="costo-curso" class="form-control inden-curso" name="TCosto" placeholder="Costo del curso">
                            <br>
                            <input type="text" id="video-curso" class="form-control inden-curso" name="TVideo" placeholder="URL video"></<input>
                            <br>
                            <button class="btn btn-primary primary-btn text-uppercase" type="submit" name="submit">Registrar</button>
                            <div class="spinner-border text-primary d-none" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
                    </div>
                    <div class="form col-lg-9">
                        <table id="tabla-cursos" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">URL Video</th>
                                    <th scope="col">Horas</th>
                                    <th scope="col">Calificacio</th>
                                    <th scope="col">Profesor</th>
                                    <th scope="col">Costo</th>
                                </tr>
                            </thead>
                            <tbody id="datos-cursos">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="../js/register3.js"></script>

</body>

</html>