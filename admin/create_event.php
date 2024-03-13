<?php
require '../assets/db/Conexion.php';
require '../PhpMailer/Exception.php';
require '../PhpMailer/PHPMailer.php';
require '../PhpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEvento = $_POST['nombre_evento'];
    $asistentes = $_POST['asistentes'];
    $fechaEvento = $_POST['fecha_evento'];

    $sqlInsert = "INSERT INTO eventi (nome_evento, attendees, data_evento) VALUES (:nombre_evento, :asistentes, :fecha_evento)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':nombre_evento', $nombreEvento);
    $stmtInsert->bindParam(':asistentes', $asistentes);
    $stmtInsert->bindParam(':fecha_evento', $fechaEvento);
    $stmtInsert->execute();

    if ($stmtInsert->rowCount() > 0) {
        echo "Evento creado correctamente.";
       
    } else {
        echo "Error al crear el evento.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento</title>
</head>
<body>
    <h1>Crear Nuevo Evento</h1>

    <form action="create_event.php" method="POST">
        <label for="nombre_evento">Nombre del Evento:</label><br>
        <input type="text" id="nombre_evento" name="nombre_evento" required><br>
        
        <label for="asistentes">Asistentes (separados por comas):</label><br>
        <textarea id="asistentes" name="asistentes" rows="4" cols="50" required></textarea><br>

        <label for="fecha_evento">Fecha del Evento:</label><br>
        <input type="datetime-local" id="fecha_evento" name="fecha_evento" required><br>

        <input type="submit" value="Crear Evento">
         <a href="admin_panel.php">Ver información</a>
    </form>
</body>
</html>
