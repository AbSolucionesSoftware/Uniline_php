<?php
session_start();
require_once '../Modelos/Conexion.php';
include '../Modelos/Archivos.php';
include '../Modelos/Fecha.php';

if (
    isset($_POST['TNombre']) && isset($_POST['TADescripcion']) && isset($_POST['THoras']) && isset($_POST['TCosto'])
    && isset($_POST['TVideo']) && isset($_POST['accion'])
) {
    $conexion = new Modelos\Conexion();
    $archivo = "";
    if ($_POST['accion'] == "insertar") {
        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $archivo = subir_imagen('Fimagen', 1);
            if ($archivo == "error al subir") {
                echo "Error";
            } else if ($archivo == "img no valida") {
                echo "imagenNoValida";
            } else {
                $video = 'https://player.vimeo.com/video/';
                $idvideo = explode('/', $_POST['TVideo']);
                $video .= end($idvideo);
                echo  $conexion->consultaPreparada(
                    array($_POST['TNombre'], $_POST['TADescripcion'], $archivo, $video, $_POST['THoras'], $_SESSION['idusuario'], $_POST['TCosto']),
                    "INSERT INTO curso (nombre,descripcion,imagen,video,horas,profesor,costo)VALUES(?,?,?,?,?,?,?)",
                    1,
                    "ssssiid",
                    false,
                    null
                );
            }
        }
    } else {
        function editar_curso($imagen, $conexion)
        {
            return $conexion->consultaPreparada(
                array($_POST['idcurso'], $_POST['TNombre'], $_POST['TADescripcion'], $imagen, $_POST['TVideo'], $_POST['THoras'], $_SESSION['idusuario'], $_POST['TCosto']),
                "UPDATE curso SET nombre = ?,descripcion = ?,imagen = ?,video = ?,horas = ?,profesor = ?,costo = ? WHERE idcurso = ?",
                1,
                "ssssssis",
                true,
                null
            );
        }
        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $archivo = subir_imagen('Fimagen', 1);
            if ($archivo == "error al subir") {
                echo "Error";
            } else if ($archivo == "img no valida") {
                echo "imagenNoValida";
            } else {
                echo editar_curso($archivo, $conexion);
            }
        } else {
            $imagen = $conexion->consultaPreparada(
                array($_POST['idcurso']),
                "SELECT imagen FROM curso WHERE idcurso = ?",
                2,
                "i",
                false,
                null
            );

            echo editar_curso($imagen[0][0], $conexion);
        }
    }
}


if (isset($_POST['cursos'])) {
    $conexion = new Modelos\Conexion();
    echo json_encode($conexion->consultaPreparada(array($_SESSION['idusuario']), "SELECT * FROM curso WHERE profesor = ?", 2, "s", false, null));
} else if (isset($_POST['accion'])) {
    if ($_POST['accion'] === "editarpublicacion") {
        $conexion = new Modelos\Conexion();
        echo $conexion->consultaPreparada(
            array($_POST['publicacion'], $_POST['idcurso']),
            "UPDATE curso SET publicacion = ? WHERE idcurso = ? ",
            1,
            'ss',
            false,
            null
        );
    }
}
