<?php 
   
    session_start();
    include "../Modelos/Conexion.php";
    include '../Modelos/Email.php';
    
    if(isset($_POST['emailForReset'])){
        $conexion = new Modelos\Conexion();
        $resultado = $conexion->consultaPreparada(
            array($_POST['emailForReset']),
            "SELECT * FROM usuario WHERE email = ?",
            2,
            "s",
            false,
            null
        );
        if($resultado[0][0] != ""){
            $emailClass = new Modelos\Email();
            $vkey = $emailClass->setEmail($_POST['emailForReset']);
            $enviar = $emailClass->enviarEmailRecuperarPass();
            echo "mail_existe";
        }else{
            echo "mail_noExiste";
        }
    }

    if(isset($_POST['newPass'])){
        
        $conexion = new Modelos\Conexion();
        $encri = $_POST['newPass'];
        $encriptado = trim(password_hash($encri,PASSWORD_DEFAULT));
        //var_dump($encriptado,$_POST['correo']);
        $resultado = $conexion->consultaPreparada(
            array($encriptado,$_POST['correo']),
            "UPDATE usuario SET password = ? WHERE email = ?",
            1,
            "ss",
            false,
            null
        );
        if($resultado == 1){
            echo 1;
            $resultado2 = $conexion->consultaPreparada(
                array($_POST['correo']),
                "SELECT * FROM usuario WHERE email = ?",
                2,
                "s",
                false,
                null
            ); 
            //var_dump($resultado2);
            $_SESSION['acceso'] = $_POST['correo'];
            $_SESSION['idusuario'] = $resultado2[0][0];
            $_SESSION['emailusuario'] = $resultado2[0][6];
            $_SESSION['verificado'] = $resultado2[0][9];
            $_SESSION['CEO'] = '';
            if($resultado2[0][4] != ""){
                $_SESSION['imagen_perfil'] = $resultado2[0][4];
            }else{
                $_SESSION['imagen_perfil'] = "../img/perfil.png";
            }
        }
    }

?>