<?php
date_default_timezone_set('Asia/Yangon');
$databaseHost = 'localhost';
$databaseName = 'chat';
$databaseUserName = 'root';
$databasePassword = '';

try {
    $dbcon = new PDO("mysql:host={$databaseHost};dbname={$databaseName};charset=utf8mb4;", $databaseUserName, $databasePassword);
    $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

function fetch_user_last_activity($user_id, $dbcon)
{
    $sql = "select * from login_details where user_id='$user_id' order by last_activity desc limit 1";
    $result = $dbcon->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll();
    foreach ($rows as $row) {
        return $row['last_activity'];
    }
}

function fetch_user_chat_history($to_user_id, $from_user_id, $dbcon)
{
    $sql = "
        select * from chat_message where (from_user_id='" . $from_user_id . "' and to_user_id='" . $to_user_id . "') or 
        (from_user_id='" . $to_user_id . "' and to_user_id='" . $from_user_id . "') order by timestamp desc
    ";

    $result = $dbcon->query($sql);
    $output = '<ul class="list-unstyled">';
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $user_name = '';
        $dynamic_background = '';
        $chat_message = '';
        if ($row['from_user_id'] == $from_user_id) {
            if ($row['status'] == '2') {
                $chat_message = '<em>This message has been removed!</em>';
                $user_name = '<b class="text-success">You</b>';
            } else {
                $chat_message = $row['chat_message'];
                $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="' . $row['chat_message_id'] . '">x</button>&nbsp;<b class="text-success">You</b>';
            }
            $dynamic_background = 'background-color: #ffe6e6';
        } else {
            if ($row['status'] == '2') {
                $chat_message = '<em>This message has been removed!</em>';
            } else {
                $chat_message = $row['chat_message'];
            }
            $user_name = '<b class="text-danger">' . get_user_name($row['from_user_id'], $dbcon) . '</b>';
            $dynamic_background = 'background-color: #ffffe6';
        }
        $output .= '
            <li style="border-bottom:1px dotted #ccc;' . $dynamic_background . '">
                <p>' . $user_name . ' - ' . $chat_message . '
                    <div align="right">
                        - <small><em>' . $row["timestamp"] . '</em></small>
                    </div>
                </p>
            </li>
        ';
    }
    $output .= '</ul>';
    $sql = "update chat_message set status='0' where from_user_id='$to_user_id' and to_user_id='$from_user_id' and status='1'";
    $dbcon->query($sql);
    return $output;
}

function get_user_name($user_id, $dbcon)
{
    $sql = "select username from login where user_id='$user_id'";
    $result = $dbcon->query($sql);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        return $row['username'];
    }
}

function count_unseen_message($from_user_id, $to_user_id, $dbcon)
{
    $sql = "select * from chat_message where from_user_id='$to_user_id' and to_user_id='$from_user_id' and
    status='1'";
    $result = $dbcon->query($sql);
    $count = $result->rowCount();
    $output = '';
    if ($count > 0) {
        $output = '<badge class="badge badge-success">' . $count . '</badge>';
    }
    return $output;
}

function fetch_is_type_status($user_id, $dbcon)
{
    $sql = "select is_type from login_details where user_id='$user_id' order by last_activity desc limit 1";
    $result = $dbcon->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll();
    $output = '';
    foreach ($rows as $row) {
        if ($row['is_type'] == 'yes') {
            $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
        }
    }
    return $output;
}

function fetch_group_chat_history($dbcon)
{
    $sql = "select * from chat_message where to_user_id='0' order by timestamp desc";
    $result = $dbcon->query($sql);
    $output = '<ul class="list-unstyled">';
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $user_name = '';
        $dynamic_background = '';
        $chat_message = '';
        if ($row['from_user_id'] == $_SESSION['user_id']) {
            if ($row['status'] == '2') {
                $chat_message = '<em>This message has been removed!</em>';
                $user_name = '<b class="text-success">You</b>';
            } else {
                $chat_message = $row['chat_message'];
                $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="' . $row['chat_message_id'] . '">x</button>&nbsp;<b class="text-success">You</b>';
            }
            $dynamic_background = 'background-color: #ffe6e6';
        } else {
            if ($row['status'] == '2') {
                $chat_message = '<em>This message has been removed!</em>';
            } else {
                $chat_message = $row['chat_message'];
            }
            $user_name = '<b class="text-danger">' . get_user_name($row['from_user_id'], $dbcon) . '</b>';
            $dynamic_background = 'background-color: #ffffe6';
        }
        $output .= '
            <li style="border-bottom:1px dotted #ccc;' . $dynamic_background . '">
                <p>' . $user_name . ' - ' . $chat_message . '
                    <div align="right">
                        - <small><em>' . $row["timestamp"] . '</em></small>
                    </div>
                </p>
            </li>
        ';
    }
    $output .= '</ul>';
    return $output;
}
