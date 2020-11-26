$(document).ready(function () {
    let templete2 = ``;
    obtener_Cursos();
    //// algunos modales
    $(".closeCon").on("click", function (e) {
        location.reload();
    });
    $("#ir-a-registro").on("click", function (e) {
        $("#login").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $(document).on("click", "#idprueba", function () {
        $("#autobtn").click();
    });
    $("#confirmar").hide("slow");

    /* <---------------------scroll para cambiar logo-----------------------> */
    $(function () {
        $(document).scroll(function () {
            if ($(this).scrollTop() > 120) {
                $('#logo-imagen').attr('src', '../img/uniline2.png')
            }
            if ($(this).scrollTop() < 120) {
                $('#logo-imagen').attr('src', '../img/uniline3.png');
            }
        });
    });

    /* <---------------------Pintar el body del modal y los loques del curso-----------------------> */
    $(document).on("click", ".curso", function () {
        curso = $(this).data("curso");
        templeteT = "";
        templete = "";
        $.ajax({
            url: "../controllers/contenido_index.php",
            type: "POST",
            data: "cursos-modal=" + curso,

            success: function (response) {
                let datos = JSON.parse(response);
                $.each(datos, function (i, item) {
                    templeteT += `
                    <div class="row mb-2 title-responsive">
                        <div class="col-lg-9 col-sm-12 ml-0">
                            <p class="h3 text-bold" style="color:black"><strong>${item[1]}</strong></p>
                        </div>
                        
                    </div>
                    <button type="button w-2" class="fas fa-times close closeModalCurso" style="font-size: 30px;" data-dismiss="modal"></button>
                    `;
                    templete += `
                    <div id="videoModal" class="row mt-0"> 
                        <iframe class="responsive-video" src="${item[8]}" width="640" height="346" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe> 
                    </div>
                    
                
                    <div class="border-bottom  title-responsive">
                    
                        <div class="row d-flex">
                            <div class="col-lg-9 col-sm-12 d-sm-inline-block px-5 order-1">
                                <p class="h3 mt-5 text-info"><strong>Descripción:</strong></p>
                                <p class="h4 mt-5 text-justify inter" style="line-height:30px;color:black;">${item[2]}</p>
                            </div>
                            <div class="flex col-lg-3 col-sm-4 justify-content-center align-items-center d-lg-inline-flex d-sm-inline-block order-sm-2">
                                <div class="flex d-lg-block mt-5">
                                    <button type="button" value="${curso}" class="d-sm-inline-flex mb-2 item-comprar btn btn-lg text-white compras" style="background-color: #fd5601; " data-dismiss="modal">Comprar</button>
                                    <div class="d-sm-inline-flex p-4 align-items-center justify-content-center text-center" style="background-color: #373d3d; max-width: 14.5rem; max-height: 62px;" >
                                    <span class="text-white text-center" style="width: 14.5rem;">$${datos[i][7]} MX</span>
                                    </div> 
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    `;
                });
                $.ajax({
                    url: "../controllers/contenido_index.php",
                    type: "POST",
                    data: "cursos-contenido=" + curso,
                    success: function (response) {
                        let datos = JSON.parse(response);
                        templete += `                    
                        <div class="title-responsive" style="width: 765px">
                            <p class="h3 p-2 cont-curso-responsive clickear" style="margin-left:280px;color:black;"><strong>Contenido del curso</strong></p>`;
                        $.each(datos, function (i, item) {
                            templete += `
                                <div class="col-12 border-bottom slide-content-curso m-0" style="cursor:pointer;">
                                    <div class="row">
                                        <div class="col-12">
                                            <p style="cursor:pointer;color:black;" data-bloque="bloque-${
                                item[0]
                                }" class="h4 cursos-slide font-italic" style="color:black;">Capítulo ${i +
                                1}</p>
                                        </div>
                                        <div data-temas="bloque-${item[2]}-${
                                item[0]
                                }" class="row ml-5 bloque-${item[0]}" style="display: none">
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        templete += `</div>`;
                        $(".header-curso").html(templeteT);
                        $(".view-curso").html(templete);
                        $("#date-modal").click();
                    }
                });
            }
        });
    });


    /* <--------------------- Generar checkout de pago de stripe -----------------------> */
    $(document).on("click", ".compras", function (event) {
        let idcurso = $(this).val();
        templete = "";
        templete = `<iframe class="responsive-video" src="" width="640" height="346" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
        $("#videoModal").html(templete);
        $.post("../controllers/checkout.php", { idcurso: idcurso }, function (
            response
        ) {
            switch (response) {
                case "login":
                            swal(
                                "Alerta!",
                                "Es necesario registrarse",
                                "info"
                            );
                    break;

                case "pagado":
                    window.location.replace("../views/dashboard.php?idcurso=" + idcurso);
                    break;

                default:
                    var stripe = Stripe("pk_live_eDjWfiO9ESs6N7s7tAek4d2n00bEJUW51W");
                    stripe
                        .redirectToCheckout({
                            sessionId: response
                        })
                        .then(function (response) {
                            swal(
                                "Alerta!",
                                "La compra ha fallado intente de nuevo o contacte a soporte técnico",
                                "info"
                            );
                            //imprimir mensaje ocurrio un problema
                            // si elgo sale mal usar aqui para debuggear: `result.error.message`para informarle el error al usuario
                        });
                    break;
            }
        });
    });

    function CierraPopup() {
        $("#modal-cursos").modal("hide"); //ocultamos el modal
        $("body").removeClass("modal-open"); //eliminamos la clase del body para poder hacer scroll
        $(".modal-backdrop").remove(); //eliminamos el backdrop del modal
    }

    /* <---------------------Desplegar el contenido del curso e imprime los temas -----------------------> */
    $(document).on("click", ".cursos-slide", function () {
        contenido = $(this).data("bloque");
        temas = $("." + contenido).data("temas");
        datos_tema = temas.split("-");
        $.ajax({
            url: "../controllers/contenido_index.php",
            type: "POST",
            data: "temas-bloque=" + datos_tema[2],
            success: function (response) {
                let datos2 = JSON.parse(response);
                templete2 = "";
                $.each(datos2, function (y, item2) {
                    templete2 += `     
                            <div class="col-12 temas-curso-responsive">
                                <p class="h5 text-justify font-italic ml-2 text-center text-lg-left margin-responsive" style="color:black;"> ${item2[1]}</p>
                            </div>
                            `;
                });
                $("." + contenido).html(templete2);
            }
        });
        setTimeout(function () {
            $("." + contenido).slideToggle("slow");
        }, 150);
    });
    /* <---------------------Mostrar el div seleccionado del curso-----------------------> */
    $(document).on("click", ".mostrar", function (e) {
        e.preventDefault();
        controlId = $(this).attr("id");
        $(".page-activo").addClass("d-none");
        $(".row").removeClass("page-activo");
        $("." + controlId).addClass("page-activo");
        $("." + controlId).removeClass("d-none");
    });
    /* <---------------------Pintar los cursos-----------------------> */
    function obtener_Cursos() {
        $.ajax({
            url: "../controllers/contenido_index.php",
            type: "POST",
            data: "cursos=cursos",
            success: function (response) {
                let datos = JSON.parse(response);
                let templete = ``;

                ocultar = "";
                contdador_page = 0;
                cont = 0;
                total = 0;
                totaldatos = datos.length;
                if (datos.length % 4 == 0) {
                    total = Math.round(datos.length / 4);
                } else {
                    total = Math.round((datos.length + 1) / 4);
                }

                for (i = 0; i < datos.length; i++) {
                    let url_2 = "";
                    let url_3 = "";
                    let url = "";
                    let url3 = "";
                    cont++;
                    if (i != 0) {
                        ocultar = "d-none";
                    }
                    url = datos[i][7].split("/");
                    url_2 = url[0] + "/" + url[1] + "/min_" + url[2];
                    url3 = datos[i][3].split("/");
                    url_3 = url[0] + "/" + url3[1] + "/res_" + url3[2];
                    if (i % 4 == 0) {

                        contdador_page++;
                        templete += `<div class="row course_boxes page-${contdador_page} ${ocultar} page-activo">`;
                    }
                    templete += `
                                    <div class="col-lg-3 course_box bor-responsive item"  style="box-shadow: 0px 0px 9px -2px rgba(0,0,0,0.75);">
                                        <div class="card text-center" style="border-radius:2rem;">
                                            <img class="responsive-image"  width="250px" height="150px"  src="${url_3}" alt="Imagen del curso ${datos[i][1]}">
                                            <div class="card-body text-center">
                                            <p class="h4 font-weight-bold" style="height: 38px;" >${datos[i][1]}</p>               
                                            </div>
                                            <div class="row">
                                               <div class="col-6">             
                                                    <div class="text-center mt-5">
                                                        <div class="card-text">
                                                            <strong>${datos[i][5]} Hrs</strong>
                                                        </div>
                                                        <div class="star" style="color: yellow">
                                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                                            <i class="far fa-star" style="cursor: pointer;"></i>
                                                        </div>
                                                    </div>
                                               </div>
                                               <div class="col-6">
                                                <div>
                                                <img src="${url_2}" class="course_author_image"  alt="Imagen del profesor ${datos[i][6]}">
                                                    </div>
                                                    <div style="height:36px; margin; 0 auto;">
                                                        <span>${datos[i][6]}</span>
                                                    </div> 
                                               </div> 
                                                
                                            </div>
                                            <div class="card-text mt-3 text-center">
                                                <div>
                                                    <div>
                                                        <button type="button" class="curso btn btn-primary text-white more-cursos-responsive" data-curso="${datos[i][0]}" style="cursor: pointer;">Descripción del curso</button>
                                                    </div>
                                                    <div class="row justify-content-between" style="margin:2rem 0rem;">
                                                        <button type="button" value="${datos[i][0]}" class="item-comprar col-6 btn boton-compra text-center hover-boton compras" data-dismiss="modal" style=" background-color: #fd5601; color: white;">
                                                            COMPRAR
                                                        </button>  
                                                        <div class="col-5 div-precio d-flex flex-column align-items-center justify-content-center" style="background-color: #373d3d;" >
                                                                <span class="text-white">$${datos[i][8]} MX</span>
                                                        </div>  
                                                    
                                                    </div>       
                                                </div>              
                                            </div>

                                        </div>
                                    </div>
                                    `;
                    if (cont % 4 == 0 || totaldatos == cont) {
                        templete += `</div>`;
                    }
                }
                templete += `                
            <div class="row m-5">
                <div class="col-12 text-center">
                 `;
                for (y = 0; y < contdador_page; y++) {
                    if (y == 0) {
                        templete += `<a id="page-${y +
                            1}" class="m-2 mostrar h4 estado-activo" href="#">${y + 1}</a>`;
                    } else {
                        templete += `<a id="page-${y +
                            1}" class="m-2 mostrar h4" href="#">${y + 1}</a>`;
                    }
                }
                templete += `
                </div>
            </div>`;

                $(".cursos").html(templete);
            }
        });
    }

    ////>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    //// animacion para todos los enlaces que te lleven a un div dentro de la misma pagina
    $(document).on("click", ".cambiarContacto", function (e) {
        e.preventDefault(); //evitar el eventos del enlace normal
        var strAncla = $(this).attr("href"); //id del ancla
        $("body,html,header")
            .stop(true, true)
            .animate(
                {
                    scrollTop: $(strAncla).offset().top
                },
                2000
            );
    });

    $(document).on('keyup', '#registrar-pass', function () {
        if ($("#registrar-pass").val().length < 8) {
            $("#alertas").removeClass("alert-success");
            $("#alertas").addClass("alert-danger");
            $("#alertas").html("<h5>Contraseña corta<h5/>");
            $("#alertas").slideDown("slow");
            setTimeout(function () {
                $("#alertas").slideUp("slow");
            }, 2000);
        } else if ($("#registrar-pass").val().length >= 8) {
            $("#alertas").removeClass("alert-danger");
            $("#alertas").addClass("alert-success");
            $("#alertas").html("<h5>Contraseña aceptable<h5/>");
            $("#alertas").slideDown("slow");
        }
    });

    $("#registro").submit(function (e) {
        e.preventDefault();
        $("#btnSubmit").attr("disabled", true);
        if (
            $("#registrar-nombre").val() == "" ||
            $("#registrar-correo").val() == "" ||
            $("#registrar-pass").val() == ""
        ) {
            $("#alertas").removeClass("alert-success");
            $("#alertas").addClass("alert-danger");
            $("#alertas").html("<h5>Por favor llene todos los campos</h5>");
            $("#alertas").slideDown("slow");
            setTimeout(function () {
                $("#alertas").slideUp("slow");
            }, 3000);
             $("#btnSubmit").attr("disabled", false);
        } else {
            if ($("#registrar-pass").val().length >= 8) {
                $("#hope").removeClass("d-none");
                $.ajax({
                    url: "../controllers/registro.php",
                    type: "POST",
                    data: $("#registro").serialize(),

                    success: function (response) {
                        $("#hope").addClass("d-none");
                        if (response == "Existe") {
                            $("#alertas").removeClass("alert-success");
                            $("#alertas").addClass("alert-danger");
                            $("#alertas").html("<h5>Este usuario ya esta registrado</h5>");
                            $("#alertas").slideDown("slow");
                            setTimeout(function () {
                                $("#alertas").slideUp("slow");
                            }, 3000);
                        } else if (response == "error") {
                            $("#alertas").removeClass("alert-success");
                            $("#alertas").addClass("alert-danger");
                            $("#alertas").html(
                                "<h5>Ups! hubo un error, intentelo de nuevo</h5>"
                            );
                            $("#alertas").slideDown("slow");
                            setTimeout(function () {
                                $("#alertas").slideUp("slow");
                            }, 3000);
                        } else {
                            $("#registro").trigger("reset");
                            location.href ="info_correo.php";
                            $("#alertas").removeClass("alert-danger");
                            $("#alertas").addClass("alert-success");
                            $("#alertas").html(
                                "<h5>¡Listo! te enviamos un e-mail a tu correo para verificar tu cuenta</h5>"
                            );
                            $("#alertas").slideDown("slow");
                            setTimeout(function () {
                                $("#alertas").slideUp("slow");
                            }, 3000);
                        }
                        $("#btnSubmit").attr("disabled", false);
                    }
                });
            } else {
                $("#hope").addClass("d-none");
                $("#alertas").removeClass("alert-success");
                $("#alertas").addClass("alert-danger");
                $("#alertas").html("<h5>Contraseña corta<h5/>");
                $("#alertas").slideDown("slow");
                setTimeout(function () {
                    $("#alertas").slideUp("slow");
                }, 2000);
                 $("#btnSubmit").attr("disabled", false);
            }
        }
    });

    $(document).on('click', '.closeModalCurso', function () {
        templete = "";
        templete = `<iframe class="responsive-video" src="" width="640" height="346" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
        $("#videoModal").html(templete);
    });

});

$(document).ready(function() {
    let sesion = ""; 

    verisesion();

    function verisesion(){
    $.post("../controllers/registro.php","sesion=sesion", function(response) {
            sesion = response;
        });
    }

    function pintarItems() {
        let template = `<option value="">Del Curso...</option>`;
        $.post("../controllers/cupones.php", {
            accion: "items"
        }, function(response) {
            const datos = JSON.parse(response);
            datos.forEach(function(item) {
                template += `
                    <option value="${item[0]}">${item[1]}</option>
                    `;

            });
            $('select').html(template);
        })
    }
    pintarItems();

    /* $(document).on('submit', '#FCupones', function(e) {
        e.preventDefault();
        if(sesion != "" ){
            if ($('#codigo').val().length != 0 && $('#curso').val().length != 0) {
            $.post("../controllers/cupones.php", $(this).serialize() + "&accion=editar", function(response) {
                console.log(response);
                if (!response.includes('1')) {
                    swal("Codigo Invalido", "Verifique sus datos o intentelo mas tarde", "warning");
                } else {
                   // pintarTabla(); descomentar ya que se haya integrado en un solo js
                      window.location.replace("../views/misCursos.php");
                }
            })
            $(this)[0].reset();
            } else {
                swal("Datos Incompletos", "Por favor llene todos los campos o inicie sesion", "warning");
            }
        }else{
            swal("Datos Incompletos", "Es necesario tener cuenta para realizar esta accion", "warning");
        }
    }) */
})
