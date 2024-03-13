
<?php
session_start();

require 'assets/db/Conexion.php'; 

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit; 
}

$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM eventi WHERE attendees LIKE :user_email";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_email', '%' . $user_email . '%');
$stmt->execute();

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>
<body>
<?php require 'partials/header-on.php' ?>
<div class="container-button">
    <a class="button" href="admin/create_event.php">Crear nuevo evento</a>
    <a class="button" href="logout.php">Logout</a>
</div>
    <h1>Ciao NOME ecco i tuoi eventi</h1>
    <?php if (empty($events)): ?>
    <p class="no-events-message">No events found for this user.</p>
<?php else: ?>
    <div class="listas-profile">

        <div class="events-list">
            <?php foreach ($events as $event): ?>
                <div class="event-item">
                    <strong><?= $event['nome_evento'] ?></strong><br>
                    Attendees: <?= $event['attendees'] ?><br>
                    Date: <?= $event['data_evento'] ?>
                    <a class="button">Join</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php endif; ?>

</body>
</html>
