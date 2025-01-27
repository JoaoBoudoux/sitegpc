<?php
$host = "localhost";
$dbname = "login_db";  
$username = "root";    
$password = "";        

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>