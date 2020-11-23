$(document).ready(function () {
  let correcta = '';
  let idpregunta = '';
  let identificador_tablas;
  let nombre_tabla;
  let getid;
  // /* CARGA DE DATOS A LOS SELECT */


  // /* SELECT CURSOS */
  actualizarSelectCursos('#cursos-select');//CUANDO CARGUE LA PAGINA ACTUALIZARA EL SELECT CON TODOS LOS CURSOS DEL MAESTRO

  $(document).on('change', '#cursos-select', function () {
    $(this).removeClass('text-danger');
    actualizarSelectBloques(this.value);
    actualizarSelectTemas(0);
    editarTema(0);
    editarBloques(0);
    editarTarea(0);
    if (this.value != 0) {
      editarCurso(this.value);
      $(this).addClass('text-primary');
      $('#bloques-select').addClass('text-danger');
      $('#aniadir-bloque, #ver-bloques, #editar-curso').removeClass('disabled');
      $('#info-select-bloque').addClass('invisible');

    } else {

      $(this, '#bloques-select').addClass('text-danger');
      $('#info-select-bloque').removeClass('invisible');
      $('#aniadir-bloque, #aniadir-examen, #ver-bloques, #editar-curso').addClass('disabled');
      $('#aniadir-bloque, #aniadir-examen, #collapseEditCurso, #collapseBloque, #collapseExamen').collapse('hide');
      $('#collapseEditCurso, #collapseBloque, #collapseExamen').removeClass('show in');
    }
  });


  /* SELECT BLOQUES */
  $(document).on('change', '#bloques-select', function () {
    
    $(this).removeClass('text-danger');
    actualizarSelectTemas(this.value);
    actualizarSelectPreguntas(this.value);
    if (this.value != 0) {
      $(this).addClass('text-primary');
      editarBloques(this.value);
      editarExamen(this.value);
      editarTarea(this.value);
      $('#aniadir-examen, #aniadir-tema, #aniadir-tarea, #editar-bloque').removeClass('disabled');
    } else {
      $(this).addClass('text-danger');
      editarBloques(0);
    }
  });

  /* SELECT TEMAS */
  $(document).on('change', '#temas-select', function () {
    if (this.value != 0) {
      $('#editar-tema-form').removeClass('d-none');
      editarTema(this.value);
      $(this).removeClass('text-danger');
      $(this).addClass('text-primary');
    } else {
      $('#editar-tema-form').addClass('d-none');
      $(this).removeClass('text-primary');
      $(this).addClass('text-danger');
    }
  });

  /* SELECT PREGUNTAS */
  $(document).on('change', '#preguntas-select', function () {
    if (this.value != 0) {
      $('#editar-pregunta-form').removeClass('d-none');
      editarPregunta(this.value);
      $(this).removeClass('text-danger');
      $(this).addClass('text-primary');
    } else {
      $('#editar-tema-form').addClass('d-none');
      $(this).removeClass('text-primary');
      $(this).addClass('text-danger');
    }
  });

  /*FORMULARIOS: */

  /* ADD CURSO FORM */
  $("#registrar-curso").submit(function (e) {//INSERTAR CURSOS A LA BASE DE DATOS 
    e.preventDefault();
    if (verificar_campos('curso') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');
      var formData = new FormData(this);

      $.ajax({
        url: "../controllers/cursos_profesor.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (response) {
          if (response != 0) {
            renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');
            $('html, body').animate({
              scrollTop: $(document).height()
            }, 'slow');
            $("#alerta-nuevo-curso").removeClass("d-none");
            $('#registrar-curso').trigger('reset');
            $('#foto-curso').attr('src', '../img/cursos/no_course.png');
            document.getElementById('image-name-curso').innerHTML = 'Subir Imagen del Curso';
            actualizarSelectCursos('#cursos-select');//DESPUES DE REGISTRAR UN CURSO ACTUALIZA EL SELECT CON EL NUEVO CURSO AÑADIDO

            $('.spinner-border').addClass('d-none');
            $("#alerta-nuevo-curso").slideDown("slow");
            setTimeout(function () {
              $("#alerta-nuevo-curso").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
            $('.spinner-border').addClass('d-none');
          }
        }
      });
    }

  });

  $("#file-image-curso").change(function () {//CARGA LA VISTA PREVIA DEL INPUT FILE DE CURSOS
    leerUrl(this, '#foto-curso', '#image-name-curso');
  });

  ////////#################### previsualizar imagen antes de cargar (CURSOS)
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('.img').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  
  $(".imagen").change(function() {
    readURL(this);
  });

  $(document).on('click', '#nuevo-curso', function(){//#####restablece los campos de la imagen para que no se quede con la anterior
    /* $('#foto-curso').attr('src','../img/cursos/no_course.png') */
    /* $('#file-image-curso').val('') */

   /*  $('#archivo-default').html(`<input type="file" class="input-curso custom-file-input imagen" id="file-image-curso" name="imagen-curso">
    <label class="custom-file-label" for="file-image-curso" id="image-name-curso">Subir
       Imagen del
       Curso</label>`) */
  })


  /* EDIT-CURSO FORM */
  $("#editar-curso-form").submit(function (e) {//EDITAR CURSOS
    e.preventDefault();
    if (verificar_campos('curso-edit') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');
      var formData = new FormData(this);
      formData.append("editar", true);
      formData.append("id_curso", $('#cursos-select').val());

      $.ajax({
        url: "../controllers/cursos_profesor.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (response) {
          if (response != 0) {

            const old_select = $("#cursos-select").val();
            actualizarSelectCursos('#cursos-select');//DESPUES DE REGISTRAR UN CURSO ACTUALIZA EL SELECT CON EL NUEVO CURSO AÑADIDO
            renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');
            $('html, body').animate({
              scrollTop: $(document).height()
            }, 'slow');
            $("#alerta-curso-editado").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $("#alerta-curso-editado").slideDown("slow");
            setTimeout(function () {
              $("#alerta-curso-editado").slideUp("slow");
            }, 3000);

          } else {
            $(".alerta-error").removeClass("d-none");
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
            $('.spinner-border').addClass('d-none');
          }
        }
      });
    }

  });

  $("#file-image-edit-curso").change(function () {//CARGA LA VISTA PREVIA DEL INPUT FILE DE CURSOS
    leerUrl(this);
  });
  // //BLOQUES FORM

  $("#registrar-bloque").submit(function (e) {//INSERTAR BLOQUES A DB
    e.preventDefault();
    if (verificar_campos('bloque') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      // Get some values from elements on the page:
      var $form = $(this),
        bloque = $form.find("input[name='nombre-bloque']").val(),
        curso = $('#cursos-select').val(),
        url = "../controllers/bloques_profesor.php";
      if (curso) {

        $.post(url, { nombre_bloque: bloque, id_curso: curso })
          .done(function (data) {
            if (data) {
              const objeto_peticion = {
                tabla: "tabla_bloques",
                curso: $('#cursos-select').val()
              };
              renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
              $('#registrar-bloque').trigger('reset');
              $('.spinner-border').addClass('d-none');
              $("#alerta-bloque").removeClass("d-none");
              $("#alerta-bloque").slideDown("slow");
              actualizarSelectBloques(curso)//DESPUES DE REGISTRAR UN CURSO ACTUALIZA EL SELECT CON EL NUEVO bloque AÑADIDO
              $('#aniadir-examen, #aniadir-tema, #aniadir-pregunta, #aniadir-tarea').addClass('disabled');
              setTimeout(function () {
                $("#alerta-bloque").slideUp("slow");

              }, 3000);
            } else {
              $('.spinner-border').addClass('d-none');
              $(".alerta-error").removeClass("d-none");
              $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
              $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
            }
          })
      }

    }

  });

  //EDITAR BLOQUE FORM
  $("#editar-bloque-form").submit(function (e) {//INSERTAR BLOQUES A DB
    e.preventDefault();
    if (verificar_campos('bloque-edit') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      // Get some values from elements on the page:
      var $form = $(this),
        id_bloque = $('#bloques-select').val(),
        bloque = $form.find("input[name='nombre-bloque']").val(),
        curso = $('#cursos-select').val(),
        edit = true,
        url = "../controllers/bloques_profesor.php";
      if (curso) {

        $.post(url, { id_bloque: id_bloque, nombre_bloque: bloque, id_curso: curso, editar_bloque: edit })
          .done(function (data) {

            if (data) {
              const objeto_peticion = {
                tabla: "tabla_bloques",
                curso: $('#cursos-select').val()
              };
              renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
              $('#registrar-bloque').trigger('reset');
              $('.spinner-border').addClass('d-none');
              $("#alerta-bloque-edit").removeClass("d-none");
              $("#alerta-bloque-edit").slideDown("slow");
              actualizarSelectBloques(curso)//DESPUES DE REGISTRAR UN CURSO ACTUALIZA EL SELECT CON EL NUEVO bloque AÑADIDO
              setTimeout(function () {
                $("#alerta-bloque-edit").slideUp("slow");

              }, 3000);
            } else {
              $(".alerta-error").removeClass("d-none");
              $('.spinner-border').addClass('d-none');
              $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
              $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
            }
          });
      }

    }

  });

  //REGISTRAR EXAMEN
  $("#registrar-examen").submit(function (e) {//INSERTAR BLOQUES A DB
    e.preventDefault();
    if (verificar_campos('examen') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      // Get some values from elements on the page:
      var $form = $(this),
        nombre_examen = $form.find("input[name='nombre-examen']").val(),
        descripcion_examen = $form.find("textarea[name='descripcion-examen']").val(),
        bloque = bloque = $('#bloques-select').val(),
        url = "../controllers/examen_profesor.php";

      const objeto_peticion = {
        tabla: "tabla_examenes",
        bloque: $('#bloques-select').val()
      };

      $.post(url, {
        examen: nombre_examen,
        descripcion: descripcion_examen,
        nombre_bloque: bloque
      })
        .done(function (data) {
          if (data != 0) {
            const bloque = $('#bloques-select').val();
            editarExamen(bloque);
            renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
            $('#registrar-examen').trigger('reset');
            $('.spinner-border').addClass('d-none');
            $("#alerta-examen").removeClass("d-none");
            $("#alerta-examen").slideDown("slow");
            setTimeout(function () {
              $("#alerta-examen").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        });

    }

  });

  //EDITAR EXAMEN FORM
  $("#editar-examen-form").submit(function (e) {//INSERTAR BLOQUES A DB
    e.preventDefault();
    if (verificar_campos('examen-edit') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      // Get some values from elements on the page:
      var $form = $(this),
        nombre_examen = $form.find("input[name='nombre-examen-edit']").val(),
        descripcion_examen = $form.find("textarea[name='descripcion-examen-edit']").val(),
        bloque = bloque = $('#bloques-select').val(),
        edit = true,
        url = "../controllers/examen_profesor.php";

      const objeto_peticion = {
        tabla: "tabla_examenes",
        bloque: $('#bloques-select').val()
      };

      $.post(url, {
        examen: nombre_examen,
        descripcion: descripcion_examen,
        nombre_bloque: bloque,
        editar_examen: edit
      })
        .done(function (data) {
          if (data != 0) {
            renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
            $('.spinner-border').addClass('d-none');
            $("#alerta-examen-edit").removeClass("d-none");
            $("#alerta-examen-edit").slideDown("slow");
            setTimeout(function () {
              $("#alerta-examen-edit").slideUp("slow");
            }, 3000);
            const bloque = $('#bloques-select').val();
            editarExamen(bloque);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        });

    }

  });


  //AÑADIR TEMAS FORM
  $("#registrar-tema").submit(function (e) {//INSERTAR TEMAS A LA BASE DE DATOS 
    e.preventDefault();
    if (verificar_campos('tema') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      const formData = new FormData(this);
      const bloque = $('#bloques-select').val();
      formData.append("bloque", bloque);

      const objeto_peticion = {
        tabla: "tabla_temas",
        bloque: $('#bloques-select').val()
      };

      $.ajax({
        url: '../controllers/tema_profesor.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          if (data == 1) {
            actualizarSelectTemas($('#bloques-select').val())
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $('#archivo-tema-name').text('Subir Archivo');
            $("#alerta-tema").removeClass("d-none");
            $('#registrar-tema').trigger('reset');
            $('.spinner-border').addClass('d-none');
            $("#alerta-tema").slideDown("slow");
            setTimeout(function () {
              $("#alerta-tema").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        }
      });

    }

  });

  $('#archivo-tema').change(function () {//CARGA LA VISTA PREVIA DEL INPUT FILE DE CURSOS
    if (this.files && this.files[0]) {
      $('#archivo-tema-name').text(this.files[0].name);
    }
  });

  /* EDITAR TEMA FORM */

  $("#editar-tema-form").submit(function (e) {//INSERTAR TEMAS A LA BASE DE DATOS 
    e.preventDefault();
    if (verificar_campos('tema-edit') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      const formData = new FormData(this);
      const tema = $('#temas-select').val();
      const bloque = $('#bloques-select').val();
      formData.append("tema_id", tema);
      formData.append("bloque", bloque);
      formData.append("editar_tema", true);

      const objeto_peticion = {
        tabla: "tabla_temas",
        bloque: $('#bloques-select').val()
      };

      $.ajax({
        url: '../controllers/tema_profesor.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          if (data == 1) {
            actualizarSelectTemas($('#bloques-select').val())
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $("#alerta-tema-edit").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $("#alerta-tema-edit").slideDown("slow");
            setTimeout(function () {
              $("#alerta-tema-edit").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        }
      });

    }

  });


  //PREGUNTAS DE EXAMEN FORM
  $(document).on('click', '.radio-in', function () { //INDICA QUE AL CLICKEAR UN RADIO SERA LA CORRECTA
    correcta = $(this).data('correcta');
  });

  $("#registrar-pregunta").submit(function (e) {//INSERTAR PREGUNTAS A DB
    e.preventDefault();
    if (verificar_campos('preg-resp') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else if (verificar_radios('pregunta') == 'radio-uncheck') {
      swal("", "Por favor seleccione la respuesta correcta", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      let respuestas = '';
      for (i = 1; i <= 4; i++) {
        if (i == correcta && i == 4) {
          respuestas += '###' + $('#respuesta' + i).val();
        } else if (i == 4) {
          respuestas += $('#respuesta' + i).val();
        } else if (i == correcta) {
          respuestas += '###' + $('#respuesta' + i).val() + '-*3';
        } else {
          respuestas += $('#respuesta' + i).val() + '-*3';
        }
      }

      // Get some values from elements on the page:
      var $form = $(this),
        pregunta_examen = $form.find("input[name='pregunta-examen']").val(),
        bloque = bloque = $('#bloques-select').val(),
        url = "../controllers/preguntas_profesor.php";

      const objeto_peticion = {
        tabla: "tabla_preguntas",
        bloque: $('#bloques-select').val()
      };

      $.post(url, {
        pregunta: pregunta_examen,
        respuesta: respuestas,
        nombre_bloque: bloque
      })
        .done(function (data) {
          if (data == 'creado') {
            actualizarSelectPreguntas($('#bloques-select').val())
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $('#registrar-pregunta').trigger('reset');
            $('.spinner-border').addClass('d-none');
            $("#alerta-pregunta").removeClass("d-none");
            $("#alerta-pregunta").slideDown("slow");
            setTimeout(function () {
              $("#alerta-pregunta").slideUp("slow");

            }, 3000);
          } else {
            $('.spinner-border').addClass('d-none');
            $(".alerta-error").removeClass("d-none");
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }
        })

    }

  });

  //Editaar preguntas examen
  $("#editar-pregunta-form").submit(function (e) {//INSERTAR PREGUNTAS A DB
    e.preventDefault();

    if (verificar_campos('preg-resp-edit') == 'campo-vacio') {
      swal("", "Por favor llene todos los campos", "warning");
    } else if (verificar_radios('pregunta-edit') == 'radio-uncheck') {
      swal("", "Por favor seleccione la respuesta correcta", "warning");
    } else {
      $('.spinner-border').removeClass('d-none');

      let respuestas = '';
      for (i = 1; i <= 4; i++) {
        if (i == correcta && i == 4) {
          respuestas += '###' + $('#respuesta-' + i).val();
        } else if (i == 4) {
          respuestas += $('#respuesta-' + i).val();
        } else if (i == correcta) {
          respuestas += '###' + $('#respuesta-' + i).val() + '-*3';
        } else {
          respuestas += $('#respuesta-' + i).val() + '-*3';
        }
      }

      var $form = $(this),
        pregunta_examen = $form.find("input[name='pregunta-examen-edit']").val(),
        bloque = $('#bloques-select').val(),
        edit = true,
        url = "../controllers/preguntas_profesor.php";

      const objeto_peticion = {
        tabla: "tabla_preguntas",
        bloque: $('#bloques-select').val()
      };

      $.post(url, {
        pregunta: pregunta_examen,
        respuesta: respuestas,
        nombre_bloque: bloque,
        editar_pregunta: edit,
        idpregunta: idpregunta
      })
        .done(function (data) {

          if (data == 'actualizado') {
            actualizarSelectPreguntas($('#bloques-select').val())
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $('.spinner-border').addClass('d-none');
            $("#alerta-pregunta-edit").removeClass("d-none");
            $("#alerta-pregunta-edit").slideDown("slow");
            setTimeout(function () {
              $("#alerta-pregunta-edit").slideUp("slow");
            }, 3000);

          } else {
            $('.spinner-border').addClass('d-none');
            $(".alerta-error").removeClass("d-none");
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }
        })

    }

  });


  //TAREAS FORM
  $('#registrar-tarea').submit(function (e) {
    e.preventDefault();

    if (verificar_campos('tarea') == 'campo-vacio') {

      swal("", "Por favor llene todos los campos", "warning");

    } else {

      $('.spinner-border').removeClass('d-none');

      const formData = new FormData(this);
      const bloque = $('#bloques-select').val();
      formData.append("bloque", bloque);

      const objeto_peticion = {
        tabla: "tabla_tareas",
        bloque: $('#bloques-select').val()
      };

      $.ajax({
        url: '../controllers/tarea_profesor.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          if (data == 1) {
            editarTarea(bloque);
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $('#archivo-tarea-name').text('Subir Archivo');
            $("#alerta-tarea").removeClass("d-none");
            $('#registrar-tarea').trigger('reset');
            $('.spinner-border').addClass('d-none');
            $("#alerta-tarea").slideDown("slow");
            setTimeout(function () {
              $("#alerta-tarea").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        }
      });

    }

  });

  //EDITAR TAREAS FORM
  $('#editar-tarea-form').submit(function (e) {
    e.preventDefault();

    if (verificar_campos('tarea-edit') == 'campo-vacio') {

      swal("", "Por favor llene todos los campos", "warning");

    } else {

      $('.spinner-border').removeClass('d-none');

      const formData = new FormData(this);
      const bloque = $('#bloques-select').val();
      formData.append("bloque", bloque);
      formData.append("editar_tarea", true);

      const objeto_peticion = {
        tabla: "tabla_tareas",
        bloque: $('#bloques-select').val()
      };

      $.ajax({
        url: '../controllers/tarea_profesor.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          if (data == 1) {
            editarTarea(bloque);
            renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
            $('#archivo-tarea-name').text('Subir Archivo');
            $("#alerta-tarea-edit").removeClass("d-none");
            $('#registrar-tarea').trigger('reset');
            $('.spinner-border').addClass('d-none');
            $("#alerta-tarea-edit").slideDown("slow");
            setTimeout(function () {
              $("#alerta-tarea-edit").slideUp("slow");
            }, 3000);
          } else {
            $(".alerta-error").removeClass("d-none");
            $('.spinner-border').addClass('d-none');
            $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron enviados!</p>')
            $(".alerta-error").slideDown("slow");
            setTimeout(function () {
              $(".alerta-error").slideUp("slow");
            }, 3000);
          }

        }
      });


    }

  });

  $('#archivo-tarea').change(function () {//CARGA LA VISTA PREVIA DEL INPUT FILE DE CURSOS
    if (this.files && this.files[0]) {
      $('#archivo-tarea-name').text(this.files[0].name);
    }
  });


  // /* ***********************FUNCIONES ************************************/

  /* VERIFICAR CAMPOS FORMULARIO */
  function verificar_campos(tipo) {
    for (i = 0; i < $('.input-' + tipo).length; i++) {
      if ($('.input-' + tipo).eq(i).val() == '') {
        return 'campo-vacio';
      }
    }

  }

  /* VERIFICAR RADIO BUTTON  */
  function verificar_radios(clase_radio) {
    for (i = 0; i < $('.radio-' + clase_radio).length; i++) {
      if ($('.radio-' + clase_radio).eq(i).is(':checked')) {
        return 'radio-checked';
      }
    }
    return 'radio-uncheck';
  }

  /* PREVISUALIZACION DE LA IMAGEN DEL CURSO */
  function leerUrl(input, img_container, img_text) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        $(img_container).attr('src', e.target.result);
        $(img_text).text(input.files[0].name);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string

    }
  }

  /* OBTENER CURSOS */
  function actualizarSelectCursos(cursos_select) {
    const value_selected = $(cursos_select).val();
    $.get("../controllers/select_cursos.php", function (data, status) {
      if (status) {
        $(cursos_select).html(`<option value="0">Elige un curso</option>`);
        $(cursos_select).addClass('text-danger');
        $(cursos_select).removeClass('text-info');
        if (data) {
          const cursos = JSON.parse(data);

          cursos.map(curso => {
            $(cursos_select).append(`<option value="${curso[0]}">${curso[1]}</option>`)
          });

        } else {
          $(cursos_select).html(`<option value="no-course">No tienes ningun Curso</option>`)
        }

      }
      if (value_selected != 0 && value_selected) {
        $(cursos_select).addClass('text-info');
        $(cursos_select).removeClass('text-danger');
        $(`${cursos_select} option[value='${value_selected}']`).prop('selected', true);
      }
    });


  }

  /* OBTENER BLOQUES */
  function actualizarSelectBloques(curso_value) {                    //obtendremos el valor del select 
    const value_selected = $('#bloques-select').val();
    $.get("../controllers/select_bloques.php", { curso: curso_value })//curso como parametro 
      .done(function (data) {                                         //para pasarlo como dato a
        $('#aniadir-pregunta, #ver-examen').addClass('disabled');     //la peticion get
        $('#bloques-select').html(`<option value="0">Elige un bloque</option>`);
        if (curso_value != 0) {
          if (data != 0) {
            $('#ver-bloques').removeClass('disabled');
            const bloques = JSON.parse(data);

            bloques.map(bloque => {
              $('#bloques-select').append(`<option value="${bloque[0]}">${bloque[1]}</option>`);
            });
          } else {
            $('#bloques-select').html(`<option value="sin-bloques">Curso no tiene bloques</option>`);
            $('#editar-bloque, #ver-bloques').addClass('disabled');
            $('#aniadir-examen, #aniadir-tema, #editar-temas, #aniadir-pregunta, #aniadir-tarea, #editar-bloque, #ver-bloque').addClass('disabled');
            $('#aniadir-examen, #aniadir-tema, #editar-temas, #aniadir-pregunta, #aniadir-tarea, #editar-bloque').collapse('hide');
            $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').collapse('hide');
            $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').removeClass('show in');
          }
        } else {
          $('#info-select-bloque').removeClass('invisible');
          $('#bloques-select').empty();//VACIAR EL SELECT SI NO HAY CURSO SELECCIONADO
        }
        if (value_selected != 0 && value_selected) {
          $(`#bloques-select option[value='${value_selected}']`).prop('selected', true);
        } else {
          $('#aniadir-examen, #aniadir-tema, #editar-tema, #aniadir-pregunta, #aniadir-tarea, #editar-bloque').addClass('disabled');
          $('#aniadir-examen, #aniadir-tema, #editar-tema, #aniadir-pregunta, #aniadir-tarea, #editar-bloque').collapse('hide');
          $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').collapse('hide');
          $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').removeClass('show in');
        }
        $('#bloques-select').val() === 0
          ? $('#bloques-select').addClass('text-danger')
          : $('#bloques-select').addClass('text-primary');
      });
  }

  /* OBTENER TEMAS E IMPRIMIR EN EL SELECT */
  function actualizarSelectTemas(bloque_id) {
    const value_selected = $('#temas-select').val();
    $.get("../controllers/select_temas.php", { bloque: bloque_id })
      .done(function (data) {
        if (data != 0) {
          $('#editar-temas, #ver-temas').removeClass('disabled');
          $('#temas-select').html(`<option value="0">Elige un Tema</option>`);
          const temas = JSON.parse(data);

          temas.map(tema => {
            $('#temas-select').append(`<option value="${tema[0]}">${tema[1]}.- ${tema[2]}</option>`);
          });

          if (value_selected != 0 && value_selected) {
            $(`#temas-select option[value='${value_selected}']`).prop('selected', true);
          }
        } else {
          if (bloque_id == 0) {
            $('#aniadir-tema, #editar-tema').addClass('disabled');
            $('#aniadir-tema, #editar-tema').collapse('hide');
            $('#collapseTemaEdit, #collapseTema').collapse('hide');
            $('#collapseTemaEdit, #collapseTema').removeClass('show in');
          } else {

            $('#temas-select').html(`<option value="sin-bloques">Bloque no tiene temas</option>`);
            $('#editar-temas, #ver-temas').addClass('disabled');
            $('#editar-temas, #collapseTemaEdit').collapse('hide');
            $('#collapseTemaEdit').removeClass('show in')
          }
        }
      });

  }

  /* OBTENER preguntas E IMPRIMIR EN EL SELECT */
  function actualizarSelectPreguntas(bloque_id) {
    const value_selected = $('#preguntas-select').val();
    $.get("../controllers/select_preguntas.php", { bloque: bloque_id })
      .done(function (data) {

        if (data != 0) {
          $('#editar-preguntas, #ver-preguntas').removeClass('disabled');
          $('#preguntas-select').html(`<option value="0">Elige una Pregunta</option>`);
          const preguntas = JSON.parse(data);

          preguntas.map(pregunta => {
            $('#preguntas-select').append(`<option value="${pregunta[0]}">${pregunta[1]}</option>`);
          });

          $('#editar-pregunta').removeClass('disabled');

          if (value_selected != 0 && value_selected) {
            $(`#preguntas-select option[value='${value_selected}']`).prop('selected', true);
          } else {
            $('#editar-pregunta-form').addClass('d-none')
          }

        } else {
          if (bloque_id == 0) {
            $('#aniadir-pregunta, #editar-pregunta').addClass('disabled');
            $('#aniadir-pregunta, #editar-pregunta').collapse('hide');
            $('#collapsePreguntaEdit, #collapsePregunta').collapse('hide');
            $('#collapsePreguntaEdit, #collapsePregunta').removeClass('show in');
          } else {

            $('#preguntas-select').html(`<option value="sin-bloques">Examen no tiene preguntas</option>`);
          }
        }
      });

  }

  function editarCurso(curso_a_editar) {
    const url = '../controllers/cursos_profesor.php';

    $.get(url, { curso: curso_a_editar })
      .done(function (data) {
        const data_curso = JSON.parse(data);
        const url = '../img/res_' + data_curso[0]['imagen'].split("/").slice(-1).toString();
        $('#foto-curso-edit').attr('src', url);
        $form = $('#editar-curso-form');
        $form.find("input[name='nombre-curso']").val(data_curso[0]['nombre']);
        $form.find("textarea[name='descripcion-curso']").val(data_curso[0]['descripcion']);
        $form.find("input[name='horas-curso']").val(data_curso[0]['horas']);
        $form.find("input[name='costo-curso']").val(data_curso[0]['costo']);
        const video = data_curso[0]['video'].split("/")
        $form.find("input[name='video-curso']").val(video.slice(-1));

      });
  }

  function editarBloques(bloque_value) {

    if (bloque_value != 0) {

      $.get("../controllers/bloques_profesor.php", { bloque: bloque_value })
        .done(function (data) {
          const data_bloque = JSON.parse(data);

          $form = $('#editar-bloque-form');
          $form.find("input[name='nombre-bloque']").val(data_bloque[0]['nombre']);
        });

    } else {

      $('#editar-bloque').addClass('disabled');
      $('#aniadir-examen, #aniadir-tema, #editar-temas, #aniadir-pregunta, #aniadir-tarea, #editar-bloque, #ver-bloque').addClass('disabled');
      $('#aniadir-examen, #aniadir-tema, #editar-temas, #aniadir-pregunta, #aniadir-tarea, #editar-bloque').collapse('hide');
      $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').collapse('hide');
      $('#collapseExamen, #collapseTema, #collapseTemaEdit, #collapsePregunta, #collapseTarea, #collapseBloqueEdit').removeClass('show in');

    }

  }

  function editarExamen(bloque_value) {

    $.get("../controllers/examen_profesor.php", { bloque: bloque_value })
      .done(function (data) {
        if (data != 0) {
          const datos_examen = JSON.parse(data);
          $("input[name='nombre-examen-edit'").val(datos_examen[0][0]);
          $("textarea[name='descripcion-examen-edit'").val(datos_examen[0][1]);
          $('#aniadir-examen').addClass('disabled');
          $("#aniadir-pregunta, #ver-examen, #editar-examen").removeClass('disabled');
          setTimeout(() => {
            $('#aniadir-examen').collapse('hide');
            $('#collapseExamen').collapse('hide');
            $('#collapseExamen').removeClass('show in');
          }, 3000);

        } else {
          $("#aniadir-pregunta, #editar-examen, #ver-examen").addClass('disabled');
          $("#aniadir-examen").removeClass('disabled');
          $('#aniadir-pregunta, #editar-examen').collapse('hide');
          $('#collapsePregunta, #collapseExamenEdit').collapse('hide');
          $('#collapsePregunta, #collapseExamenEdit').removeClass('show in');
        }

      });

  }

  function editarTema(tema_value) {

    if (tema_value != 0) {
      $.get("../controllers/tema_profesor.php", { tema: tema_value })
        .done(function (data) {

          if (data != 0) {
            const datos_tema = JSON.parse(data);
            $("input[name='nombre-tema-edit'").val(datos_tema[0]['nombre']);
            $("textarea[name='descripcion-tema-edit'").val(datos_tema[0]['descripcion']);
            $("input[name='video-tema-edit'").val(datos_tema[0]['video'].split("/").slice(-1).toString());
          }
        });
    } else {
      $('#editar-temas').addClass('disabled');
      $('#editar-temas, #collapseTemaEdit').collapse('hide');
      $('#editar-temas, #collapseTemaEdit').removeClass('show in');
    }

  }

  function editarPregunta(pregunta_value) {
    if (pregunta_value != 0) {
      $.get("../controllers/preguntas_profesor.php", { pregunta: pregunta_value })
        .done(function (data) {

          if (data != 0) {
            /* Cargar datos a los input si  los hay */
            const datos_pregunta = JSON.parse(data);
            idpregunta = datos_pregunta[0]['idpregunta'];
            let respuestas = datos_pregunta[0]['respuestas'].split('-*3');
            let respuesta_correcta;

            $("input[name='pregunta-examen-edit'").val(datos_pregunta[0]['pregunta']);

            respuestas.forEach(function (respuesta, index) {
              if (respuesta.includes('###')) {
                respuesta_correcta = respuesta.split('###');
                $(`input[name='respuesta${index + 1}-edit'`).val(respuesta_correcta[1]);
                $(`input[name='customRadio${index + 1}'`).prop('checked', false);
                /*                 $(`input[name='customRadio${index+1}'`).prop('checked', true); */
              } else {
                $(`input[name='respuesta${index + 1}-edit'`).val(respuesta);
                $(`input[name='respuesta${index + 1}-edit'`).val(respuesta);
                $(`input[name='respuesta${index + 1}-edit'`).val(respuesta);
                $(`input[name='customRadio${index + 1}'`).prop('checked', false);
              }
            });
          }
        });
    } else {
      $('#editar-pregunta').addClass('disabled');
      $('#ver-pregunta').addClass('disabled');
      $('#editar-pregunta, #collapsePreguntaEdit').collapse('hide');
      $('#editar-pregunta, #collapsePreguntaEdit').removeClass('show in');
    }
  }

  function editarTarea(bloque_value) {

    $.get("../controllers/tarea_profesor.php", { bloque: bloque_value })
      .done(function (data) {
        if (data != 0) {
          const datos_tarea = JSON.parse(data);
          $("input[name='nombre-tarea-edit'").val(datos_tarea[0]['nombre']);
          $("textarea[name='descripcion-tarea-edit'").val(datos_tarea[0]['descripcion']);
          $('#aniadir-tarea').addClass('disabled');
          $("#editar-tarea").removeClass('disabled');
          $("#ver-tareas").removeClass('disabled');
          setTimeout(() => {
            $('#aniadir-tarea').collapse('hide');
            $('#collapseTarea').collapse('hide');
            $('#collapseTarea').removeClass('show in');
          }, 3000);

        } else {
          $("#editar-tarea").addClass('disabled');
          $("#ver-tareas").addClass('disabled');
          $("#aniadir-tarea").removeClass('disabled');
          $('#editar-tarea').collapse('hide');
          $('#collapseTareaEdit').collapse('hide');
          $('#collapseTareaEdit').removeClass('show in');
        }

        if (bloque_value == 0) {
          $("#aniadir-tarea, #editar-tarea, #ver-tareas").addClass('disabled');
          $('#aniadir-tarea, #editar-tarea, #ver-tareas').collapse('hide');
          $('#collapseTarea, #collapseTareaEdit').collapse('hide');
          $('#collapseTarea, #collapseTareaEdit').removeClass('show in');
        }

      });

  }

  ///////////////////////// TABLAS //////////////////////////////////////////

  function renderizarTabla(objeto_peticion, idtr, idtbody) {
    $.post('../controllers/tablas_dashboard_profesores.php', objeto_peticion, function (response) {
      const datos = JSON.parse(response);
      if (datos.length > 0) {
        let nombrescolumnas = [];
        let trhead = ``;
        let tbody = ``;
        let botones = ``;
        identificador_tablas = objeto_peticion['tabla'];
        nombre_tabla = identificador_tablas.split('_');

        datos.forEach(function (objeto_renglon_tabla, posicion) {
          if (posicion === 0) { //se renderizan el thead de la tabla
            nombrescolumnas = Object.keys(objeto_renglon_tabla);
            nombrescolumnas.forEach(function (valor, posicion) {
              if (valor != "publicacion") trhead += `<th scope="col" class="text-light ${posicion === 0 || valor === "preferencia" ? " d-none" : ""}">${valor.charAt(0).toLocaleUpperCase() + valor.slice(1)}</th>`
            })
          }

          posicion_renglon = Object.values(objeto_renglon_tabla);
          botones = `<td><button value="${posicion_renglon[0]}" class="btn btn-danger eliminar">Eliminar</button></td>`;

          tbody += `<tr>`;
          nombrescolumnas.forEach(function (nombre_propiedad_objeto, posicion) {

            switch (nombre_propiedad_objeto) {

              case "publicacion":
                if (objeto_renglon_tabla[nombre_propiedad_objeto] === 1) {
                  botones = `<td>
                            <button class = "btn btn-success btnestado" value="${objeto_renglon_tabla.idcurso + '=' + objeto_renglon_tabla.publicacion}">Ocultar</button>
                          </td>`;
                } else {
                  botones = `<td>
                            <button class = "btn btn-warning btnestado" value="${objeto_renglon_tabla.idcurso + '=' + objeto_renglon_tabla.publicacion}">Publicar</button>
                           </td>`;
                }
                break;

              case "respuestas":
                const filtrogatos = objeto_renglon_tabla[nombre_propiedad_objeto].split('###');
                const respuestas_lado_derecho = filtrogatos[1].split('-*3');
                const respuestas_lado_izquierdo = filtrogatos[0].split('-*3');
                let respuestas = '';

                respuestas_lado_izquierdo.forEach(function (valor) {
                  if (valor != "") respuestas += " ✘ " + valor;
                });

                respuestas_lado_derecho.forEach(function (valor, posicion) {
                  if (valor != "") {
                    if (posicion === 0) {
                      respuestas += " ✔ " + valor;
                    } else {
                      respuestas += " ✘ " + valor;
                    }
                  }
                })
                tbody += `<td>${respuestas}</td>`;
                break;

              case "imagen":
                const componentes_ruta = objeto_renglon_tabla[nombre_propiedad_objeto].split('/');
                const imagen = 'min_' + componentes_ruta[2];
                const ruta = componentes_ruta[0] + '/' + componentes_ruta[1] + '/' + imagen;
                tbody += `<td><img src="${ruta}" alt="curso escuelaalreves"></td>>`;
                break;

              default:
                tbody += `<td class=${posicion === 0 || nombre_propiedad_objeto === "preferencia" ? "d-none" : ""}>${objeto_renglon_tabla[nombre_propiedad_objeto]}</td>`;
                break;

            }


          })
          tbody += botones + `</tr>`;

        });
        if (datos[0].hasOwnProperty('preferencia')) trhead += `<th><button id="btnorden" class="btn btn-primary" disabled >Guardar</button></th>`
        $(idtr).html(trhead);
        $(idtbody).html(tbody);
        $('.titulo-tablas').html(nombre_tabla[1]);
      }else{
        let trhead = ``;
        let tbody = ``;
        trhead += `<th class="text-white h3">No hay datos en este tabla todavia</th>`
        tbody += `<td></td>`
        $(idtr).html(trhead);
        $(idtbody).html(tbody);
      }
    })
  }

  renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');

  $(document).on('click', '#cursos-tab', function () {
    renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');
  });

  $(document).on('click', '#contenido-curso-tab', function () {
    if ($('#bloques-select').val()) {
      const objeto_peticion = {
        tabla: "tabla_temas",
        bloque: $('#bloques-select').val()
      };
      renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
    } else {
      $('.titulo-tablas').html("temas");
    }
    
  });


  $(document).on('click', '#ver-cursos', function () {
    renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  $(document).on('click', '#ver-bloques', function () {
    const objeto_peticion = {
      tabla: "tabla_bloques",
      curso: $('#cursos-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  $(document).on('click', '#ver-examen', function () {
    const objeto_peticion = {
      tabla: "tabla_examenes",
      bloque: $('#bloques-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  $(document).on('click', '#ver-temas', function () {
    const objeto_peticion = {
      tabla: "tabla_temas",
      bloque: $('#bloques-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  // reordenamiento dinamico de la tabla
  $("#tbodygrupo2").sortable({
    containerSelector: ' table ',
    itemPath: ' > tbody ',
    itemSelector: ' tr ',
    cursor: 'pointer',
    axis: 'y',
    dropOnEmpty: false,
    start: function (e, ui) {
      ui.item.addClass("selected");
    },
    stop: function (e, ui) {
      reordenamientorows = [];
      $("#btnorden").prop('disabled', false);
      ui.item.removeClass("selected");
      $(this).find("tr").each(function (index) {
        const id = $(this).find("td").eq(0).html();
        $(this).find("td").eq(1).html(index + 1);
        const preferencia = $(this).find("td").eq(1).html();
        reordenamientorows.push({
          idtema: id,
          preferencia: preferencia
        });
      });
    }
  });

  // enviar el nuevo orden de la tabla
  $(document).on('click', '#btnorden', function () {
    $("#btnorden").prop('disabled', true);
    $.post("../controllers/tema.php", { accion: "reordenaritemstabla", reordenamientorows: reordenamientorows }, function (response) {
      if (response == "") {
        swal("Cambios realizados!", "Los cambios se guardaron exitosamente", "success")
      } else {
        swal("Ups!", "Algo salio mal!", "warning")
      }
    })
  });

  $(document).on('click', '#ver-preguntas', function () {
    const objeto_peticion = {
      tabla: "tabla_preguntas",
      bloque: $('#bloques-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  $(document).on('click', '#ver-tareas', function () {
    const objeto_peticion = {
      tabla: "tabla_tareas",
      bloque: $('#bloques-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
    $('html, body').animate({
      scrollTop: $(document).height()
    }, 'slow');
  });

  //ACTUALIZAR EL ESTADO DE LA PUBLICACION DEL CURSO
  $(document).on('click', '.btnestado', function () {
    const datos = $(this).val().split('=');
    const recursosactualizacion = {
      idcurso: datos[0],
      publicacion: datos[1] != 0 ? datos[1] = 0 : datos[1] = 1,
      accion: 'editarpublicacion'
    }
    $.post('../controllers/cursos.php', recursosactualizacion, (response) => { })
    renderizarTabla({ tabla: 'tabla_cursos' }, '#tr-tablagrupo1', '#tbodygrupo1');

  });

  $(document).on('change', '#bloques-select', function(){
    if($('#contenido-curso-tab').hasClass('active')){
      const objeto_peticion = {
      tabla: "tabla_temas",
      bloque: $('#bloques-select').val()
    };
    renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
/*     $('.titulo-tablas').html("temas"); */
    }
    
  })

  //################################################## ELIMINAR CONTENIDO ##############################
  $(document).on('click', '.eliminar', function () {
    getid = $(this).val();

    if (identificador_tablas == 'tabla_temas') {
      eliminarContenido('tema_profesor.php', 'tabla_temas', 'bloque', '#bloques-select'); //ELIMINA TEMAS

    } else if (identificador_tablas == 'tabla_preguntas') {
      eliminarContenido('preguntas_profesor.php', 'tabla_preguntas', 'bloque', '#bloques-select'); //ELIMINA PREGUNTAS

    } else if (identificador_tablas == 'tabla_tareas') {//ELIMINA TAREAS
      eliminarContenido('tarea_profesor.php', 'tabla_tareas', 'bloque', '#bloques-select')

    } else if (identificador_tablas == 'tabla_examenes') {//ELIMINA EXAMENES
      eliminarContenido('examen_profesor.php', 'tabla_examenes', 'bloque', '#bloques-select')

    } else if (identificador_tablas == 'tabla_bloques') {
      eliminarContenido('bloques_profesor.php', 'tabla_bloques', 'curso', '#cursos-select');//ELIMINA BLOQUES
    }

  });

  function eliminarContenido(controller, tabla, bloq, select) {///////////FUNCION PARA ELIMINAR CONTENIDOS
    swal("¿Estás seguro de eliminar?", {
      buttons: {
        cancel: "No, Cancelar",
        catch: {
          text: "Si, eliminar",
          value: "catch",
        }
      }
    })
      .then((value) => {
        if (value == "catch") {
          var eliminar = true,
            id = getid
          url = "../controllers/" + controller;

          let objeto_peticion;

          if (bloq == 'bloque') {
            objeto_peticion = {
              tabla: tabla,
              bloque: $(select).val()
            };
          } else {
            objeto_peticion = {
              tabla: tabla,
              curso: $(select).val()
            };
          }


          $.post(url, {
            eliminar: eliminar,
            id_eliminar: id
          })
            .done(function (data) {
              if (data == 'eliminado') {
                editarTarea($('#bloques-select').val())
                editarExamen($('#bloques-select').val())
                /* actualizarSelectBloques($('#cursos-select').val()) */
                actualizarSelectTemas($('#bloques-select').val())
                actualizarSelectPreguntas($('#bloques-select').val())
                renderizarTabla(objeto_peticion, '#tr-tablagrupo2', '#tbodygrupo2');
                renderizarTabla(objeto_peticion, '#tr-tablagrupo1', '#tbodygrupo1');
                $('.spinner-border').addClass('d-none');
                $(".alerta-elim").removeClass("d-none");
                $('.alerta-elim').html(`<p class="m-0"> ¡<b>Eliminado</b>!</p>`)
                $(".alerta-elim").slideDown("slow");
                setTimeout(function () {
                  $(".alerta-elim").slideUp("slow");
                }, 3000);

              } else {
                $('.alerta-error').html('<p class="m-0"> <b>Hubo un error: </b>los datos no fueron eliminados!</p>')
                $(".alerta-error").slideDown("slow");
                setTimeout(function () {
                  $(".alerta-error").slideUp("slow");
                }, 3000);
              }
            })
        }

      })
    return 1;
  }
  /* <--------------------- cuando de clic a ver tablas se da scroll hacia abajo a la tabla-----------------------> */
  $(document).on('click', '#ir-arriba', function () {
    $('html, body').animate({
      scrollTop: 0
    }, 'fast');
  })
  /* <---------------------scroll para aparecer el boton de 'ir hacia arriba'-----------------------> */
  $(function () {
    $(document).scroll(function () {
      if ($(this).scrollTop() > 120) {
        $('#ir-arriba').show('fast')
      }
      if ($(this).scrollTop() < 120) {
        $('#ir-arriba').hide('fast')
      }
    });
  });

})

