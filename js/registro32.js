$(document).ready(function() {
	let templete2 = ``;
	obtener_Cursos();
	//// algunos modales
	$('.closeCon').on('click', function(e) {
		location.reload();
	});
	$('#ir-a-registro').on('click', function(e) {
		$('#login').modal('hide');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
	});

	$(document).on('click', '#idprueba', function() {
		$('#autobtn').click();
	});
	$('#confirmar').hide('slow');

	/* <---------------------scroll para cambiar logo-----------------------> */
	$(function() {
		$(document).scroll(function() {
			if ($(this).scrollTop() > 120) {
				$('#logo-imagen').attr('src', '../img/uniline2.png');
			}
			if ($(this).scrollTop() < 120) {
				$('#logo-imagen').attr('src', '../img/uniline3.png');
			}
		});
	});

	/* <--------------------- Generar checkout de pago de stripe -----------------------> */
	$(document).on('click', '.compras', function(event) {
		let idcurso = $(this).val();
		templete = '';
		templete = `<iframe class="responsive-video" src="" width="640" height="346" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
		$('#videoModal').html(templete);
		$.post('../controllers/checkout.php', { idcurso: idcurso }, function(response) {
			switch (response) {
				case 'login':
					swal('Alerta!', 'Es necesario registrarse', 'info');
					break;

				case 'pagado':
					window.location.replace('../views/dashboard.php?idcurso=' + idcurso);
					break;

				default:
					var stripe = Stripe('pk_live_eDjWfiO9ESs6N7s7tAek4d2n00bEJUW51W');
					stripe
						.redirectToCheckout({
							sessionId: response
						})
						.then(function(response) {
							swal(
								'Alerta!',
								'La compra ha fallado intente de nuevo o contacte a soporte técnico',
								'info'
							);
							//imprimir mensaje ocurrio un problema
							// si elgo sale mal usar aqui para debuggear: `result.error.message`para informarle el error al usuario
						});
					break;
			}
		});
	});

	function CierraPopup() {
		$('#modal-cursos').modal('hide'); //ocultamos el modal
		$('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
		$('.modal-backdrop').remove(); //eliminamos el backdrop del modal
	}

	/* <---------------------Desplegar el contenido del curso e imprime los temas -----------------------> */
	$(document).on('click', '.cursos-slide', function() {
		contenido = $(this).data('bloque');
		temas = $('.' + contenido).data('temas');
		datos_tema = temas.split('-');
		$.ajax({
			url: '../controllers/contenido_index.php',
			type: 'POST',
			data: 'temas-bloque=' + datos_tema[2],
			success: function(response) {
				let datos2 = JSON.parse(response);
				templete2 = '';
				$.each(datos2, function(y, item2) {
					templete2 += `     
                            <div class="col-12 temas-curso-responsive">
                                <p class="h5 text-justify font-italic ml-2 text-center text-lg-left margin-responsive" style="color:black;"> ${item2[1]}</p>
                            </div>
                            `;
				});
				$('.' + contenido).html(templete2);
			}
		});
		setTimeout(function() {
			$('.' + contenido).slideToggle('slow');
		}, 150);
	});
	/* <---------------------Mostrar el div seleccionado del curso-----------------------> */
	$(document).on('click', '.mostrar', function(e) {
		e.preventDefault();
		controlId = $(this).attr('id');
		$('.page-activo').addClass('d-none');
		$('.row').removeClass('page-activo');
		$('.' + controlId).addClass('page-activo');
		$('.' + controlId).removeClass('d-none');
	});
	/* <---------------------Pintar los cursos-----------------------> */
	function obtener_Cursos() {
		$.ajax({
			url: '../controllers/contenido_index.php',
			type: 'POST',
			data: 'cursos=cursos',
			success: function(response) {
				let datos = JSON.parse(response);
				let templete = `<div class="row">`;

				/* ocultar = "";
                contdador_page = 0;
                cont = 0;
                total = 0;
                totaldatos = datos.length;
                if (datos.length % 4 == 0) {
                    total = Math.round(datos.length / 4);
                } else {
                    total = Math.round((datos.length + 1) / 4);
                } */

				for (i = 0; i < datos.length; i++) {
					let url_2 = '';
					let url_3 = '';
					let url = '';
					let url3 = '';
					/* cont++;
                    if (i != 0) {
                        ocultar = "d-none";
                    } */
					url = datos[i][7].split('/');
					url_2 = url[0] + '/' + url[1] + '/min_' + url[2];
					url3 = datos[i][3].split('/');
					url_3 = url[0] + '/' + url3[1] + '/res_' + url3[2];
					/* if (i % 4 == 0) {

                        contdador_page++;
                        templete += `<div class="row course_boxes page-${contdador_page} ${ocultar} page-activo">`;
                    } */
					templete += `
                                    <div class="col-md-6 col-lg-3 col-sm-12 my-3">
                                        <div class="item m-4">
                                            <div class="d-flex" style="width: 100%; height: 200px;">
                                                <img src="${url_3}" alt="Imagen del curso ${datos[i][1]}" class="img-fluid">
                                            </div>
                                            <div class="px-5 pb-3 bgcolor-card-curso">
                                                <div style="min-height: 50px">
                                                    <h4 class="font-weight-bold">${datos[i][1]}</h4>
                                                </div>
                                                <div class="row mx-2" style="min-height: 50px">
                                                    <img src="${url_2}" class="course_author_image mr-3" alt="Imagen del profesor ${datos[i][6]}">
                                                    <div style="height: 50px; width: 160px;" class="d-flex align-items-center">
                                                        <h5 style="font-size: 18px;">${datos[i][6]}</h5>        
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="star d-inline mr-2" style="color: yellow">
                                                        <i class="fas fa-star" style="cursor: pointer;"></i>
                                                        <i class="fas fa-star" style="cursor: pointer;"></i>
                                                        <i class="fas fa-star" style="cursor: pointer;"></i>
                                                        <i class="fas fa-star" style="cursor: pointer;"></i>
                                                        <i class="far fa-star" style="cursor: pointer;"></i>
                                                    </div>
                                                    <div class="d-inline card-text">
                                                        <strong>${datos[i][5]} Horas de curso</strong>
                                                    </div>
                                                </div>
                                                <div class="my-2">
                                                    <button type="button" class="curso descripcion-curso-boton btn btn-primary text-white more-cursos-responsive" data-curso="${datos[i][0]}" style="cursor: pointer;">Descripción del curso</button>
                                                </div>
                                                <div class="row m-0">
                                                    <div class="col-lg-5 text-center" style="background-color: #373d3d;">
                                                        <h5 class="text-white">$${datos[i][8]} MX</h5>
                                                    </div>
                                                    <div class="col-lg-7 pl-lg-3 p-0">
                                                        <button type="button" value="${datos[i][0]}" class="item-comprar btn boton-compra text-center hover-boton compras" data-dismiss="modal" style=" background-color: #fd5601; color: white;">
                                                            COMPRAR
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;
					/* if (cont % 4 == 0 || totaldatos == cont) {
                        templete += `</div>`;
                    } */
				}
				/* templete += `                
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
                } */
				/* templete += `
                </div>
            </div>`; */
				templete += `</div>`;

				$('.cursos').html(templete);
			}
		});
	}
	/* <---------------------redirecciona a la pagina de los cursos segun el curso elegido -----------------------> */
	$(document).on('click', '.curso', function() {
		if ($(this).data('curso') != '') {
			window.location.replace('../views/descripcioncursos.php?idcurso=' + $(this).data('curso'));
		}
	});

	////>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	//// animacion para todos los enlaces que te lleven a un div dentro de la misma pagina
	$(document).on('click', '.cambiarContacto', function(e) {
		e.preventDefault(); //evitar el eventos del enlace normal
		var strAncla = $(this).attr('href'); //id del ancla
		$('body,html,header').stop(true, true).animate(
			{
				scrollTop: $(strAncla).offset().top
			},
			2000
		);
	});

	$(document).on('keyup', '#registrar-pass', function() {
		if ($('#registrar-pass').val().length < 8) {
			$('#alertas').removeClass('alert-success');
			$('#alertas').addClass('alert-danger');
			$('#alertas').html('<h5>Contraseña corta<h5/>');
			$('#alertas').slideDown('slow');
			setTimeout(function() {
				$('#alertas').slideUp('slow');
			}, 2000);
		} else if ($('#registrar-pass').val().length >= 8) {
			$('#alertas').removeClass('alert-danger');
			$('#alertas').addClass('alert-success');
			$('#alertas').html('<h5>Contraseña aceptable<h5/>');
			$('#alertas').slideDown('slow');
		}
	});

	$('#registro').submit(function(e) {
		e.preventDefault();
		$('#btnSubmit').attr('disabled', true);
		if (
			$('#registrar-nombre').val() == '' ||
			$('#registrar-correo').val() == '' ||
			$('#registrar-pass').val() == ''
		) {
			$('#alertas').removeClass('alert-success');
			$('#alertas').addClass('alert-danger');
			$('#alertas').html('<h5>Por favor llene todos los campos</h5>');
			$('#alertas').slideDown('slow');
			setTimeout(function() {
				$('#alertas').slideUp('slow');
			}, 3000);
			$('#btnSubmit').attr('disabled', false);
		} else {
			if ($('#registrar-pass').val().length >= 8) {
				$('#hope').removeClass('d-none');
				$.ajax({
					url: '../controllers/registro.php',
					type: 'POST',
					data: $('#registro').serialize(),

					success: function(response) {
						$('#hope').addClass('d-none');
						if (response == 'Existe') {
							$('#alertas').removeClass('alert-success');
							$('#alertas').addClass('alert-danger');
							$('#alertas').html('<h5>Este usuario ya esta registrado</h5>');
							$('#alertas').slideDown('slow');
							setTimeout(function() {
								$('#alertas').slideUp('slow');
							}, 3000);
						} else if (response == 'error') {
							$('#alertas').removeClass('alert-success');
							$('#alertas').addClass('alert-danger');
							$('#alertas').html('<h5>Ups! hubo un error, intentelo de nuevo</h5>');
							$('#alertas').slideDown('slow');
							setTimeout(function() {
								$('#alertas').slideUp('slow');
							}, 3000);
						} else {
							$('#registro').trigger('reset');
							location.href = 'info_correo.php';
							$('#alertas').removeClass('alert-danger');
							$('#alertas').addClass('alert-success');
							$('#alertas').html(
								'<h5>¡Listo! te enviamos un e-mail a tu correo para verificar tu cuenta</h5>'
							);
							$('#alertas').slideDown('slow');
							setTimeout(function() {
								$('#alertas').slideUp('slow');
							}, 3000);
						}
						$('#btnSubmit').attr('disabled', false);
					}
				});
			} else {
				$('#hope').addClass('d-none');
				$('#alertas').removeClass('alert-success');
				$('#alertas').addClass('alert-danger');
				$('#alertas').html('<h5>Contraseña corta<h5/>');
				$('#alertas').slideDown('slow');
				setTimeout(function() {
					$('#alertas').slideUp('slow');
				}, 2000);
				$('#btnSubmit').attr('disabled', false);
			}
		}
	});

	$(document).on('click', '.closeModalCurso', function() {
		templete = '';
		templete = `<iframe class="responsive-video" src="" width="640" height="346" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
		$('#videoModal').html(templete);
	});
});

$(document).ready(function() {
	let sesion = '';

	verisesion();

	function verisesion() {
		$.post('../controllers/registro.php', 'sesion=sesion', function(response) {
			sesion = response;
			console.log(sesion);
		});
	}

	function pintarItems() {
		let template = `<option value="">Del Curso...</option>`;
		$.post(
			'../controllers/cupones.php',
			{
				accion: 'items'
			},
			function(response) {
				const datos = JSON.parse(response);
				datos.forEach(function(item) {
					template += `
                    <option value="${item[0]}">${item[1]}</option>
                    `;
				});
				$('select').html(template);
			}
		);
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
});
