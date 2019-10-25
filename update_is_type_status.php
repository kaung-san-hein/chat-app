<?php
session_start();
include_once('database_connection.php');
$is_type = $_POST['is_type'];
$login_details_id = $_SESSION['login_details_id'];

$sql = "update login_details set is_type='$is_type' where login_details_id='$login_details_id'";
$dbcon->query($sql);
