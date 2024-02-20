<?php
session_start();
require_once "../php/connect.php";

$uname = $_POST['username'];
$passwrd = $_POST['password'];

//check if data from form is submitted to php
if ( !empty($uname) && !empty($passwrd) ) {
    $hash = md5($passwrd);
    //preparing the SQL statement will prevent SQL injection
    if ($stmt = $con->prepare('SELECT userID, username, `password` FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $uname);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userID, $username, $password);
            $stmt->fetch();
            // Account exists, now we verify the password
            if ($password === $hash) {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $uname;
                $_SESSION['id'] = $userID;
                echo('Success');
            } else {
            // Incorrect username
            echo ('Incorrect password');
            }
            $stmt->close();
        } else {
            echo('Incorrect username');
        }
    } else {
        echo 'Error.';
    }
} else {
    echo('Please fill in all the required fields!');
}
?>