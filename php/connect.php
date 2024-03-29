<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'recipeXwede');
define('DB_PASSWORD', '184273396Ben.');
define('DB_NAME', 'recipe_db');
 
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($con === false){
    exit("ERROR: Could not connect. " . mysqli_connect_error());
}

?>