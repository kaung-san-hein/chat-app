<?php
include_once('database_connection.php');
$message = null;
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "select * from login where username='$username'";
    $result = $dbcon->query($sql);
    if ($result->rowCount() > 0) {
        $message = 'Username has already exit!';
    } else {

        if ($password !== $confirm_password) {
            $message = 'Please check your password';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "insert into login (username,password) values ('$username','$hash')";
            $query = $dbcon->prepare($sql);
            $query->execute();
            $message = 'You have been successfully registered!';
        }
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
            <div class="panel-heading">Chat Application Register</div>
            <div class="panel-body">
                <form action="" method="post">
                    <?php
                    if ($message)
                        echo "<div class='alert alert-success'>{$message}</div>";
                    ?>
                    <div class="from-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="reset" value="Cancel" class="btn btn-light" />
                        <input type="submit" name="register" value="Register" class="btn btn-success" />
                        <a href="login.php" class="btn btn-link">Go To Login?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>