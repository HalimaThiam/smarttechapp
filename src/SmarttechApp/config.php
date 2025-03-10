<?php
$servername = "localhost";
$username = "root"; // Remplace par ton utilisateur MySQL
$password = "passer"; // Remplace par ton mot de passe MySQL
$database = "smarttech_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}
?>
