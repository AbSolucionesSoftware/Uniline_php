<?php
session_start();
require_once '../Modelos/Conexion.php';
require_once '../Modelos/Archivos.php';

if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            
                $resultado =  $conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idtarea FROM tarea WHERE bloque = ?",
                2,
                "s",
                false,
                null
            );
            
            if (isset($_POST['idtarea']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_SESSION['idbloque']) && empty($resultado)) {
                echo $conexion->consultaPreparada(
                    array($_POST['idtarea'], $_POST['TNombre'], $_POST['TADescripcion'], subir_archivo('FArchivo'), $_SESSION['idbloque']),
                    "INSERT INTO tarea (idtarea,nombre,descripcion,archivo_bajada,bloque) VALUES (?,?,?,?,?)",
                    1,
                    "sssss",
                    false,
                    null
                );
            } else {
                  echo "El bloque ya contine una tarea o los post no estan llegando correctamente";
            }
            break;

        case "editar":
            $respuesta =  $conexion->consultaPreparada(
                array($_POST['idtarea']),
                "SELECT archivo_bajada FROM tarea WHERE idtarea  = ?",
                2,
                "s",
                false,
                null
            );
            $ruta = subir_archivo('FArchivo');
            if (!empty($respuesta) && empty($ruta)) {
                $ruta = $respuesta[0][0]; //si hay una archivo registrado en el sistema y si no hay una carga nueva de archivo optene el archivo existente registrado
            } else if (!empty($respuesta) && !empty($ruta)) {
                unlink($ruta);
            }
            if (!empty($_POST['idtarea']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_SESSION['idbloque'])) {
                echo $conexion->consultaPreparada(
                    array($_POST['idtarea'], $_POST['TNombre'], $_POST['TADescripcion'], $ruta, $_SESSION['idbloque']),
                    "UPDATE tarea SET nombre = ?, descripcion = ?, archivo_bajada = ? , bloque = ? WHERE idtarea = ? ",
                    1,
                    "sssss",
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
                        "DELETE tarea,tarea_completada,evaluacion_tarea_completada
                        FROM tarea
                        LEFT JOIN tarea_completada ON tarea.idtarea = tarea_completada.tarea
                        LEFT JOIN evaluacion_tarea_completada ON tarea_completada.id= tarea_completada
                        WHERE idtarea = ?",
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
                "SELECT idbloque,bloque.nombre FROM bloque WHERE curso =  ? ",
                2,
                "s",
                false,
                null
            ));
            break;

        case 'tabla':
            echo json_encode($conexion->consultaPreparada(
                array($_SESSION['idbloque']),
                "SELECT idtarea,nombre,descripcion,archivo_bajada FROM tarea WHERE bloque = ? ORDER BY idtarea ASC",
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
