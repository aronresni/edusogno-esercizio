<?php
require '../assets/db/Conexion.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_email'] !== 'aronresni@gmail.com') {
    header('Location: ../profile.php');
    exit;
}

try {
    $sqlUsers = "SELECT * FROM utenti";
    $stmtUsers = $conn->query($sqlUsers);
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    $sqlEvents = "SELECT * FROM eventi";
    $stmtEvents = $conn->query($sqlEvents);
    $events = $stmtEvents->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Connection Failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Amministratore</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>
<body>
    <h1>Pannello Amministratore</h1>

    <h1>Utenti</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Password</th>
            <th>Modifica</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['nome'] ?></td>
            <td><?= $user['cognome'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['password'] ?></td>
            <td><a href="edit_user.php?id=<?= $user['id'] ?>">Modifica</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Eventi</h1>
    <a class="button" href="create_event.php">Crea Nuovo Evento</a>
    <a class="button" href="../profile.php"> Profile</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Partecipanti</th>
            <th>Nome dell'Evento</th>
            <th>Data dell'Evento</th>
            <th>Modifica</th> 
        </tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event['id'] ?></td>
            <td><?= $event['attendees'] ?></td>
            <td><?= $event['nome_evento'] ?></td>
            <td><?= $event['data_evento'] ?></td>
            <td><a href="edit_event.php?id=<?= $event['id'] ?>">Modifica</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
