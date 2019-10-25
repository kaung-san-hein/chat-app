<?php
session_start();
include_once('database_connection.php');
$chat_message_id = $_POST['chat_message_id'];
if (isset($chat_message_id)) {
    $sql = "update chat_message set status='2' where chat_message_id='$chat_message_id'";
    $dbcon->query($sql);
}
