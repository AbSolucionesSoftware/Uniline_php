<?php
session_start();
require_once '../Modelos/Conexion.php';
if (!empty($_POST['accion'])) {

    switch ($_POST['accion']) {

        case "insertar":
            if (isset($_POST['examen']) && !empty($_SESSION['idusuario']) && !empty($_POST['calificacion'])) {
                $conexion->consultaPreparada(
                    array($_POST['examen'], $_SESSION['idusuario'], $_POST['calificacion']),
                    "INSERT INTO examen_completado (examen,usuario,calificacion) VALUES (?,?,?)",
                    1,
                    "sss",
                    false,
                    null
                );
            } else {
                echo "El bloque ya contine un examen o los post no estan llegando correctamente";
            }
            break;
            
        default:
            echo "El tipo de accion no existe";
            break;
    }
}
