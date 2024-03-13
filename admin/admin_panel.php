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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>

    <h2>Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Editar</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['nome'] ?></td>
            <td><?= $user['cognome'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['password'] ?></td>
            <td><a href="edit_user.php?id=<?= $user['id'] ?>">Editar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Eventos</h2>
    <a href="create_event.php">Crear Evento Nuevo</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Asistentes</th>
            <th>Nombre del Evento</th>
            <th>Fecha del Evento</th>
            <th>Editar</th> 
        </tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event['id'] ?></td>
            <td><?= $event['attendees'] ?></td>
            <td><?= $event['nome_evento'] ?></td>
            <td><?= $event['data_evento'] ?></td>
            <td><a href="edit_event.php?id=<?= $event['id'] ?>">Editar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
