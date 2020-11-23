<?php
session_start();
include '../controllers/sesion.php';
$pagina = "general";
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="../img/fav.png">
  <meta name="author" content="ABsoluciones">
  <meta name="description" content="Edita tu perfil de UNILINE!">
  <meta charset="UTF-8">

  <title>Escuela Al Revés</title>

  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/main_styles.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/stylo.css">
  <link rel="stylesheet" href="../css/icons/all.css">
  <link rel="stylesheet" href="../css/stylo-responsive-editPerfil.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>
<div id="alertas" class="alert alert-danger fixed-top text-center" style="max-height:54px; display: none;">
          </div>
  <!-- #header -->
  <?php include "../Components/header.php"; ?>
  <!-- #header -->

  <!-- Editar perfil -->
  <form class="form-wrap" id="actualizar-perfil">
    <div class="page_section">
      <div class="container">
        <div class="row justify-content-center">

          <!-- Editar foto de perfil -->
          <div class="col-lg-3 course_box load-picture">
            <div class="card">
              <div id="preview">
              </div>
              <div id="preview-final">
                <?php
                $url = "";
                if ($_SESSION['imagen_perfil'] != "../img/perfil.png") {
                  $exlpode = explode("/", $_SESSION['imagen_perfil']);
                  $url_2 = "../" . $exlpode[1] . "/res_" . $exlpode[2];
                } else {
                  $url_2 = $_SESSION['imagen_perfil'];
                }
                ?>
                <img id="FotoPerfil" class="rounded-circle" width="260" height="260" src=<?php echo $url_2; ?> alt="foto de perfil">
              </div>
              <div id="cargaFoto" class="custom-file">
                <input type="file" name="Fimagen" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label h5" for="inputGroupFile01">Editar foto de perfil</label>
              </div>
            </div>
          </div>

          
          <!-- Popular Course Item -->
          <div class="col-lg-5 course_box">
            <div class="form">
              <div>
                <div class="input-group m-1">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" id="registrar-nombre2" class="form-control text-success" name="TNombre" placeholder="Nombre" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Nombre'">
                </div>
                <div class="input-group m-1">
                  <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                  <input type="phone" id="registrar-tel2" class="form-control text-success" name="TTelefono" placeholder="Telefono" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu telefono'">
                </div>
                <div class="input-group m-1">
                  <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                  <input type="email" id="registrar-correo2" class="form-control text-success" name="TEmail" placeholder="E-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Correo'">
                </div>
                <div class="input-group m-1">
                  <span class="input-group-addon"><i class="fas fa-sort-numeric-up-alt"></i></span>
                  <input type="text" id="registrar-edad" class="form-control text-success" name="TEdad" placeholder="Edad" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu edad'">
                </div>
                <select id="registrar-grado" name="TGrado" class="form-control m-1" style="height: 35px!important">
                  <option value="">Selecciona grado de estudios</option>
                  <option value="Secundaria">Secundaria</option>
                  <option value="Bachillerato">Bachillerato</option>
                  <option value="Universidad">Universidad</option>
                  <option value="Superior">Superior</option>
                </select>
                <select id="registrar-estado" name="TEstado" class="form-control m-1" style="height: 35px!important">
                </select>
                <div class="input-group m-1">
                  <span class="input-group-addon"><i class="fas fa-flag"></i></span>
                  <input type="text" id="registrar-municipio" class="form-control text-success" name="TMunicipio" placeholder="Municipio" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu municipio'">
                </div>
                <select id="verifi-trabajo" class="form-control m-1" style="height: 35px!important">
                  <option value="">Trabajo</option>
                  <option value="1">Si</option>
                </select>
                <div class="show-date" style="display: none;">
                  <div class="input-group m-1">
                    <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                    <input type="text" id="registrar-puesto" class="form-control text-success" name="TPuesto" placeholder="Puesto de trabajo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Puesto de trabajo'">
                  </div>
                  <div class="input-group m-1">
                    <span class="input-group-addon"><i class="fas fa-address-book"></i></span>
                    <input type="text" id="registrar-Descripcion" class="form-control text-success" name="TDescripcion" placeholder="Descripcion del Trabajo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Descripcion del Trabajo'">
                  </div>
                </div>
                <p id="mostrarPass" class="h4 text-center" style="cursor: pointer;">Si deseas cambiar tu contraseña haz clic aqui</p>
                <div id="cambiarPass" class="ocultar text-center" style="display: none">
                  <p>Ingresa tu contrasena actual para poder editar la contrasena</p>
                  <div class="input-group m-1">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" id="registrar-pass2" class="form-control text-success" name="TPass" placeholder=" Tu constraseña actual" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu Contraseña actual'">
                  </div>
                  <div class="input-group m-1">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" id="registrar-passNew" class="form-control text-success" disabled name="TPassNew" placeholder="Tu nueva constraseña" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu nueva Contraseña'">
                  </div>
                  <div class="alert alerta-pass" role="alert" style="display: none;">
                  </div>
                </div>

                <button id="actualizar" class="btn-primary primary-btn text-uppercase btn-sm-block" type="submit" name="submit">Guardar cambios</button>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <br>
  <br>

<!--   <script src="../js/jquery.js"></script> -->
  <script src="../js/jquery-3.2.1.min.js"></script>
  <!-- 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <script src="../js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/vendor/bootstrap.min.js"></script>
<!--   <script src="../js/easing.min.js"></script> -->
  <script src="../js/superfish.min.js"></script>
<!--   <script src="../js/jquery.ajaxchimp.min.js"></script> -->
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/main.js"></script>
  <script src="../js/actualizar-perfil.js"></script>

</body>

<!-- start footer Area -->
<?php include "../Components/footer.php"; ?>
<!-- End footer Area -->

</html>