<?php
session_start();
require_once '../Modelos/Conexion.php';

if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();


    switch ($_POST['accion']) {


        case "insertar":
            if (isset($_POST['idbloque']) && !empty($_POST['TNombre']) && !empty($_POST['SCurso'])) {
                echo $conexion->consultaPreparada(
                    array($_POST['idbloque'], $_POST['TNombre'], $_POST['SCurso']),
                    "INSERT INTO bloque (idbloque,nombre,curso) VALUES (?,?,?)",
                    1,
                    "sss",
                    false,
                    null
                );
            }
            break;

        case "editar":
            if (isset($_POST['idbloque']) && !empty($_POST['TNombre']) && !empty($_POST['SCurso'])) {
                echo $conexion->consultaPreparada(
                    array($_POST['idbloque'], $_POST['TNombre'], $_POST['SCurso']),
                    "UPDATE bloque SET nombre = ?, curso = ? WHERE idbloque = ? ",
                    1,
                    "sss",
                    true,
                    null
                );
            }
            break;

        case "eliminar":
            if (!empty($_POST['ideliminarregistro'])) {
                echo $conexion->consultaPreparada(
                    array($_POST['ideliminarregistro']),
                    "DELETE bloque,tema,tema_completado,tarea,tarea_completada,evaluacion_tarea_completada,examen ,examen_completado,pregunta,respuesta_usuario
                    FROM bloque
                    LEFT JOIN tema ON idbloque = tema.bloque
                    LEFT JOIN tema_completado ON tema.idtema = tema_completado.tema
                    LEFT JOIN tarea ON idbloque = tarea.bloque
                    LEFT JOIN tarea_completada ON tarea.idtarea = tarea_completada.tarea
                    LEFT JOIN evaluacion_tarea_completada ON tarea_completada.id= tarea_completada
                    LEFT JOIN examen ON idbloque = examen.bloque
                    LEFT JOIN examen_completado ON idexamen = examen_completado.examen
                    LEFT JOIN pregunta ON pregunta.examen = idexamen
                    LEFT JOIN respuesta_usuario ON pregunta.idpregunta = respuesta_usuario.idpregunta
                    WHERE idbloque = ?",
                    1,
                    "s",
                    false,
                    null
                );
            }
        break;

        case "items":

            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idusuario']),
                "SELECT idcurso, nombre FROM curso WHERE profesor = ?",
                2,
                "s",
                false,
                null
            ));
            break;

        case 'tabla':
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idcurso']),
                "SELECT idbloque,bloque.nombre,curso,curso.nombre FROM bloque INNER JOIN curso ON curso = idcurso WHERE idcurso = ?",
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
