$(document).ready(function() {
	let params = new URLSearchParams(location.search);
    let id = params.get('idcurso');
    
    let sesion = ""; 

    verisesion();

    function verisesion(){
    $.post("../controllers/registro.php","sesion=sesion", function(response) {
            sesion = response;
            console.log(sesion);
        });
    }

	/* CUPONES */
	$(document).on('submit', '#FCupones', function(e) {
        e.preventDefault();
		if (sesion != '') {
			if ($('#codigo').val().length != 0) {
				$.post('../controllers/cupones.php', $(this).serialize() + '&SCurso='+ id + '&accion=editar', function(response) {
					console.log(response);
					if (!response.includes('1')) {
						swal('Codigo Invalido', 'Verifique sus datos o intentelo mas tarde', 'warning');
					} else {
                        // pintarTabla(); descomentar ya que se haya integrado en un solo js
						window.location.replace('../views/misCursos.php');
					}
				});
				$(this)[0].reset();
			} else {
				swal('Datos Incompletos', 'Por favor llene todos los campos o inicie sesion', 'warning');
			}
		} else {
			swal('Datos Incompletos', 'Es necesario tener cuenta para realizar esta accion', 'warning');
		}
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
	/* <---------------------Se pintan el titulo y otros datos del curso-----------------------> */
	$(document).ready(function() {
		let templateImagen = '';
		let templateTitulo = '';
		let templateBotones = '';
		let templateInfo = '';
		let templateVideo = '';
		let templateContenido = '';
		let url = '';
		let url_2 = '';
		let url_3 = '';
		let url3 = '';
		$.ajax({
			url: '../controllers/contenido_index.php',
			type: 'POST',
			data: 'cursos-descripcion=' + id,

			success: function(response) {
				let datos = JSON.parse(response);
				$.each(datos, function(i, item) {
					url = datos[i][7].split('/');
					url_2 = url[0] + '/' + url[1] + '/min_' + url[2];
					url3 = datos[i][3].split('/');
					url_3 = url[0] + '/' + url3[1] + '/res_' + url3[2];

					separar = datos[0][10].split('###');
					templateImagen += `<img src="${url_3}" alt="curso" width="100%" style="border-radius: 1rem;">`;
					templateTitulo += `<h1 class="text-white strong titulo-banner">${item[1]}</h1>`;
					templateBotones += `<div class="d-sm-block d-lg-flex">
                                <div class="col-12 col-lg-7 col-xl-7" style="padding: 0;">
                                    <button value="${datos[
										i
									][0]}" class="mt-5 boton-comprar-cursos primary-btn compras">Comprar curso</button>
                                </div>
                                <div class="mt-5 col-12 col-lg-5 col-xl-5 precio-banner d-flex align-items-center justify-content-center">
                                    <span class="text-white">$${datos[i][8]} MX</span>
                                </div>                                                
                            </div> 
          
          `;
					templateInfo += `
                        <div class="mt-3">
                            <div class="contenido-info-curso">
                                <h3>${item[1]}</h1>
                                <br/>
                                <ul>
                                    <li>
                                        <div class="star" style="color: yellow">
                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                            <i class="fas fa-star" style="cursor: pointer;"></i>
                                            <i class="far fa-star" style="cursor: pointer;"></i>
                                        </div>
                                    </li>
                                    <li><i class="fab fa-youtube"></i> ${item[5]} horas de curso</li>
                                    <li><i class="fas fa-infinity"></i> Acceso de por vida</li>
                                    <li><i class="fas fa-mobile-alt"></i> Acceso desde dispositivos moviles</li>
                                    <li><i class="fas fa-certificate"></i> Certificación al finalizar</li>
                                </ul>
                            </div>
                            <div class="contenido-maestro">
                                <h4 class="pt-5">Curso impartido por:</h2>
                                <div class="maestro row">
                                    <div class="col-3 d-flex align-items-center">
										<div>
											<img src="${url_2}" alt="profesor" width="70px"; height="70px"; class="img-circle">
										</div>
                                    </div>
                                    <div class="col-8 flex align-items-center">
                                        <div>
                                            <h4>${item[6]}</h3>
                                            <h5>${separar[0]}, ${separar[1]}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
					templateVideo += `
                        <div>
                            <div class="contenido-video text-center">
                                <iframe class="iframe-responsivo" src="${item[9]}" width="640" height="350" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                            </div>
                        </div>
                        <br>
                        <div class="contenido-descripcion">
                            <div class="titulo-descripcion">
                                <h3 class="text-center titulo-descripcion">Descripcion</h2>
                            </div>
                            <div class="descripcion text-justify">
                                <h4>${item[2]}</h4>
                            </div>
                        </div>
                    `;
				});
				/* <---------------------Se pinta los capitulos o bloques-----------------------> */
				$.ajax({
					url: '../controllers/contenido_index.php',
					type: 'POST',
					data: 'cursos-contenido=' + id,
					success: function(response) {
						let datos = JSON.parse(response);
						$.each(datos, function(i, item) {
							templateContenido += `
                                <li data-toggle="collapse" data-bloque="bloque-${item[0]}" class="mb-3 curso titulo-capitulos item-anim uno">
                                    <h3 class="h3">Capitulo ${i + 1}</h3>
                                </li>
                                <div data-temas="bloque-${item[2]}-${item[0]}" class="collapse bloque-${item[0]}">
                                </div>`;
						});
						$('#imagen-curso').html(templateImagen);
						$('#titulo-curso').html(templateTitulo);
						$('#botones-curso').html(templateBotones);
						$('#informacion-curso').html(templateInfo);
						$('#contenido-video').html(templateVideo);
						$('#contenido-contenido').html(templateContenido);
					}
				});
			}
		});
		/* <---------------------Desplegar el contenido del curso e imprime los temas -----------------------> */
		$(document).on('click', '.curso', function() {
			contenido = $(this).data('bloque');
			temas = $('.' + contenido).data('temas');
			datos_tema = temas.split('-');
			$.ajax({
				url: '../controllers/contenido_index.php',
				type: 'POST',
				data: 'temas-bloque=' + datos_tema[2],
				success: function(response) {
					let datos2 = JSON.parse(response);
					templateTemas = '';
					$.each(datos2, function(y, item2) {
						templateTemas += `     
                    
                            <li class="text-left" style="margin-left: 6rem!important;">
                            <h4>${item2[1]}</h4>
                            </li>
                            `;
					});
					$('.' + contenido).html(templateTemas);
				}
			});
			setTimeout(function() {
				$('.' + contenido).slideToggle('slow');
			}, 150);
		});
	});
});
