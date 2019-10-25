<?php
session_start();
include_once('database_connection.php');
if ($_POST['action'] == 'insert_data') {
    $data = array(
        ':from_user_id' => $_SESSION['user_id'],
        ':chat_message' => $_POST['chat_message'],
        ':status' => '1'
    );


    $sql = "insert into chat_message (from_user_id,chat_message,status,timestamp) values (:from_user_id,:chat_message,:status,now())";

    $result = $dbcon->prepare($sql);
    if ($result->execute($data)) {
        echo fetch_group_chat_history($dbcon);
    }
}

if ($_POST['action'] == 'fetch_data') {
    echo fetch_group_chat_history($dbcon);
}
