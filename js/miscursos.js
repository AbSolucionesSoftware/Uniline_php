$(document).ready(function () {
    datosUsuario();

    function datosUsuario() {
        $.ajax({
            url: "../controllers/cursos_alumno.php",
            type: "POST",
            data: 'datos=datos',

            success: function (response) {
                if (response == 'sin-alumnos') {
                    $('#hay-cursos').html('No tienes cursos');
                }
                if (response != "") {
                    let datos = JSON.parse(response);
                    template = '';
                    $('#hay-cursos').html('Mis cursos');
                    for (i = 0; i < datos.length; i++) {
                        url = datos[i][5].split("/");
                        url_2 = url[0]+"/"+url[1]+"/res_"+url[2];
                        template +=`
                            <tr data-idcurso="${datos[i][2]}" style="cursor:pointer;" class="go-to-curso" data-toggle="tooltip" title="Ir a ${datos[i][3]}">
                                <td class="align-middle" style="max-width: 16rem; min-width: 9rem;" scope="row"><img class="img-fluid"  src=${url_2} alt="logo-html5"></td>
                                <td id="nombre-curso" class="align-middle"><h2 class="h3">${datos[i][3]}</h2></td>
                            </tr>
                    `;
                    }
                    $('#lista-tabla-cursos').html(template);
                }
            }
        });
    }

    $(document).on('click','.go-to-curso',function(){
        if($(this).data("idcurso") != ""){
            window.location.replace('../views/dashboard.php?idcurso=' + $(this).data("idcurso"));
        }
    });
});