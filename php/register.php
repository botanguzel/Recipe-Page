<?php
session_start();

require_once "../php/connect.php";

$uname = $_POST['username'];
$passwrd = $_POST['password'];
$email = $_POST['email'];

if (empty($uname) || empty($passwrd) || empty($email)) {
    $err_msg = "Please fill in all the required fields!";
    exit($err_msg);
}
if ($stmt = $con->prepare('SELECT username FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	//store the result to check if it exists in the database
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $err_msg = "This username is being used!";
        exit($err_msg);
    }
    else{
        if ($stmt = $con->prepare('SELECT username FROM accounts WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $err_msg = "This email has already been registered with another account";
                exit($err_msg);
            }
            else {
                $stm = $con->prepare('INSERT INTO accounts(username, password, email) VALUES (?, ?, ?)');
                $hashed_password = md5($passwrd);
                $stm->bind_param('sss', $uname, $hashed_password, $email);
                $stm->execute();
                if ($stm->affected_rows > 0) {
                    exit('Account Created Successfully!');
                } else {
                    exit("Error creating user.");
                }
            }
        }
    }
}
?>