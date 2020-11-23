$(document).ready(function(){
    $("#ventana-alerta").removeClass('d-none');
    $("#ventana-alerta").hide();
    $("#mostrar").hide();
    setTimeout(function(){
        $("#ventana-alerta").show(400)
      }, 1000);
      setTimeout(function(){
        $("#mostrar").show(200)
      }, 1500);
});

    
