<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "connect.php";
$data = array();
$sql = '';
$stmt = '';
// Check if a parameter named "type" is provided
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    if ($type === 'recipe') {
        $sql = ("SELECT top(10) id, recipeName, description, nIngredients, ingredients, nSteps, steps, cTime, nutrition, imgSrc, ranking
                             FROM recipes");
        $stmt = sqlsrv_prepare($con, $sql);
    } elseif ($type === 'user') {
        $sql = ("SELECT username, email from rb_accounts WHERE userID = ?");
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
    }
     elseif ($type === 'update') {
        if (!empty($_POST['newPass']) && !empty($_POST['oldPass'])) {
            $new_pwd = md5($_POST['newPass']);
            $old_pwd = md5($_POST['oldPass']);
            $stmt = $con->prepare("SELECT password from rb_accounts WHERE userID = ?;");
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
                $stmt = $con->prepare("SELECT username from rb_accounts WHERE userID = ?;");
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
                    exit("An error occured when adding the comment!" . $con->error);
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
    } elseif ($type === 'save') {
        if (isset($_SESSION['id'])) {
            if (!empty($_POST['rec_id'])) {
                $stmt = $con->prepare("SELECT COUNT(*) FROM saved_recipes WHERE userID = ? AND recipe_id = ?");
                $stmt->bind_param("si", $_SESSION['id'], $_POST['rec_id']);
                $stmt->execute();
                $stmt->bind_result($existing_count);
                $stmt->fetch();
                $stmt->close();
                if ($existing_count > 0) {
                    exit('Recipe is already saved!');
                } else {
                    $stmt = $con->prepare("SELECT username from rb_accounts WHERE userID = ?;");
                    $stmt->bind_param("s", $_SESSION['id']);
                    $stmt->execute();
                    $stmt->bind_result($db_username);
                    $stmt->fetch();
                    $stmt->close();
                    $stmt = $con->prepare("INSERT INTO saved_recipes (userID, recipe_id, date_saved) VALUES (?, ?, CURRENT_TIMESTAMP);");
                    $stmt->bind_param("si", $_SESSION['id'], $_POST['rec_id']);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        exit('Recipe has been added!');
                    } else {
                        exit("Error saving the recipe." . $con->error);
                    }
                    $stmt->close();
                    exit;
                }
            } else { echo('Error saving the current recipe!');}
        } else {exit('Please log in first to save!');}
    } elseif ($type === 'checkSave') {
        if (isset($_SESSION['id'])) {
            if (!empty($_GET['rid'])) {
                $rid = $_GET['rid'];
                $stmt = $con->prepare("SELECT COUNT(*) FROM saved_recipes WHERE userID = ? AND recipe_id = ?");
                $stmt->bind_param("si", $_SESSION['id'], $rid);
                $stmt->execute();
                $stmt->bind_result($existing_count);
                $stmt->fetch();
                $stmt->close();
                if ($existing_count > 0) {
                    exit(json_encode(["saved" => true]));
                } else  exit(json_encode(["saved" => false]));
            } else { exit(json_encode(["saved" => false])); }
        } else { exit(json_encode(["saved" => false])); }
    } elseif ($type === 'getSaved') {
        $stmt = $con->prepare("SELECT r.recipe_name, r.id FROM saved_recipes sr JOIN recipes r ON sr.recipe_id = r.id WHERE sr.userID = ?");
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
    } else {
        $data = [
            'error' => 'No order parameter provided'
        ];
        exit('No order');
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = ("SELECT id, recipeName, description, nIngredients, ingredients, nSteps, steps, cTime, nutrition, imgSrc, ranking, comments
                            FROM recipes where id = ?");
    $stmt = sqlsrv_prepare($con, $sql, array($id));
} else {
    $data = [
        'error' => 'No type parameter provided'
    ];
    exit('No type');
}


if ($stmt === false) {
    die(json_encode(array("error" => sqlsrv_errors())));
}
if (sqlsrv_execute($stmt) === false) {
    die(json_encode(array("error" => sqlsrv_errors())));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}
// Free statement and connection resources
sqlsrv_free_stmt($stmt);
sqlsrv_close($con);
// Return the JSON-encoded data
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>