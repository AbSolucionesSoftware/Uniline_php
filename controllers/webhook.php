<?php
require_once '../Stripe/vendor/autoload.php';
require_once '../Modelos/Conexion.php';
require_once '../Modelos/Fecha.php';
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_live_wqVAMoiFqnzUFdjhliKHSpCz00snlprJPe');

// secreto de firma : es la generada despues de crear en el webhook del dashboart
$endpoint_secret = 'whsec_HsZG02AK1foY5TzvuNblV3NE2a5raC7Y';


$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE']; //firma stripe http
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent( //se construye el evento
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the checkout.session.completed event aqui puede ir la logica del pago
if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;

    $conexion = new Modelos\Conexion();
    $fecha = new Modelos\Fecha();
    $conexion->consultaPreparada(
        array(null, $session->id, $session->payment_intent, $session->metadata->idcurso, $session->client_reference_id, $session->customer_email, $fecha->getFecha(), $fecha->getHora()),
        "INSERT INTO pago (idpago,id_objeto_sesion_stripe,intento_pago,curso,usuario,email_comprador,fecha,hora) VALUES(?,?,?,?,?,?,?,?)",
        1,
        "ssssssss",
        false,
        null
    );
    // Fulfill the purchase...
    //handle_checkout_session($session); //encargarse de revisar la sesion
}

http_response_code(200);
