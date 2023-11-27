<?php

    session_start();
    session_destory();

    header('Location: index.php');
    exit();
?>