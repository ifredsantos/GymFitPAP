<?php
    if(!isset($_SESSION['auth']) || isset($_SESSION['auth']) && $_SESSION['auth'] != 1)
        header('location: '.APP_URL.'home/msg/acesso-restrito');
?>