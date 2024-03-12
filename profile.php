<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit; // Detener la ejecución del script para evitar que se siga cargando la página
}

require 'assets/db/Conexion.php';

// Preparar la consulta SQL para obtener los eventos del usuario actual
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM eventi WHERE user_email = :user_email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();

// Obtener los resultados de la consulta
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events</title>
</head>
<body>
    <h1>Your Events</h1>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <strong><?= $event['nome_evento'] ?></strong><br>
                Attendees: <?= $event['attendees'] ?><br>
                Date: <?= $event['data_evento'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
