

<?php 
session_start();
require_once '../Modelos/Conexion.php';
include '../Modelos/Archivos.php';
include '../Modelos/Fecha.php';

$conexion = New Modelos\Conexion();
$request = $_SERVER['REQUEST_METHOD'];

switch($request) {

    case "POST":
        $accion_imagen = 'imagen-curso';
        if(isset($_POST['editar'])){
           $accion_imagen =  'imagen-curso-edit';
        }
        $nombre = $_POST['nombre-curso'];
        $descripcion = $_POST['descripcion-curso'];
        $imagen = subir_imagen($accion_imagen);
        $video = 'https://player.vimeo.com/video/';
        $horas = $_POST['horas-curso'];
        $costo = $_POST['costo-curso'];
        $publicacion = 0;
        
        echo $imagen;

        if ($imagen == "error al subir"){
            echo "Error";
        } else if ($imagen == "img no valida"){
            echo "imagenNoValida";
        } else {
            $idvideo = explode('/', $_POST['video-curso']);
            $video .= end($idvideo);
        }

        if(isset($nombre) && isset($descripcion) && isset($horas) && isset($costo)){
            if (!isset($_POST['editar'])){

                    echo  $conexion->consultaPreparada(
                        array($nombre,$descripcion,$imagen,$video,$horas,$_SESSION['idusuario'],$costo,$publicacion), 
                        "INSERT INTO curso (nombre,descripcion,imagen,video,horas,profesor,costo, publicacion)VALUES(?,?,?,?,?,?,?,?)", 
                        1, 
                        "ssssiidi", 
                        false, 
                        null
                    );
                 
            } else {
                $query = "UPDATE curso SET nombre = ?,descripcion = ?,imagen = ?,video = ?,horas = ?,costo = ? WHERE idcurso = ?";
                $posted_data = array($_POST['id_curso'], $nombre, $descripcion, $imagen, $video, $horas, $costo);
                $params = "sssssss";
                
                if($imagen == "") {
                    $query = "UPDATE curso SET nombre = ?,descripcion = ?,video = ?,horas = ?,costo = ? WHERE idcurso = ?";
                    unset($posted_data[3]); //eliminamos la imagen del arreglo para no tener problemas en la consulta
                    $tmp = array_values($posted_data);
                    $posted_data = $tmp;
                    $params = "ssssss";
                }else{
                    $url_curso = $conexion->consultaPreparada(
                        array($_POST['id_curso']),
                        "SELECT imagen FROM curso WHERE idcurso = ?",
                        2,
                        "s",
                        false,
                        null
                    );
                    $url_img_curso = explode('/', $url_curso[0][0]);
                    $imagen_res = "../img/res_".end($url_img_curso);
                    $imagen_min = "../img/min_".end($url_img_curso);
                    unlink($imagen_res);
                    unlink($imagen_min);
                }
                
                echo $conexion->consultaPreparada(
                    $posted_data,
                    $query,
                    1,
                    $params,
                    true,
                    null
                );
            }
                
            
        } 
    break;

    case "GET":
        if(isset($_GET['curso'])){
            $datos_del_curso = $conexion->consultaPreparada(
                array($_GET['curso']),
                "SELECT * FROM curso WHERE idcurso = ?",
                3,
                "i",
                false,
                null
            );

            echo json_encode($datos_del_curso);
        }
    break;

}

?>