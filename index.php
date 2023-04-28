<?php require "./inc/session_start.php";  ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include "./inc/head.php";  ?>
</head>
<body>
    <?php
        if(!isset($_GET['vista']) || $_GET['vista']==""){
            $_GET['vista']="login";
        }

        if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!="login" && $_GET['vista']!="404"){

            # Terminar Sessão #
            if (( !isset($_SESSION['id'])|| $_SESSION['id']=="") || ( !isset($_SESSION['user']) || $_SESSION['user']=="")){
                include "./vistas/logout.php";
                exit();
            }

            include "./inc/navbar.php";

            include "./inc/filter.php";

            include "./vistas/".$_GET['vista'].".php"; 

            include "./inc/script.php"; 

        }else{
            if($_GET['vista']=="login"){
                include "./vistas/login.php"; 
            }else{
                include "./vistas/404.php"; 
            }

        }


    ?>
</body>
</html>