<?php
session_start();
require_once '../Modelos/Conexion.php';



if (!empty($_POST['accion'])) {

    $conexion = new Modelos\Conexion();

    switch ($_POST['accion']) {

        case "insertar":
            if (!empty($_POST['INCupones']) && !empty($_POST['SCurso'])) {
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                for ($x = 0; $x < $_POST['INCupones']; $x++) {
                    $codigo = "";
                    for ($i = 0; $i < 10; $i++) {
                        $codigo .= $chars[mt_rand(0, strlen($chars) - 1)];
                    }
                    echo $conexion->consultaPreparada(
                        array($codigo, "Pendiente", $_POST['SCurso'], "Pendiente"),
                        "INSERT INTO cupones (codigo,canjeo,curso,usuario) VALUES (?,?,?,?)",
                        1,
                        "ssss",
                        false,
                        null
                    );
                }
            } else {
                echo "los post no estan llegando correctamente";
            }
            break;

            case "editar":
                if (!empty($_POST['INCodigo']) && !empty($_POST['SCurso'])) {
                    $result = $conexion->consultaPreparada(
                        array($_POST['INCodigo'], "Pendiente"),
                        "SELECT codigo,curso FROM cupones WHERE codigo = ? AND canjeo = ?",
                        2,
                        "ss",
                        false,
                        null
                    );
                    if (!empty($result)) {
                        if ($result[0][0] === $_POST['INCodigo'] && $result[0][1] == $_POST['SCurso']) {

                            echo $conexion->consultaPreparada(
                                array($_SESSION['idusuario'], $_POST['SCurso']),
                                "INSERT INTO inscripcion (alumno,curso) VALUES (?,?)",
                                1,
                                "ss",
                                false,
                                null
                            );
                            echo $conexion->consultaPreparada(
                                array('Realizado', $_SESSION['emailusuario'], $_POST['INCodigo']),
                                "UPDATE cupones SET canjeo = ?, usuario = ? WHERE codigo = ?",
                                1,
                                "sss",
                                false,
                                null
                            );
                        }
                    }
                } else echo "Codigo invalido";
                break;

        case "items":
            echo json_encode($conexion->obtenerDatosDeTabla("SELECT idcurso,nombre FROM curso ORDER BY nombre ASC "));
            break;

        case 'tabla':
            $resultado = json_encode($conexion->obtenerDatosDeTabla("SELECT codigo, canjeo , curso.nombre , usuario FROM cupones INNER JOIN curso ON idcurso = curso ORDER BY id DESC"));
            if($resultado != "[]"){
                echo $resultado;
            }else{
                echo "sinDatos";
            }
        break;

        default:
            echo "El tipo de accion no existe";
            break;
    }
}
