$(document).ready(function () {
    //lista_temas();
    lista();
    let contador = 0;
    let contador2 = 500;
    let id_actual_base = "";
    let id_control_direccionamiento = "";
    let cont_examen_preguntas = 0;
    let id_examen = "";
    let id_tarea = "";
    let id_bloque = "";
    let calificacion_comentario = 0;
    let id_calificar_tarea = 0;
    controlStart = 0;
    mostrarComentariosCurso();

       // VALORACION DE ESTRELLAS PARA CALIFICAR
       $(".clasificacion").find("input").change(function(){
        var valor = $(this).val()
        $(".clasificacion").find("input").removeClass("activo")
        $(".clasificacion").find("input").each(function(index){
           if(index+1<=valor){
            $(this).addClass("activo");
           }          
        })
        calificacion_comentario = $(this).val();
      });

      $(document).on('click','#enviar',function(e){
          e.preventDefault();
         if($(".comment-curso").val() != ""){
             contador2 = 500;
             $("#numero_coment").val(contador2);
             $.ajax({
                url:"../controllers/dashboard.php",
                type:"POST",
                data:"registro-coment="+$(".comment-curso").val(),

                success: function(response){
                    if(response == 1){
                        mostrarComentariosCurso();
                        $(".comment-curso").val("");
                        $("section,div").animate({ scrollTop: $("#comentarios-7").offset().top },1000);
                    }
                }
             });
         }
      });

      function mostrarComentariosCurso(){
            $.ajax({
                url:"../controllers/dashboard.php",
                type:"POST",
                data:"comentariosCurso=comentariosCurso",

                success: function(response){
                    if(response != "[]"){
                        datos = JSON.parse(response);
                        templete_comentarios = ``;
                        $.each(datos,function(i,item){
                            templete_comentarios += `
                            <div id="comentarios-${i+1}" class="" style="height:auto; padding: 1rem 3rem; background-color: white;">
                                <div class="container border" style="box-shadow: 10px 5px 10px #EDEDED; border-radius: 1rem;">
                                    <li id="userComment" class="list-group list-group-action font-weight-bold">${item[0]}</li>
                                    <li id="comment" class="list-group pl-5 pt-3 text-bold">${item[1]}</li>
                                    <li id="date" class="float-right list-group font-weight-bold">${item[2]} ${item[3]}</li>
                                </div>
                            </div>
                            `; 
                        });
                        $("#area-comentarios").html(templete_comentarios);
                    }
                }
            });
      }

      $(document).on('click','#btn-cali',function(){
        valor_estrellas = $(".activo").eq(parseInt($('.activo').length - 1)).val();
        comentario = $("#coment-user").val();
        const form = {
            id_calificar_tarea:id_calificar_tarea,
            valor_estrellas:valor_estrellas,
            comentario:comentario
        };
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:form,
            success: function(response){
                obtenerTareasBloque(id_bloque);
                $("#coment-user").val("");
                $('.calificar-tarea').removeClass("activo");
            }
        });
      });
      
        
        $(document).on("keyup","#text_area_curso",function(){
            cont--;
            $("#numero_coment").val(contador);
            if(contador < 0){
                $('#enviar').attr("disabled", false);
            }else{
                $('#enviar').attr("disabled", true);
            }
        });

      $(document).on('click','.btn-calificar-tabla',function(){
          $('.mostrar-comentario').html("");
        id_calificar_tarea = $(this).data("idtarearealizada");
        $('.mostrar-comentario').addClass("d-none");
        $('.hide-calific').removeClass("d-none");
        $('#btn-cali').removeClass('d-none');
      });

      $(document).on('click','.calificaciones',function(){
        $('.mostrar-comentario').removeClass("d-none");
        $('.hide-calific').addClass("d-none");
        $('#btn-cali').addClass('d-none');
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"id_cometario="+$(this).data("idcomentario"),

            success: function(response_2){
                template_cometarios = ``;
                datos = JSON.parse(response_2);
template_cometarios +=`<div>`;
                    if(datos[0][0] == ""){
template_cometarios +=`  <img width = "10%" src="../img/perfil.png" alt="Esta imagen no esta disponible">`;
                    }else{
                        url = datos[0][0].split("/");
                        urel = url[0]+"/"+url[1]+"/min_"+url[2];
template_cometarios +=`  <img src="${urel}" alt="${datos[0][1]}" class="course_author_image">`;    
                    }
template_cometarios +=`
                        <label class="ml-2">${datos[0][1]}</label>
                    </div>
                    <div>
                        <p class="h4 mt-2">Comentario</p>
                        <p>${datos[0][2]}</p>
                    </div>
                    `; 
                    $(".mostrar-comentario").html(template_cometarios);
            }
        });

      });

      
      $(".clasificacion").find("label").mouseover(function(){
        var valor = $(this).prev("input").val()
        $(".clasificacion").find("input").removeClass("activo")
        $(".clasificacion").find("input").each(function(index){
           if(index+1<=valor){
            $(this).addClass("activo");
           }
        });
      });

    // MOSTRAR ACTIVIDAD AL HACER CLIC EN EL ENLACE
    $(document).on("click",".mostrar-actividad", function () {
        if($(this).data("idactividad") == 1){
            $("#contenido-examen").html("");
            $("#contenido-examen").addClass("d-none");
            $("#cambio-examen-video").removeClass("d-none");
        }
    });


    function obtenerTareasBloque(bloque){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"tabla_tareas_bloque="+bloque,

            success: function(response){
                datos = JSON.parse(response);
                templete_tarea = ``;
                imagen = "";
                $.each(datos,function(i,item){
                    templete_tarea += `
                    <tr>
                        <td class="d-none">${item[0]}</td>
                        <td style="width: 3rem;">`;
                        if(item[1] == ""){
         templete_tarea +=` <img src="../img/perfil.png" alt="perfil" class="course_author_image">`;
                        }else{
                        url = item[1].split("/");
                        urel = url[0]+"/"+url[1]+"/min_"+url[2];
         templete_tarea +=` <img src="${urel}" alt="perfil" class="course_author_image">`;
                        }
                        
                        descarga_item2 = item[2].split('/');
      templete_tarea +=`</td>
                        <td style="width: 4rem;">
                            <a href="${item[2]}" download="${descarga_item2[2]}">
                            <i class="fas fa-file-download text-dark" style="font-size:3rem;"></i>
                        </a>
                        </td>
                        <td class="d-inline-flex">`;
                        if(item[3].length == 0){
                                templete_tarea +=`<div class="mr-1 cometario">Esta persona no a recibido calificaciones</div>`;
                        }else{
                            for(y=0; y < item[3].length; y++){
                                templete_tarea +=`<div style="cursor:pointer;" data-toggle="modal" data-target="#myModal" data-idcomentario="${item[3][y][1]}" class="calificaciones mr-1 cometario">${item[3][y][0]}</div>`;
                            }
                        }
      templete_tarea +=`</td>
                        <td>
                            <div class="star" style="color: gray">`;
                            for(z=0; z < 5; z++){
                                if(item[4] > z){
            templete_tarea +=` <i class="fa fa-star start checked-2" style="cursor: pointer;"></i>`;
                                }else{
            templete_tarea +=` <i class="fa fa-star start" style="cursor: pointer;"></i>`;
                                }
                            }
          templete_tarea +=`</div>
                        </td>
                        <td style="width: 5rem;">
                            <div><button class="btn btn-info btn-calificar-tabla" data-idtarearealizada="${item[5]}" type="button" data-toggle="modal" data-target="#myModal">Calificar</button></div>
                        </td>
                    </tr>
                    `;  
                });

                $(".tabla-tareas-completadas").html(templete_tarea);
            }
        });
    }
    

    /* MOSTRAR AREA DE TAREAS   */
    $(document).on('click','.mostrar-tareas',function(e){
        atributo = $(this).attr('href');
        id_tarea = $(this).data("idtareabase");
        id_bloque = $(this).data("idbloque");
        pintarTablaTareaBloque(id_bloque);
        obtenerTareasBloque(id_bloque);
        $(atributo).slideDown("slow");
        $("html, body").animate({ scrollTop: $(atributo).offset().top },1000);
        e.preventDefault();
    });


        /* RESPONSIVE DE CONTENIDOS ESPECIFICOS*/

    contenido = `
    <li class="nav-item rem-nav">
        <a class="nav-link active" data-toggle="tab" href="#contenido-cursos">Contenido del curso</a>
    </li>
            `;
    contenidoCom = `
        <li class="nav-item rem-nav">
            <a class="nav-link" data-toggle="tab" href="#contenido-comentarios">Comentarios del curso</a>
        </li>
            `;

 
/*     $("#video").on('ended', function () {

    }); */

    function registrarTemaCompletado(tema){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"temaCompleto="+tema,

            success: function (response){
                confeti();
            }
        });
    }

    function pintarTablaTareaBloque(bloque){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"tabla-bloque="+bloque,

            success: function(response){
                datos = JSON.parse(response);
                template = ``;
                $.each(datos,function(i,item){
                    urel = "";
                    if(item[0] == ""){
                        urel = "../img/perfil.png";
                    }else{
                        url = item[0].split("/");
                        urel = url[0]+"/"+url[1]+"/min_"+url[2];
                    }
                    descarga_item = item[1].split('/');
                    template +=`            
                    <tr>
                        <td class="text-nowrap">
                            <img src='${urel}' alt="perfil" class="course_author_image" width="30%">
                        </td>
                        <td class="text-nowrap" style="width: 4rem;">
                            <a href="${item[1]}" download="${descarga_item[2]}">
                            <i class="fas fa-file-download text-dark" style="font-size:3rem;"></i>
                        </a>
                        </td>
                    </tr>`;
                    
                });
                $('.cuerpo-tb-user').html(template);
            }
        });
    }


    $(document).on('click', '.spam', function () {
        controlId = $(this).attr("id");
        $("." + controlId).slideToggle("slow");
    });

    /* CALIFICACION DE CURSO*/

    $(document).on('click', '.estrella', function () {
        controlStart = $(this).attr("id");
        if (controlStart == 1 && $('#' + controlStart).hasClass("checked-2") == true && $('#2').hasClass("checked-2") == false) {
            $('#' + controlStart).removeClass('checked-2');
        } else {
            for (i = 1; i <= 5; i++) {
                if (i <= controlStart) {
                    $('#' + i).addClass('checked-2');
                } else {
                    $('#' + i).removeClass('checked-2');
                }
            }
        }
    });
    
        $(document).on('click','.mostrar-curso-content',function(){
        mostrarInfoCurso();
    });

    $(document).on('click','#guardarCurso',function(){
        const postdata = {
            calificacio_curso_usuarion:controlStart,
            cometareio:$("#text_area_curso").val()
        };
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data: postdata,

            success: function(response){
                 if(response == 1){
                    $(".estrella").removeClass("checked-2");
                    $("#text_area_curso").val("");
                    $("#modalCalificacion").modal("hide");
                }else{
                    $("#alertas-curso").removeClass("d-none");
                } 
            }
        });
    });

    $(document).on('click',"#calificacion-curso-user",function(){
        $("#alertas-curso").addClass("d-none");
    });

    
    $(document).on('click','.mostrar-curso-content',function(){
        mostrarInfoCurso();
    });

    /* PINTAR CONTENIDO DE LAS ACTIVIDADES*/
    
    function lista(){
        $.ajax({
            url: "../controllers/dashboard.php",
            type: "POST",
            data: "datos_lista=datos_lista",

            success: function (response) {
                //console.log(response);
                datos = JSON.parse(response)
                console.log(datos);
    template = `
                <div style="margin-top: 0rem; background-color:  #5ca8ff;">
                    <h4 style="padding: 1rem;" class="h4 text-center widget_title text-white">Contenido del curso</h4>
                </div>
                <div class="demo text-center mostrar-curso-content temas-hover border-bottom" style="cursor: pointer;">
                    <label class=" p-3" style="cursor: pointer;">¿Qué aprenderás en este curso?</label>
                </div>
                `;
                control_seleccion = "";
                control_video = "";
                control_del_chequeo = "";
                checkeo_final = ``;
                examen = "";
                bloque_tarea = "";
                for(i = 0; i < datos.length; i++){
                    for(y = 0; y < datos[i].length; y++){
                         if(y == 0){
                             //Verifico si el examen ya se realizo (si es 1 agrega atributo checked si es 0 el disabled)
                             //la clase temas vistos es para poder checkear los temas a voluntad por el usuario (Solo si el examen esta realizado)
                             if(datos[i][0][4] == 1){
                                control_seleccion = "checked";
                                control_del_chequeo = "temas_vistos";
                                cursor_pointer = ""
                                cursor_pointer_temas="cursor: pointer;";
                                examen = "realizado";
                                checkeo_final = "span-"+(i+1)+"-0";
                                color_lista = "";
                                lista_examen = "bg-color-desabilitado";
                             }else{
                                control_del_chequeo = "";
                                control_seleccion = "disabled";
                                examen = "";
                                bloque_tarea = "d-none";
                                cursor_pointer = "cursor: pointer;"
                                cursor_pointer_temas="";
                                color_lista="bg-color-desabilitado";
                                lista_examen = ""
                             }
                             if(datos[0][0][4] != 1){
                                id_examen = "1--"+1;
                             }
                            template += `
                                <div class="demo contenedor flex align-items-center cont-actividades temas-hover border-bottom ${lista_examen}">
                                    <input type="checkbox" class="chk-examen" id="customCheck-examen-${i+"-"+y}" name="example1" ${control_seleccion}>
                                    <label data-bloque="bloque-${(i+1)+"-"+(y-1)}" id="examen-${(i+1)}" for="customCheck-examen-${i+"-"+y}" class="col-2 flex align-items-center" ><span></span></label>
                                    <a id="${(i+1)+"-"+(parseInt(y-1))}" data-idexamenbase="${datos[i][0][0]}" data-desbloqueo="desbloqueo-${i}" style="${cursor_pointer}" class="mostrar-examen col-10 nav-link font-actividades ${examen}">Examen ${i+1}</a>
                                </div>`;
                        }else if(y == 1){
                            template += `
                            <div class="demo contenedor cont-actividades">
                                <div class="flex align-items-center temas-hover border-bottom ${color_lista}">
                                    <input type="checkbox" id="customCheck-bloque-${(i+1)+"-"+(y-1)}" name="example1" ${control_seleccion}>
                                    <label id="bloque-${(i+1)+"-"+(y-1)}" for="customCheck-bloque-${(i+1)+"-"+(y-1)}" class="col-2 flex align-items-center"><span class="registro_tema"></span></label>
                                    <a data-idbloquebase="${datos[i][1]}" data-idactividad="${(i+1)+"-"+(y-1)}" style="cursor: pointer; font-weight: bold;" id="span-${(i+1)+"-"+(y-1)}" class="mostrar-actividad col-10 spam nav-link font-actividades">${datos[i][2]}</a>
                                </div>
                                <div class="span-${(i+1)+"-"+(y-1)} ${color_lista}" style="display: none;">`;
                                cont = 0;
                            for(z = 0; z< datos[i][3].length; z++){
                                    if(control_seleccion == 'checked' && datos[i][3][0][5] == 0 && cont == 0){
                                        control_seleccion = "checked";
                                        //guardo el id proviniente de la base de datos del tema
                                        id_actual_base = datos[i][3][z][0];
                                        //guardo el link del video para mostrarlo
                                        control_video = datos[i][3][z][3];
                                        //guardo el id con el que se lleva el control del cambio de la infomacion del tema
                                        id_control_direccionamiento = (i+1)+"-"+(z+1); 
                                        cont++;
                                    }
                                    if(datos[i][3][z][5] == 1){
                                            //guardo el id proviniente de la base de datos del tema
                                            id_actual_base = datos[i][3][z][0];
                                            control_seleccion = "checked";
                                            //guardo el link del video para mostrarlo
                                            control_video = datos[i][3][z][3];
                                            //guardo el id con el que se lleva el control del cambio de la infomacion del tema
                                            id_control_direccionamiento = (i+1)+"-"+(z+1);
                                            cont++;
                                    }else{
                                        control_seleccion = "disabled";
                                    }
                                    template +=
                                    `<div class="demo pt-1 m-0 flex align-items-center temas-hover border-bottom ${color_lista}">
                                        <input class="" type="checkbox" id="customCheck-${(i+1)+"-"+(z+1)}" name="example1" ${control_seleccion}>
                                        <label data-idtemabase="${datos[i][3][z][0]}" id="tema-${(i+1)+"-"+(z+1)}" for="customCheck-${(i+1)+"-"+(z+1)}" class="${control_del_chequeo} col-3 text-justify desbloqueo-${i} pl-4 flex align-items-center"><span class="registro_tema"></span></label>
                                        <a id="${(i+1) +"-"+(z+1)}" class="col-9 mostrar-tema" style="${cursor_pointer_temas} font-family: 'Poppins:100', sans-serif; font-size: 14px; color: rgb(87, 87, 87);">${datos[i][3][z][1]}</a>
                                     </div>`;  
                            }
                        }else if(y == 4){
                            for(z = 0; z< datos[i][4].length; z++){
                                template += `
                                        <div class="tarea-${(i+1)+"--"+1} ${bloque_tarea} ${color_lista}">
                                        <div class="text-center">Tareas</div>
                                        <div class="pt-3 row justify-content-between">
                                        <button data-idtareabase="${datos[i][4][0][0]}" data-idbloque="${datos[i][1]}" class="col-5 mostrar-tareas btn boton-tarea btn-light" href="#seccion-tareas">Subir</button>
                                            
                                                `;
                                                datdoles = "";
                                                tema = "";
                                                if(datos[i][4][0][3]){
                                                    datos_dow = datos[i][4][0][3].split("/");
                                                    datdoles = datos_dow[2];
                                                    tema = "Descargar"
                                                }else{
                                                    tema = "No hay archivo disponible";
                                                    datdoles = "";
                                                }
                                                template += ` <a class="col-5 btn boton-tarea btn-light" href="${datos[i][4][0][3]}" download="${datdoles}" style="border-radius:5px; padding: 0; line-height:  20px;">${tema}</a>
                                                
                                            
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                                `;
                            }                          
                        }
                    }   
                }
               // console.log(template);
                $('.lista-curso-aside').html(template);
                if(id_actual_base != ""){
                    obtenerMostrarDatosTema(id_actual_base);
                    $("#"+checkeo_final).click();
                    $("#tema-"+id_control_direccionamiento).next().addClass("text-info");
                }else{
                    mostrarInfoCurso();
                }
            }
        });
    }

    function mostrarInfoCurso(){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"mostrarCursos=mostrarCursos",

            success: function(response){
                datos_curso = JSON.parse(response);
                template_video = `
                <iframe id="video" src="${datos_curso[0][4]}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                `;
                $("#jalaporfa2").html(template_video);
                $(".descripcion-tema").html(datos_curso[0][2]);
            }
        });
    }

/*     function obtenerProgresoDelCurso(){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"progresoDelCurso=progresoDelCurso",

            success: function(response){
                progreso = "."+response;
                $('.loader').attr('data-perc',progreso);
                $('.loader').data("perc",progreso);
                console.log(progreso);
                console.log( $('.loader'));
            }
        })
    } */

    function obtenerMostrarDatosTema(id_de_base){
        $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:"DatosTemaAcutual="+id_de_base,

            success: function(response){
                //console.log(response);
                datos_tema = JSON.parse(response);
                //console.log(datos_tema);
                if(datos_tema[0][3]){
                datos_download = datos_tema[0][3].split("/");
                dat = datos_download[2];
                }else{
                dat = "no existe archivo";
                }
                $('.descarga').attr("href",datos_tema[0][3]);
                                template_video = `
                <iframe id="video" src="${datos_tema[0][0]}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                `;
                $("#jalaporfa2").html(template_video);
                $(".descripcion-tema").html(datos_tema[0][2]);
                $('.descarga').attr("download",dat);
                leer_iframe();
                confeti();
            }
        });
    }

    $(document).on('click','.mostrar-tema',function(){
        if($(this).prev().hasClass("temas_vistos")){
           $("#cambio-examen-video").removeClass("d-none");
            $("#contenido-examen").addClass("d-none");
            id_de_base = $(this).prev().data("idtemabase");
            obtenerMostrarDatosTema(id_de_base);
            $("#tema-"+id_control_direccionamiento).next().removeClass("text-info");
            id_actual_base = id_de_base;
            datos = $(this).prev().attr("id").split("-");
            id_control_direccionamiento = datos[1]+"-"+datos[2];
            $(this).addClass("text-info");
        }
    });

    $(document).on("click",".temas_vistos",function(){
        $(this).prev().removeAttr("disabled");
        registrarTemaCompletado($(this).data("idtemabase"));

    });



        // MOSTRAR EXAMEN AL HACER CLIC EN EL ENLACE
        $(document).on("click",".mostrar-examen", function () {
        if($(this).hasClass('realizado') == false){
/*             var iframe = $(document).find("#jalaporfa2 iframe");
            console.log(iframe);
            var player = new Vimeo.Player(iframe);
            player.pause().then(function() {
                console.log("entro");
              }).catch(function(error) {
                switch (error.name) {
                  case 'PasswordError':
                      // The video is password-protected
                      break;
              
                  case 'PrivacyError':
                      // The video is private
                      break;
              
                  default:
                      // Some other error occurred
                      break;
                }
              }); */
            idExamen_seleccionado = $(this).attr("id");
            //$('#'+idExamen_seleccionado).prev('label').prev('input').attr('checked','true');
            $("#cambio-examen-video").addClass("d-none");
            $("#contenido-examen").removeClass("d-none");
            $.ajax({
                url:"../controllers/dashboard.php",
                type:"POST",
                data:"examenBLoques="+$(this).data("idexamenbase"),

                success: function(response){
                    datos = JSON.parse(response);
                    let contador_pregunta = 1;
                    templete2 = `
                    <br>
                    <h3 class="h3">${datos[0][0]}</h3>
                    <hr>`;
                    $.each(datos, function (i, item) {
                        templete2 += `
                            <div class="pregresp flex justify-content-center d-inline-block">
                                <div class="pregunta">
                                  <h3>${contador_pregunta +".- "+item[2]}</h3>
                                </div>
                                <div class="respuestas d-inline-flex flex justify-content-between">`;
                                respuestas = item[3].split('-*3');
                                cont_examen_preguntas ++;
                                for(y = 0; y < respuestas.length; y++){
                                    nueva = respuestas[y].split('###');
                                    if(nueva[0] == ''){
                                    templete2 += `<li class="list-inline p-2 ml-5"><input data-idpregunta="${item[1]}" id="sal-${(i+1)+"-"+(y+1)}" class="examen" name="nombre-${i}" type="radio" value="1"><span class="estado text-dark">${nueva[1]}</span><i class="ml-3"></i></li>`; 
                                    }else{
                                    templete2 += `<li class="list-inline p-2 ml-5"><input data-idpregunta="${item[1]}" id="sal-${(i+1)+"-"+(y+1)}" class="examen" name="nombre-${i}" type="radio" value="0"><span class="text-dark">${respuestas[y]}</span><i class="ml-3"></i></li>`; 
                                    }
                                }
                        contador_pregunta++     
                        templete2 +=`</div></div><hr>`;
                    });
                    templete2 +=`
                    <div class="alert alert-dark d-none alerta-examen" role="alert"></div>
                    <button class="ir-actividad">Enviar respuestas</button>
                    <button class="cancelar">Cancelar</button>
                    `;
                    $("#contenido-examen").html(templete2); 
                }
            });
        }
    });
    
    
    $(document).on('click','.cancelar',function(){
        $("#cambio-examen-video").removeClass("d-none");
        $("#contenido-examen").addClass("d-none");
    });

    $(document).on('click','.examen',function(){
        preguntas = $(this).attr("id").split("-");
       for(i=1; i<=4; i++){
            $("#sal-"+preguntas[1]+"-"+i).removeClass("selected-user");
        } 
        $(this).addClass("selected-user");
    });
    
    $(document).on('click','.ir-actividad',function(){
        $(".cancelar").hide();
        preguntas_id = "";
        calificacion = 0;
        respuestas_examen = "";
        for(y=0; y < $('.selected-user').length; y++){
            preguntas_id += "$" + $(".selected-user").eq(y).data("idpregunta");
            respuestas_examen += "$" + $(".selected-user").eq(y).next("span").text();
            if($('.selected-user').eq(y).val() != '0'){
                calificacion++;
                $(".selected-user").eq(y).next("span").removeClass("text-dark").addClass("text-success");
                $(".selected-user").eq(y).next("span").next("i").addClass("fas fa-check-circle text-success");
            }else{
                $(".selected-user").eq(y).next("span").removeClass("text-dark").addClass("text-danger");
                $(".selected-user").eq(y).next("span").next("i").addClass("fas fa-times-circle text-danger");
                $(".estado").removeClass("text-dark").addClass("text-success");
                $(".estado").next("i").addClass("fas fa-check-circle text-success");
            }
        }
        porsentaje = 100 / parseInt(cont_examen_preguntas);
        puntaje_alumno = porsentaje * parseFloat(calificacion);
        const postada = {
            respuestaExamen:"preguntas",
            preguntas_id:preguntas_id,
            respuestas_examen:respuestas_examen,
            puntaje_alumno:puntaje_alumno
        };
         $.ajax({
            url:"../controllers/dashboard.php",
            type:"POST",
            data:postada,
            success: function(response){
                $('.alerta-examen').removeClass("d-none");
                $('.ir-actividad').addClass("d-none");
                if(response != 0){
                    $('.alerta-examen').html("<p class='h3'>Tu califuacion es: <span>"+ puntaje_alumno +"</span><br><input class='seguir-curso btn btn-primary' value='seguir' type='button'></p>");       
                }else{
                    $('.alerta-examen').html("<p class='h3'>Tu califuacion es: <span>"+ puntaje_alumno +"</span><br><input class='seguir-curso btn btn-primary' value='seguir' type='button'></p>");
                    
                }
            }
        }); 
    });

    $(document).on('click','.seguir-curso',function(){
        location.reload();
    });

    $("#subir-tareas").submit(function(e){
        $(".actuali-homework").val(id_tarea);
        $(".bloque-archivo").val(id_bloque);
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../controllers/dashboard.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            
            success: function (response) {
                $("#alertas").addClass('alert-danger');
                $("#alertas").removeClass('alert-success');
                if(response == 1){
                    $("#alertas").removeClass('alert-danger');
                    $("#alertas").addClass('alert-success');
                    $("#alertas").html('<i class="fas fa-check-circle m-2"></i>Registro Exitoso');
                    $("#alertas").slideDown("slow");
                    setTimeout(function(){
                        $("#alertas").slideUp("slow");
                      }, 3000);
                    $("#subir-tareas").trigger("reset");
                    obtenerTareasBloque(id_bloque);
                        pintarTablaTareaBloque(id_bloque);
                        
                }else if(response == "tareaExist"){
                    $("#alertas").html('<i class="fas fa-times-circle m-2"></i></i>Ya existe una tarea en el bloque');
                    $("#alertas").slideDown("slow");
                    setTimeout(function(){
                        $("#alertas").slideUp("slow");
                      }, 3000);
                }else{
                    $("#alertas").html('<i class="fas fa-exclamation-triangle m-2"></i>Ups, algo salio mal,Por favor intentalo de nuevo');
                    $("#alertas").slideDown("slow");
                    setTimeout(function(){
                      $("#alertas").slideUp("slow");
                    }, 3000);
                }
            }
          });
    });



    // MOSTRAR ACTIVIDAD AL COMPLETAR EL EXAMEN


    $(document).on('click',".nada",function(){
        $("#cambio-examen-video").removeClass("d-none");
        setTimeout(function() {$("#contenido-examen").html("");$("#contenido-examen").addClass("d-none");},200);
    });


    if ($(window).width() < 768) {
        $(contenido).prependTo("#nav-barra");
        $(contenidoCom).appendTo("#nav-barra");
        $("#mov-div").detach().appendTo('#contenido-cursos');
        $("#mov-coments").detach().appendTo('#contenido-comentarios');
        $("#nav-status").removeClass("active");
        $("#descripcion").removeClass("active");
        $("#contenido-cursos").removeClass("fade");
        $("#contenido-cursos").addClass("active");
        $("#scroll-responsive").addClass("scroll");
        $("#nav-barra").addClass("scrollmenu");
        $("#scroll-responsive").css("height", "30rem");
        $("#contenido-cursos").css("height", "100%");
        $(".bg-color-lista").css("height", "170%");
        $("#navdash").removeClass("d-inline-flex");
        $("#tam-pantalla").css("height", "100%");
        $("#subir-tareas").removeClass("d-inline-flex");
    }
    if ($(window).width() > 768) {
        $("#nav-status").addClass("active");
        $("#descripcion").addClass("active");
        $(".rem-nav").remove();
        $("#mov-div").detach().appendTo('#div-original');
        $("#mov-coments").detach().appendTo('#div-original-comentarios');
        $("#scroll-responsive").removeClass("scroll");
        $("#nav-barra").removeClass("scrollmenu");
        $("#scroll-responsive").css("height", "15rem");
        $(".bg-color-lista").css("height", "100%");
        $("#tam-pantalla").css("height", "50%");
        $("#subir-tareas").addClass("d-inline-flex");

    }

    $(document).ready(function () {
        var height = $(window).height();
        $('#tam-pantalla').height(height);
    });

    //CONFEEEETTIIIIIIII

    $.ajax({
        url: "../controllers/dashboard.php",
        type: "POST",
        data: {'confeti': confeti},
        
        success: function (response) {

        }
      });


 //CONFEEEETTIIIIIIII
    function confeti(){
        $.ajax({
            url: "../controllers/dashboard.php",
            type: "POST",
            data: 'confeti=confeti',
            
            success: function (response) {
                if(response == 'completado'){
                    if(contador == 0){
                        $('#startConfetti').click();
                        swal("¡Felicidades!, haz completado este curso 🎉🎉");
                        setTimeout(function(){
                        $('#stopConfetti').click();
                        }, 5000);
                        contador++;
                    }
                }
                
                
            }
        });
    }

    
  


    /* VERIFICAR SI ESTA MARCADA EL CHECKBOX  */

    
    

/*     $(document).on('click', '.chk-examen', function () {
        ctrolId = $(this).attr("id");
        console.log(ctrolId);
        if ($("#" + ctrolId).is(':checked')) {
            $("." + ctrolId).slideToggle();

        } else {
            $("." + ctrolId).slideToggle();
        }
    }); */

/*     $(document).on('click','.cont-bloque',function(){
        console.log("llehoestamadre");
        $(this).show();
    }); */

    // CAMBIAR A SELECCIONADO CUANDO TIENE ALGO EL INPUT
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    
    function leer_iframe(){
             setTimeout(function(){
        
        var iframe = $(document).find("#jalaporfa2 iframe");
        var player = new Vimeo.Player(iframe);
        
        player.on('ended', function() {
            //se separa el id actual para sumarle un numero mas (Para cambiar al siguiente tema)
            datos_redirect = id_control_direccionamiento.split("-");
            //Lo formamos el siguiente tema
            id_redirecionado = datos_redirect[0]+"-"+(parseInt(datos_redirect[1])+1);
            //verificaos si el tema existe
            if($("#tema-"+id_redirecionado).length > 0){
                //checkeamos el tema actual
                $("#tema-"+id_control_direccionamiento).prev().attr('checked','true');
                //Se remueve la clase que lo identifica como activo
                $("#tema-"+id_control_direccionamiento).next().removeClass("text-info");
                //Realizar registro del tema
                registrarTemaCompletado(id_actual_base);
                //obtenemos los datos del nuevo tema para pintarlos
                obtenerMostrarDatosTema($("#tema-"+id_redirecionado).data("idtemabase"));
                //Le agregamos la clase para indentificarlo activo
                $("#tema-"+id_redirecionado).next().addClass("text-info");
                //igualamos la variable global a el tema actual
                id_control_direccionamiento = id_redirecionado;
                //tomamos el id de la base del tema actual
                id_actual_base = $("#tema-"+id_redirecionado).data("idtemabase");
            }else{
                //si el id siguiente no existe se brincara al examen
                $("#tema-"+id_control_direccionamiento).prev().attr('checked','true');
                registrarTemaCompletado(id_actual_base);
                id_examen = (parseInt(datos_redirect[0])+1)+"--1";
                $("#"+id_examen).click();
            }
   
        }); 
        }, 4000);   
    }
    
});
