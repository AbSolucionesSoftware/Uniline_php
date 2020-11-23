$(document).ready(function () {

  $('#myLogin').submit(function (e) {
    if ($('#ingresar-email').val() == '' || $('#ingresar-password').val() == '') {
      $('.alerta-login').html('<h2 class="alert alert-danger">*Llene todos los campos</h2>')
    } else {
      $.ajax({
        url: "../controllers/login.php",
        type: "POST",
        data: $('#myLogin').serialize(),

        success: function (response) {
          if (response != 'ceo') {
            console.log(response);
            switch (response) {
              case "1":
                window.location.replace('../views/misCursos.php');
                break;
              case "2":
                window.location.replace('../views/dashboard_profesor.php');
                break;
              case "NoVerificado":
                $('.alerta-login').html('<h2 class="alert alert-danger">*Cuenta no verificada</h2>');
                break;
              case "passwordIncorrecta":
                $('.alerta-login').html('<h2 class="alert alert-danger">*Contraseña incorrecta</h2>');
                break;
              default:
                $('.alerta-login').html('<h2 class="alert alert-danger">*Este correo no esta registrado</h2>');
                break;
            }
          } else {
            window.location.replace('../views/registro.php');
          }
        }
      });
      e.preventDefault();
    }
  });
  /*Password Reset AJAX*/
  $("#show-pass-reset").click(function (e) {
    $("#reset-pass-div").slideToggle();
  });

  $("#resetForm").submit(function (e) {
    $("#spiner-reset").removeClass("d-none");
    $("#arrow").addClass("d-none");
    e.preventDefault();
    if ($('#ingresar-email2').val() == '') {
      $("#arrow").removeClass("d-none");
      $("#spiner-reset").addClass("d-none");
      alert('debes ingresar algún correo electronico');
    } else {
      $.ajax({
        url: "../controllers/reset_pass.php",
        type: "POST",
        data: "emailForReset=" + $('#ingresar-email2').val(),

        success: function (response) {
          $("#arrow").removeClass("d-none");
          $("#spiner-reset").addClass("d-none");
          $("#alertas-reset-email").removeClass("d-none");
          switch (response) {
            case 'mail_noExiste':
              $('#alertas-reset-email').html('<h4>Este correo no exicte</h4>');
              break;
            default:
              $('#alertas-reset-email').removeClass("alert-danger").addClass("alert-success");
              $('#alertas-reset-email').html('<h4>Correo enviado exitosamente</h4>');
              break;
          }
        }
      });
    }
  });

});
