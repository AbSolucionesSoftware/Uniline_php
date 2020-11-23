<?php
if($_GET['cerrar'] == 'true'){
session_start();
session_unset();
session_destroy();
header('Location: ../views/mainpage.php');

} 
die('se mando a destruir la sesion');

?>