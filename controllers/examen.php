<?php
session_start();
require_once '../Modelos/Conexion.php';

if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            $resultado =  $conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idexamen FROM examen WHERE bloque = ?",
                2,
                "s",
                false,
                null
            );
            if (isset($_POST['idexamen']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_SESSION['idbloque']) && !empty($_POST['accion']) && empty($resultado)) {
                echo $conexion->consultaPreparada(
                    array($_POST['idexamen'], $_POST['TNombre'], $_POST['TADescripcion'], $_SESSION['idbloque']),
                    "INSERT INTO examen (idexamen,nombre,descripcion,bloque) VALUES (?,?,?,?)",
                    1,
                    "ssss",
                    false,
                    null
                );
                $_SESSION['idexamen'] = $conexion->optenerId();
                               
            } else {
                echo "El bloque ya contine un examen o los post no estan llegando correctamente";
            }
            break;

        case "editar":
            if (isset($_POST['idexamen']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_SESSION['idbloque']) && !empty($_POST['accion']) && empty($resultado)) {
               echo $conexion->consultaPreparada(
                    array($_POST['idexamen'], $_POST['TNombre'], $_POST['TADescripcion'], $_SESSION['idbloque']),
                    "UPDATE examen SET nombre = ?, descripcion = ?, bloque = ? WHERE idexamen = ? ",
                    1,
                    "ssss",
                    true, // se reestructira la fila se cambia el id que esta en la primera columna hacia la ultima para que el bind de las variables en la consulta coincida
                    null
                );
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

            case "eliminar":
                if (!empty($_POST['ideliminarregistro'])) {
                    echo $conexion->consultaPreparada(
                        array($_POST['ideliminarregistro']),
                        "DELETE examen,examen_completado,pregunta,respuesta_usuario
                        FROM examen
                        LEFT JOIN examen_completado ON idexamen = examen_completado.examen
                        LEFT JOIN pregunta ON pregunta.examen = idexamen
                        LEFT JOIN respuesta_usuario ON pregunta.idpregunta = respuesta_usuario.idpregunta
                        WHERE idexamen = ?",
                        1,
                        "s",
                        false,
                        null
                    );
                }
            break;

        case "items":
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idcurso']),
                "SELECT idbloque,bloque.nombre FROM bloque WHERE curso = ?",
                2,
                "s",
                false,
                null
            ));
            break;

        case 'tabla':
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idexamen,examen.nombre,examen.descripcion FROM examen WHERE bloque = ? ",
                2,
                "s",
                false,
                null
            ));
            break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
