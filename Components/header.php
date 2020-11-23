<!-- #header -->
<header id="header">
  <?php if($pagina == "mainpage"){ ?>
  <div>
  <?php }else { ?>
      <div class="header-top">
    <?php } ?>
    <div class="container-fluid main-menu">
      <div class="row justify-content-between">
        <div id="logo" class="col-lg-4 d-none d-lg-block mr-auto">
          <a href="mainpage.php"><img id="logo-imagen" src="../img/uniline3.png" width="25%" alt="uniline" /></a>
        </div>
        <div class="float-right">
          <nav id="nav-menu-container">
            <ul class="nav-menu">
              <?php
              if (isset($_SESSION['acceso'])) {
              ?>
              <?php
                  if (($_SESSION['tipo']) == 'Maestro') {
                ?>
                <li class="mt-3"><a class="text-center" href="mainpage.php#home-banner" style="font-size: 14px; text-decoration: none;" >Home</a></li>
                <li class="mt-3"><a class="text-center" href="dashboard_profesor.php" style="font-size: 14px; text-decoration: none;">Cursos Impartidos</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#all-cursos" style="font-size: 14px; text-decoration: none;">Cursos disponibles</a></li>
                <li class="mt-3"><a class="text-center" href="misCursos.php" style="font-size: 14px; text-decoration: none;">Mis cursos</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#home-contacto" style="font-size: 14px; text-decoration: none;">Contacto</a></li>
                <a role="button" class="dropdown-toggle d-flex justify-content-center" data-toggle="dropdown">
                  <?php
                  $url = "";
                  if ($_SESSION['imagen_perfil'] != "../img/perfil.png") {
                    $exlpode = explode("/", $_SESSION['imagen_perfil']);
                    $url = "../" . $exlpode[1] . "/min_" . $exlpode[2];
                  } else {
                    $url = $_SESSION['imagen_perfil'];
                  }
                  ?>
                  <img src=<?php echo $url ?> alt="perfil" class="course_author_image">
                </a>
                <div id="drop" class="dropdown-menu opciones-perfil">
                  <li><a class="enlaces-perfil" href="editProfile.php">Mi perfil</a></li>
                  <li><a class="enlaces-perfil" href="../controllers/sesion-destroy.php?cerrar=true">Cerrar sesión</a></li>
                </div>
              <?php
                }else {
              ?>
                <li class="mt-3"><a class="text-center" href="mainpage.php#home-banner" style="font-size: 14px; text-decoration: none;" >Home</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#all-cursos" style="font-size: 14px; text-decoration: none;">Cursos disponibles</a></li>
                <li class="mt-3"><a class="text-center" href="misCursos.php" style="font-size: 14px; text-decoration: none;">Mis cursos</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#home-contacto" style="font-size: 14px; text-decoration: none;">Contacto</a></li>
                <a role="button" class="dropdown-toggle d-flex justify-content-center" data-toggle="dropdown">
                  <?php
                  $url = "";
                  if ($_SESSION['imagen_perfil'] != "../img/perfil.png") {
                    $exlpode = explode("/", $_SESSION['imagen_perfil']);
                    $url = "../" . $exlpode[1] . "/min_" . $exlpode[2];
                  } else {
                    $url = $_SESSION['imagen_perfil'];
                  }
                  ?>
                  <img src=<?php echo $url ?> alt="perfil" class="course_author_image">
                </a>
                <div id="drop" class="dropdown-menu opciones-perfil">
                  <li><a class="enlaces-perfil" href="editProfile.php">Mi perfil</a></li>
                  <li><a class="enlaces-perfil" href="../controllers/sesion-destroy.php?cerrar=true">Cerrar sesión</a></li>
                </div>
                <?php
                }
              ?>
              <?php
              } else {
              ?>
                <li class="mt-3"><a class="text-center" href="mainpage.php" style="font-size: 14px; text-decoration: none;">Inicio</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#all-cursos" style="font-size: 14px; text-decoration: none;">Cursos disponibles</a></li>
                <li class="mt-3"><a id="registro-user" data-toggle="modal" class="text-center" data-target="#modal-registro" href="#" style="font-size: 14px; text-decoration: none;">Regístrate</a></li>
                <li class="mt-3"><a class="text-center" href="mainpage.php#home-contacto" style="font-size: 14px; text-decoration: none;">Contacto</a></li>
                <li class="mt-3"><a class="text-center" id="autobtn" style="font-size: 14px; text-decoration: none; color:rgb(255, 94, 0)" data-toggle="modal" href=".login">Iniciar sesión</a></li>
              <?php
              }
              ?>
            </ul>
          </nav><!-- #nav-menu-container -->
        </div>
      </div>
    </div>
  </div>
</header><!-- #header -->

<!-- Start Registro Area -->
<div class="modal fade" id="modal-registro">
    <div class="modal-dialog modal-login">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Regístrate y obtén acceso a los cursos</h4>
          <button type="button" class="fas fa-times close" style="font-size: 30px;" data-dismiss="modal"></button>
        </div>
        <div class="modal-body row justify-content-center align-items-center">
          <div class="col-lg-12 col-md-7 search-course-right" id="reg1">

            <form class="form-wrap" id="registro" method="post">
              <div class="form-group">
                <i class="fa fa-at"></i>
                <input type="email" id="registrar-correo" class="form-control text-dark" name="TEmail" placeholder="E-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Correo'">
              </div>
              <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" id="registrar-pass" class="form-control text-dark" name="TPass" placeholder="Constraseña" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Contraseña'">
              </div>
              <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="registrar-nombre" class="form-control text-dark" name="TNombre" placeholder="Nombre" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Nombre'">
              </div>
              <div class="form-group">
                <i class="fa fa-phone"></i>
                <input type="phone" id="registrar-tel" class="form-control text-dark" name="TTelefono" placeholder="Telefono (Opcional)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu telefono'">
              </div>
              <button id="btnSubmit" class="btn-primary" style="width: 100%; height: 50px;" type="submit" name="submit">
                Registrar
                <div id="hope" class="spinner-border ml-5 d-none" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </button>

            </form>
            <br>
            <div id="alertas" class="alert alert-success text-center" style="width:100%; display: none;"></div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- End Registro Area -->

  <!-- LOGIN -->

  <div class="login modal fade" id="login">
    <div class="modal-dialog modal-login">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Iniciar Sesión</h4>
          <button type="button" class="fas fa-times close" style="font-size: 30px;" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="alerta-login"></div>
        <div class="modal-body">
          <form method="post" id="myLogin">
            <div class="form-group">
              <i class="fa fa-user"></i>
              <input name="TEmail" type="text" class="form-control" id="ingresar-email" placeholder="Correo electrónico" required="required">
            </div>
            <div class="form-group">
              <i class="fa fa-lock"></i>
              <input name="TPassword" type="password" class="form-control" id="ingresar-password" placeholder="Contraseña" required="required">
            </div>
            <div class="form-group">
              <input type="submit" class="btn-primary btn-block btn-lg" value="Entrar">
            </div>
          </form>

          <!-- Register -->
          <p class="extra-options">¿No tienes cuenta?
            <a id="ir-a-registro" data-toggle="modal" class="text-center" data-target="#modal-registro" href="#">Regístrate</a>
          </p>
          <p class="extra-options">
            ¿Olvidaste tu contraseña?
            <a id="show-pass-reset" data-toggle="modal" class="text-center" style="cursor:pointer">Clic aquí</a>
          </p>

          <!-- Reset password -->
          <div id="reset-pass-div">
            <hr />
            <form id="resetForm">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon addon-ico">
                    <p><i class="fas fa-envelope"></i></p>
                  </span>
                  <input id="ingresar-email2" name="emailForReset" type="text" class="form-control reset-pass" placeholder="Ingresa tu correo">
                  <div class="input-group-btn">
                    <button id="resetPassBtn" class="btn btn-primary reset-pass-btn">

                      &nbsp;&nbsp;<i id="arrow" class="fas fa-arrow-right ml-0"></i>&nbsp;&nbsp;


                      <div id="spiner-reset" class="spinner-border text-light  d-none" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </form>
            <h5 id="hint">Te enviaremos un correo con los pasos para recuperar tu contraseña.</h6>
              <div id="alertas-reset-email" class="alert alert-danger d-none" role="alert">
              </div>
          </div>

        </div>
      </div>
    </div>
  </div>