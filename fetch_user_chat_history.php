<?php
    session_start();
    include_once('database_connection.php');
    echo fetch_user_chat_history($_POST['to_user_id'],$_SESSION['user_id'],$dbcon);
