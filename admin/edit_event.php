<?php
require '../assets/db/Conexion.php';
require '../PhpMailer/Exception.php';
require '../PhpMailer/PHPMailer.php';
require '../PhpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    $sqlEvent = "SELECT * FROM eventi WHERE id = :id";
    $stmtEvent = $conn->prepare($sqlEvent);
    $stmtEvent->bindParam(':id', $eventId);
    $stmtEvent->execute();
    $event = $stmtEvent->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Evento no encontrado.";
        exit;
    }
} else {
    echo "ID de evento no proporcionado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombreEvento = $_POST['nombre_evento'];
    $asistentes = $_POST['asistentes'];
    $fechaEvento = $_POST['fecha_evento'];


    $sqlUpdate = "UPDATE eventi SET nome_evento = :nombre_evento, attendees = :asistentes, data_evento = :fecha_evento WHERE id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nombre_evento', $nombreEvento);
    $stmtUpdate->bindParam(':asistentes', $asistentes);
    $stmtUpdate->bindParam(':fecha_evento', $fechaEvento);
    $stmtUpdate->bindParam(':id', $eventId);
    $stmtUpdate->execute();

    if ($stmtUpdate->rowCount() > 0) {
        echo "Información del evento actualizada correctamente.";
        header('Location: ../profile.php');

    } else {
        echo "Error al actualizar la información del evento.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Evento</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>
<body>
    <h1>Modifica Evento</h1>
<a href="../profile.php" class="button"><--</a>
<div class="page-user">
    <form action="" method="POST">
        <label for="nombre_evento">Nome dell'Evento:</label><br>
        <input type="text" id="nombre_evento" name="nombre_evento" value="<?= $event['nome_evento'] ?>"><br>
        
        <label for="asistentes">Partecipanti (separati da virgole):</label><br>
        <input type="textarea" id="asistentes" name="asistentes" value="<?= $event['attendees'] ?>"><br>

        <label for="fecha_evento">Data dell'Evento:</label><br>
        <input type="datetime-local" id="fecha_evento" name="fecha_evento" value="<?= date('Y-m-d\TH:i', strtotime($event['data_evento'])) ?>"><br>

        <input class="button" type="submit" value="Salva Modifiche">

        <a  class="button" href="admin_panel.php">Torna</a>
    </form>
</div>
</body>
</html>
