<?php
$dsn = 'mysql:host=localhost;dbname=northwestgf';
$username = 'root';
$password = 'Pa$$w0rd';

//Verify database authentication, display error if invalid
try {
    $db = new PDO($dsn, $username, $password);

} catch (PDOException $e) {
    $error_message = $e->getMessage();
    //echo "DB Authentication Error: " . $error_message; 
    exit();
    }




?>
