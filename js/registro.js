$(document).ready(function () {

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

