<?php
require '../assets/db/Conexion.php';
require '../PhpMailer/Exception.php';
require '../PhpMailer/PHPMailer.php';
require '../PhpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si se proporcionó un ID de evento en la URL
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

// Procesar los datos del formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombreEvento = $_POST['nombre_evento'];
    $asistentes = $_POST['asistentes'];
    $fechaEvento = $_POST['fecha_evento'];

    // Actualizar la información del evento en la base de datos
    $sqlUpdate = "UPDATE eventi SET nome_evento = :nombre_evento, attendees = :asistentes, data_evento = :fecha_evento WHERE id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nombre_evento', $nombreEvento);
    $stmtUpdate->bindParam(':asistentes', $asistentes);
    $stmtUpdate->bindParam(':fecha_evento', $fechaEvento);
    $stmtUpdate->bindParam(':id', $eventId);
    $stmtUpdate->execute();

    // Verificar si se realizó la actualización correctamente
    if ($stmtUpdate->rowCount() > 0) {
        echo "Información del evento actualizada correctamente.";

    } else {
        echo "Error al actualizar la información del evento.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
</head>
<body>
    <h1>Editar Evento</h1>

    <form action="" method="POST">
        <label for="nombre_evento">Nombre del Evento:</label><br>
        <input type="text" id="nombre_evento" name="nombre_evento" value="<?= $event['nome_evento'] ?>"><br>
        
        <label for="asistentes">Asistentes (separados por comas):</label><br>
        <input type="textarea" id="asistentes" name="asistentes" value="<?= $event['attendees'] ?>"><br>

        <label for="fecha_evento">Fecha del Evento:</label><br>
        <input type="datetime-local" id="fecha_evento" name="fecha_evento" value="<?= date('Y-m-d\TH:i', strtotime($event['data_evento'])) ?>"><br>

        <input type="submit" value="Guardar Cambios">

        <a href="admin_panel.php">Volver</a>
    </form>
</body>
</html>
