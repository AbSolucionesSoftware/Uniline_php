<?php
session_start();
require_once '../Modelos/Conexion.php';

if (!empty($_POST['examen']) && !empty($_POST['alumno'])) {
    $datos = [$_POST['alumno'], $_POST['examen']]; //si un profesor quiere ver las respuestas de su alumno

} else if (!empty($_POST['examen']) && empty($_POST['alumno'])) {
    $datos = [$_SESSION['idusuario'], $_POST['examen']]; //si un alumno quiere ver sus respuestas

}
if (!empty($_POST['accion'])) {
    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case 'tabla':
            echo json_encode($conexion->consultaPreparada(
                $datos,
                "SELECT pregunta.idpregunta,pregunta,usuario,usuario.nombre,correcta,respuesta FROM respuesta_usuario 
                INNER JOIN pregunta ON respuesta_usuario.idpregunta = pregunta.idpregunta
                INNER JOIN usuario ON usuario = idusuario WHERE examen = ? AND usuario = ? ",
                2,
                "ss",
                false,
                null
            ));
            break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
