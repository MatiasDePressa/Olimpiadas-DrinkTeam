<?php
$host = 'localhost'; // Cambia esto si tu base de datos está en un host diferente
$db = 'olimpiadas'; // Reemplaza con el nombre de tu base de datos
$user = 'root'; // Reemplaza con tu usuario de la base de datos
$pass = ''; // Reemplaza con tu contraseña de la base de datos

// Crear una conexión con la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
