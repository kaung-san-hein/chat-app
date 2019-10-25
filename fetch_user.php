<?php

session_start();
include_once('database_connection.php');

$user_id = $_SESSION['user_id'];
$sql = "select * from login where user_id!='$user_id'";

$result = $dbcon->query($sql);

$output = "
    <table class='table table-bordered table-striped'>
        <tr>
            <td>UserName</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
";

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $status = '';

    $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-10 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);


    $user_last_activity = fetch_user_last_activity($row['user_id'], $dbcon);

    if ($user_last_activity > $current_timestamp) {
        $status = 'Online';
    } else {
        $status = 'Offline';
    }
    $output .= '
        <tr>
            <td>' . $row['username'] . ' ' . count_unseen_message($_SESSION['user_id'], $row['user_id'], $dbcon) . ' ' . fetch_is_type_status($row['user_id'], $dbcon) . '</td>
            <td>' . $status . '</td>
            <td>
                <button type="button" class="btn btn-info btn-xs start_chat" data-touserid="' . $row['user_id'] . '" data-tousername="' . $row['username'] . '">Start Chat</button>
            </td>
        </tr>
    ';
}
$output .= "</table>";
echo $output;
