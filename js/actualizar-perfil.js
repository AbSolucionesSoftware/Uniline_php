$(document).ready(function () {
    let id = '';
    datosUsuario();

    ///////////////////////Actualizar datos del Usuario //////////////////////////////
    $("#actualizar-perfil").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          url: "../controllers/actualizar-perfil.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          
          success: function (response) {
            $("#alertas").addClass('alert-danger');
            $("#alertas").removeClass('alert-success');
            
            if (response == "1") {
              $("#alertas").removeClass('alert-danger');
              $("#alertas").addClass('alert-success');
              $("#alertas").html('<i class="fas fa-check-circle m-2"></i>Registro Exitoso');
              $("#alertas").slideDown("slow");
              setTimeout(function(){
                $("#alertas").slideUp("slow");
              }, 1500);
              setTimeout(function(){
                location.reload();
              }, 2500);
              setTimeout(function(){
                $('#preview-final').show();
                $('#preview').hide();
              }, 2600);
            }else if(response == 'imagenNoValida'){
              $("#alertas").html('<i class="fas fa-images m-2"></i></i>Tipo de imagen no valido');
              $("#alertas").slideDown("slow");
              setTimeout(function(){
                $("#alertas").slideUp("slow");
              }, 2500);
            }else if(response == 'imagenGrande'){
              $("#alertas").html('<i class="fas fa-images m-2"></i></i>Imagen demaciado grande');
              $("#alertas").slideDown("slow");
              setTimeout(function(){
                $("#alertas").slideUp("slow");
              }, 2500);
            }
             else {
               console.log(response);
              $("#alertas").html('<i class="fas fa-exclamation-triangle m-2"></i>Ups, algo salio mal,Por favor intentalo de nuevo');
              $("#alertas").slideDown("slow");
              setTimeout(function(){
                $("#alertas").slideUp("slow");
              }, 2000);
            }
          }
        });
      });

    $("#mostrarPass").on( "click", function() {//mostrar cambio de contraseña
        $('#cambiarPass').slideToggle(500,"linear"); 
     });
/////////////////////// llevar datos al form //////////////////////////////

    function datosUsuario(){
        $.ajax({
            url: "../controllers/actualizar-perfil.php",
            type: "POST",
            data: 'datos=datos',

            success: function (response) {
                let datos = JSON.parse(response);
                console.log(datos);
                $('#numero').val(datos[0][0]);
                $('#registrar-nombre2').val(datos[0][1]);
                $('#registrar-tel2').val(datos[0][5]);
                $('#registrar-correo2').val(datos[0][6]);
                if(datos[0][2] != 0){
                  $('#registrar-edad').val(datos[0][2]);
                }else{
                  $('#registrar-edad').val("");
                }

                if(datos[0][3] != ""){
                  $('#registrar-grado').val(datos[0][3]);
                }else{
                  $('#registrar-grado').val("");
                }
                if(datos[0][4] != ""){
                  url = datos[0][4].split("/");
                  $('#FotoPerfil').attr('src',url[0]+"/"+url[1]+"/res_"+url[2]);
                }
                  $('#registrar-estado').val(datos[0][11]);
                  $('#registrar-municipio').val(datos[0][12]);
                if(datos[0][13] == null || datos[0][13] == ""){
                  $('#verifi-trabajo').val("");
                }else{
                  $('#verifi-trabajo').val("1");
                  separar = datos[0][13].split('###');
                  $('#registrar-puesto').val(separar[0]);
                  $('#registrar-Descripcion').val(separar[1]);
                  $('.show-date').slideDown("slow");
                }
                  
            }
        });
    }
    function cambiar(datos){

    }

    /////////////////////// Verificar si la contrasena es correcta //////////////////////////////
    $(document).on('keyup','#registrar-pass2',function(e){
      if($(this).val().length > 0){
        $.ajax({
          url: "../controllers/actualizar-perfil.php",
          type: "POST",
          data: "updatePass="+$(this).val(),

          success: function (response){
            $('.alerta-pass').slideDown("slow");
            if(response == "true"){
              $('.alerta-pass').removeClass('alert-danger');
              $('.alerta-pass').addClass('alert-success');
              $('.alerta-pass').html('<i class="fas fa-check-circle m-2"></i>Contrasena correcta, Puedes actualizar');
              $("#registrar-passNew").removeAttr('disabled');
            }else{
              $('.alerta-pass').addClass('alert-danger');
              $('.alerta-pass').removeClass('alert-success');
              $('.alerta-pass').html('<i class="fas fa-exclamation-triangle m-2"></i>Esta contrasena es incorrecta');
            }
          }
        });
      }else{
        $('.alerta-pass').slideUp("slow");
      }
    });

      $(document).on('change','#verifi-trabajo',function(){
          if($(this).val() == '1'){
            $('.show-date').slideDown("slow");
          }else{
            $('.show-date').slideUp("slow");
            $('#registrar-puesto').val("");
            $('#registrar-Descripcion').val("");
          }
      });

  });

  document.getElementById("inputGroupFile01").onchange = function(e) {
    // Creamos el objeto de la clase FileReader
    let reader = new FileReader();
  
    // Leemos el archivo subido y se lo pasamos a nuestro fileReader
    reader.readAsDataURL(e.target.files[0]);
  
    // Le decimos que cuando este listo ejecute el código interno
    reader.onload = function(){
      let preview = document.getElementById('preview'),
              image = document.createElement('img');
  
      image.src = reader.result;
      image.width = "260";
      image.height="260";
  
      preview.innerHTML = '';
      preview.append(image);
      $('#preview-final').hide();
      $('#preview img').addClass("rounded-circle");
    };
  }