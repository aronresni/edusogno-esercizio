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
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Nuovo Evento</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>
<body>
    <h1>Crea Nuovo Evento</h1>
    <a href="../profile.php" class="button"><--</a>
    <div class="page-user">
    <form action="create_event.php" method="POST" class="form-create-event">
        <label for="nombre_evento">Nome dell'Evento:</label><br>
        <input type="text" id="nombre_evento" name="nombre_evento" required><br>
        
        <label  for="asistentes">Partecipanti (separati da virgole):</label><br>
        <textarea  id="asistentes" name="asistentes" rows="4" cols="50" required></textarea><br>

        <label for="fecha_evento">Data dell'Evento:</label><br>
        <input type="datetime-local" id="fecha_evento" name="fecha_evento" required><br>

        <input class="button" type="submit" value="Crea Evento">
         <a class="button" href="admin_panel.php">Visualizza informazioni</a>
    </form>
    </div>
</body>
</html>
