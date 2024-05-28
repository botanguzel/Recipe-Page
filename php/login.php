<?php
session_start();
require_once "../php/connect.php";

$uname = $_POST['username'];
$passwrd = $_POST['password'];
$data = array();
//check if data from form is submitted to php
if ( !empty($uname) && !empty($passwrd) ) {
    $hash = md5($passwrd);
    $sql = 'SELECT userID, username, password FROM rb_accounts WHERE username = ?';
    $stmt = sqlsrv_prepare($con, $sql, array(&$uname));
    if ($stmt === false) {
        die(json_encode(array("error" => sqlsrv_errors())));
    }
    if (sqlsrv_execute($stmt) === false) {
        die(json_encode(array("error" => sqlsrv_errors())));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
    if (isset($data[0]['username']) && !empty($data[0]['username'])) {
        if ($data[0]['password'] === $hash) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $uname;
            $_SESSION['id'] = $data[0]['userID'];
            echo('Success');
        } else {
            echo ('Incorrect password');
        }
        die();
    } else {
        echo('Incorrect username');
    }
} else {
    echo('Please fill in all the required fields!');
}
?>