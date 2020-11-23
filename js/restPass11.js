$(document).ready(function(){
    
    $(document).on("click","#correcto",function(){
        location.href ="../views/mainpage.php";
    });
    
    $("#resetPass").submit(function(e){
        e.preventDefault();
        primerPass = $("#new-pass").val();
        segundaPass = $("#confirm-new-pass").val();
        if(primerPass == segundaPass){
            const datos = {
                newPass:primerPass,
                correo:$("#con_email").val()
            }
            $.ajax({
                url:"../controllers/reset_pass.php",
                type:"POST",
                data:datos,

                success: function(response){
                    if(response == "1"){
                        $("#hidden-div").addClass("d-none");
                        $("#guardar").addClass("d-none");
                        $("#correcto").removeClass("d-none");
                        $("#alert_pass").slideDown("slow");
                        $("#alert_pass").removeClass("alert-danger");
                        $("#alert_pass").addClass("alert-success");
                        $("#alert_pass").html(
                            "<h5>¡Listo! Tu contraseña a sido actualizada</h5>"
                        );
                    }else{
                        $("#alert_pass").slideDown("slow");
                        $("#alert_pass").html("<p>Oh, oh parece que las contrasenas no coinciden</p>");
                    }
                }
            });
        }else{
            $("#alert_pass").slideDown("slow");
            $("#alert_pass").html("<p>Oh, oh parece que las contrasenas no coinciden</p>");
        }
    });
});