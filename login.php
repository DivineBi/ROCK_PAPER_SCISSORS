<?php // Do not put any HTML above this line
session_start();

$salt = 'XyZzy12*_';
$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // md5 of 'XyZzy12*_php123'

$error = false;  

// Check to see if we have some POST data, if we do process it
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['who']) || empty($_POST['pass'])) {
        $_SESSION['error'] = 'User name and password are required';
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION['name'] = $_POST['who'];
            // Redirect the browser to game.php
            header("Location: game.php?name=".urlencode($_POST['who']));
            return;
        } else {
            $_SESSION['error'] = 'Incorrect password';
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Login Rock Paper Scissors</title>
</head>
<body>
<div class="container">
<h1>Please log in</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if (isset($_SESSION['error'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="who">User Name</label>
<input type="text" name="who" id="who"><br/>
<label for="pass">Password</label>
<input type="password" name="pass" id="pass"><br/>
<input type="submit" value="Log In">
</form>
</div>
</body>
</html>
