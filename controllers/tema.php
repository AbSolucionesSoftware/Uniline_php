<?php
session_start();
require_once '../Modelos/Conexion.php';
require_once '../Modelos/Archivos.php';
if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            if (isset($_POST['idtema']) && !empty($_POST['preferencia']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_POST['TVideo']) && !empty($_SESSION['idbloque'])) {
                $video = 'https://player.vimeo.com/video/';
                $idvideo = explode('/', $_POST['TVideo']);
                $video .= end($idvideo);
                echo $conexion->consultaPreparada(
                    array($_POST['preferencia'], $_POST['TNombre'], $_POST['TADescripcion'], $video, subir_archivo('FArchivo'), $_SESSION['idbloque']),
                    "INSERT INTO tema (preferencia,nombre,descripcion,video,archivo, bloque) VALUES(?,?,?,?,?,?)",
                    1,
                    "ssssss",
                    false,
                    null
                );
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

        case "editar":
            $respuesta =  $conexion->consultaPreparada(
                array($_POST['idtema']),
                "SELECT archivo FROM tema WHERE idtema  = ?",
                2,
                "s",
                false,
                null
            );
            $ruta =  subir_archivo('FArchivo');
            if (!empty($respuesta) && empty($ruta)) {
                $ruta = $respuesta[0][0];
            } else if (!empty($respuesta) && !empty($ruta)) {
                unlink($ruta);
            }
            if (!empty($_POST['idtema']) && !empty($_POST['TNombre']) && !empty($_POST['TADescripcion']) && !empty($_POST['TVideo']) && !empty($_SESSION['idbloque'])) {
                $video = 'https://player.vimeo.com/video/';
                $idvideo = explode('/', $_POST['TVideo']);
                $video .= end($idvideo);
                echo $conexion->consultaPreparada(
                    array($_POST['idtema'], $_POST['TNombre'], $_POST['TADescripcion'], $video, $ruta, $_SESSION['idbloque']),
                    "UPDATE tema SET nombre = ?, descripcion = ?, video = ? , archivo = ? , bloque = ? WHERE idtema = ? ",
                    1,
                    "ssssss",
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
                    "DELETE tema_completado,tema
                        FROM tema
                        LEFT JOIN tema_completado ON tema.idtema = tema_completado.tema
                        WHERE idtema = ?",
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
                "SELECT idtema,preferencia,nombre,descripcion,video,archivo FROM tema WHERE bloque = ? ORDER BY preferencia ASC",
                2,
                "s",
                false,
                null
            ));
            break;

        case 'reordenaritemstabla':
            foreach ($_POST['reordenamientorows'] as $metadatosrow) {
                $conexion->consultaPreparada(
                    array($metadatosrow['preferencia'], $metadatosrow['idtema']),
                    "UPDATE tema SET preferencia = ? WHERE idtema = ?",
                    1,
                    "ss",
                    false,
                    null
                );
            }
            break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
