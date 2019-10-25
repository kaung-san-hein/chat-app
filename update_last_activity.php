<?php
session_start();
include_once('database_connection.php');
$login_details_id = $_SESSION['login_details_id'];

$sql = "update login_details set last_activity=now() where login_details_id='$login_details_id'";
$dbcon->query($sql);
