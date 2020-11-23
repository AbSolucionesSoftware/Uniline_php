<?php
session_start();
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
require_once '../Modelos/Conexion.php';
require_once '../Stripe/vendor/autoload.php';

if (empty($_SESSION['acceso'])) { //comprobar si el usuario ya es ta logeado , de ser asi se genera el pago del curso
    die('login');
} else if (empty($_SESSION['verificado'])) {
    die('login');
} else if (empty($_SESSION['idusuario'])) {
    die('login');
}

if (!empty($_POST['idcurso'])) {
    $conexion = new Modelos\Conexion();
    $respuesta = $conexion->consultaPreparada(
        array($_POST['idcurso'], $_SESSION['idusuario']),
        "SELECT idpago FROM pago WHERE curso = ? AND usuario = ?",
        2,
        'ss',
        false,
        null
    );
    if (empty($respuesta)) {
        $respuesta = $conexion->consultaPreparada(
            array($_POST['idcurso']),
            "SELECT nombre ,imagen , costo FROM curso WHERE idcurso = ?",
            2,
            's',
            false,
            null
        );

        $nombre_curso = $respuesta[0][0];
        $imagen = explode("/", $respuesta[0][1]);
        $imagen = end($imagen);
        $costo =  $respuesta[0][2];

        \Stripe\Stripe::setApiKey('sk_live_wqVAMoiFqnzUFdjhliKHSpCz00snlprJPe');

        $session = \Stripe\Checkout\Session::create([
            'client_reference_id' => $_SESSION['idusuario'],
            'customer_email' => $_SESSION['emailusuario'],
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $nombre_curso,
                'images' => ['https://www.escuelaalreves.com/img/' . 'res_'.$imagen],
                'amount' => $costo * 100,
                'currency' => 'mxn',
                'quantity' => 1,
            ]],
            'metadata' => ['idcurso' => $_POST['idcurso']], //poner el id del curso
            'success_url' => 'https://www.escuelaalreves.com/views/success.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://www.escuelaalreves.com/views/failure.php?session_id=true',
        ]);
        echo $session->id;
    } else {
        echo "pagado";
    }
}