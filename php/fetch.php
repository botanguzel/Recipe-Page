<?php

session_start();
require_once "connect.php";
$data = [];

// Check if a parameter named "type" is provided
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type === 'recipe') {
        $stmt = $con->prepare("SELECT id, recipe_name, description, n_ingredients, ingredients, n_steps, steps, minutes, nutrition, images, ranking
                             FROM recipes LIMIT 100");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) { $data[] = $row; }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    } elseif ($type === 'user') {
        // Fetch advices from the database
        $stmt = $con->prepare("SELECT username, email FROM accounts WHERE userID = ?");
        $uid = $_SESSION['id'];
        $stmt->bind_param('s', $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    } elseif ($type === 'update') {
        if (!empty($_POST['newPass']) && !empty($_POST['oldPass'])) {
            $new_pwd = md5($_POST['newPass']);
            $old_pwd = md5($_POST['oldPass']);
            $stmt = $con->prepare("SELECT password from accounts WHERE userID = ?;");
            $stmt->bind_param("s", $_SESSION['id']);
            $stmt->execute();
            $stmt->bind_result($db_password);
            $stmt->fetch();
            $stmt->close();
            if ($old_pwd === $db_password) {
                $stmt = $con->prepare("UPDATE accounts SET password = ? WHERE userID = ?;");
                $stmt->bind_param("ss", $new_pwd, $_SESSION['id']);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    exit('Password Changed Succesfully!');
                } else {
                    exit("Error creating the password." . $con->error);
                }
                $stmt->close();
            } else {
                exit('Old Password Is Incorrrect!.');
            }
        } else {exit('Please fill in all the required lines!');}
    } elseif ($type === 'comment') {
        if (isset($_SESSION['id'])) {
            if (!empty($_POST['comment']) && !empty($_POST['rec_id'])) {
                $stmt = $con->prepare("SELECT username from accounts WHERE userID = ?;");
                $stmt->bind_param("s", $_SESSION['id']);
                $stmt->execute();
                $stmt->bind_result($db_username);
                $stmt->fetch();
                $stmt->close();
                $stmt = $con->prepare("INSERT INTO recipe_comments (recipe_id, username, comment_text) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $_POST['rec_id'], $db_username, $_POST['comment']);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    exit('Comment has been added!');
                } else {
                    exit("Error creating the password." . $con->error);
                }
                $stmt->close();
                exit;
            } else { echo('Please fill the comment section to make a comment!');}
        } else {exit('Please log in first to comment!');}
    } elseif ($type === 'fetchComments') {
        if (isset($_GET['rid'])) {
            $stmt = $con->prepare("SELECT c.username, c.comment_text, c.comment_date FROM recipes r LEFT JOIN recipe_comments c ON r.id = c.recipe_id WHERE r.id = ? LIMIT 3");
            $rid = $_GET['rid'];
            $stmt->bind_param('s', $rid);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) { $data[] = $row; }
            header('Content-Type: application/json');
            echo json_encode($data);
        } else { exit('No Recipe ID Found!');}
    } elseif ($type === 'updateRank') {
        if (isset($_POST['id']) & isset($_SESSION['id'])) {
            $stmt = $con->prepare("UPDATE recipes SET ranking = (ranking + ?) / 2 WHERE id = ?;");
            $id = $_POST['id'];
            $newRank = $_POST['newRank'];
            $stmt->bind_param('ii', $newRank, $id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                exit('Rank have been updated');
            } else { exit('There was an error while updating the rank'); }
            header('Content-Type: application/json');
            echo json_encode($data);
        } else { exit('Please Login Before Ranking!');}
    } else {
        $data = [
            'error' => 'No order parameter provided'
        ];
        exit('No order');
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $con->prepare("SELECT id, recipe_name, description, n_ingredients, ingredients, n_steps, steps, minutes, nutrition, images, ranking, comments
                            FROM recipes where id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) { $data = $row; }
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No type parameter provided
    $data = [
        'error' => 'No type parameter provided'
    ];
    exit('No type');
}
exit;
?>