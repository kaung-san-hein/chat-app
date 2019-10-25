<?php
session_start();
include_once('database_connection.php');
$data = array(
    ':to_user_id' => $_POST['to_user_id'],
    ':from_user_id' => $_SESSION['user_id'],
    ':chat_message' => $_POST['chat_message'],
    ':status' => '1'
);

$sql = "insert into chat_message (to_user_id,from_user_id,chat_message,status,timestamp) values (:to_user_id,:from_user_id,:chat_message,:status,now())";

$result = $dbcon->prepare($sql);
if ($result->execute($data)) {
    echo fetch_user_chat_history($_POST['to_user_id'], $_SESSION['user_id'], $dbcon);
}
