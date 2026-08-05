<?php 
    session_start();
    if(empty($_SESSION['myuserId'])){
        session_destroy();
        header('Location: /Linkspam/Index.php');
        die;
    }else{
        header('Location: /Linkspam/Home.php');
        die;
    }
?>