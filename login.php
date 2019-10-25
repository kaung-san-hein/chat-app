<?php
session_start();
include_once('database_connection.php');
$message = null;
if (isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit();
}
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "select * from login where username='$username'";
    $result = $dbcon->query($sql);

    $count = $result->rowCount();

    if ($count > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $user_id = $row['user_id'];
                $_SESSION['username'] = $row['username'];

                $sql2 = "insert into login_details (user_id) values ('$user_id')";
                $dbcon->query($sql2);

                $_SESSION['login_details_id'] = $dbcon->lastInsertId();

                header("location: index.php");
                exit();
            } else {
                $message = "Wrong Password";
            }
        }
    } else {
        $message = "Wrong Username";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat Application using PHP Ajax jQuery</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Chat Application using PHP Ajax jQuery</h3>
        <br /><br />
        <div class="panel panel-default">
            <div class="panel-heading">Chat Application Login</div>
            <div class="panel-body">
                <?php
                if ($message)
                    echo "<div class='alert alert-success'>{$message}</div>";
                ?>
                <form action="" method="post">
                    <div class="from-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-success" />
                        <a href="register.php" class="btn btn-link">Go To Register?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>