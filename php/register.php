<?php
session_start();

require_once "../php/connect.php";

$uname = $_POST['username'];
$passwrd = $_POST['password'];
$email = $_POST['email'];
$stmt = '';
$data = array();
$sql = '';

if (empty($uname) || empty($passwrd) || empty($email)) {
    $err_msg = "Please fill in all the required fields!";
    exit($err_msg);
}
$sql = 'SELECT username FROM rb_accounts WHERE username = ?';
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

if (!isset($data[0]['username']) && empty($data[0]['username'])) {
    $data = array();
    $sql = 'SELECT email FROM rb_accounts WHERE email = ?';
    $stmt = sqlsrv_prepare($con, $sql, array(&$email));
    if ($stmt === false) {
        die(json_encode(array("error" => sqlsrv_errors())));
    }
    if (sqlsrv_execute($stmt) === false) {
        die(json_encode(array("error" => sqlsrv_errors())));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    if(!isset($data[0]['email']) && empty($data[0]['email'])) {
        $data = array();
        $sql = 'INSERT INTO rb_accounts(username, password, email) VALUES (?, ?, ?)';
        $hash_pwd = md5($passwrd);
        $stmt = sqlsrv_prepare($con, $sql, array(&$uname, &$hash_pwd, &$email));
        if ($stmt === false) {
            die(json_encode(array("error" => sqlsrv_errors())));
        }
        if (sqlsrv_execute($stmt) === false) {
            die(json_encode(array("error" => sqlsrv_errors())));
        }
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
        die ('Account created succesfully!');

    } else { die('Email is already associated with another account!'); }
    
} else { die('Username is already associated with another account!'); }
?>