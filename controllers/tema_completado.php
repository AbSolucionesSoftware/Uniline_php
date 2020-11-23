<?php
session_start();
require_once '../Modelos/Conexion.php';

if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            if (isset($_POST['tema']) && !empty($_SESSION['idusuario'])) {
                $conexion->consultaPreparada(
                    array($_POST['idtema'], $_SESSION['idusuario']),
                    "INSERT INTO tema_completado (tema,usuario) VALUES (?,?)",
                    1,
                    "ss",
                    false,
                    null
                );
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
