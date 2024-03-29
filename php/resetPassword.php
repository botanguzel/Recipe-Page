<?php
session_start();
require_once "../php/connect.php";

$address = $_POST['email'];

//check if data from form is submitted to php
if ( !empty($address) ) {
    //preparing the SQL statement will prevent SQL injection
    if ($stmt = $con->prepare('SELECT id, username, password, verification FROM accounts WHERE email = ?')) {
        $stmt->bind_param('s', $address);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userID, $username, $password, $verificationCode);
            $stmt->fetch();
            // Account exists, now we verify the password
            if ($verificationCode === $enteredVerificationCode) {
                // Verification code matches, update the password
                if ($stmt = $con->prepare('UPDATE accounts SET password = ? WHERE id = ?')) {
                    $stmt->bind_param('si', $newHashedPassword, $userID);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['name'] = $address;
                    $_SESSION['id'] = $userID;
                    echo 'Password updated successfully.';
                } else {
                    echo 'Error updating password.';
                }
            } else {
                echo 'Incorrect verification code';
            }
            $stmt->close();
        } else {
            echo 'Incorrect username';
        }
    } else {
        echo 'Error.';
    }
} else {
    echo('Please fill in all the required fields!');
}
?>