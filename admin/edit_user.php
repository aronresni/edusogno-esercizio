<?php
require '../assets/db/Conexion.php';
require '../PhpMailer/Exception.php';
require '../PhpMailer/PHPMailer.php';
require '../PhpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sqlUser = "SELECT * FROM utenti WHERE id = :id";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bindParam(':id', $userId);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sqlUpdate = "UPDATE utenti SET nome = :nombre, cognome = :apellido, email = :email, password = :password WHERE id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nombre', $nombre);
    $stmtUpdate->bindParam(':apellido', $apellido);
    $stmtUpdate->bindParam(':email', $email);
    $stmtUpdate->bindParam(':password', $password);
    $stmtUpdate->bindParam(':id', $userId);
    $stmtUpdate->execute();

    if ($stmtUpdate->rowCount() > 0) {
        echo "Información de usuario actualizada correctamente.";
        header('Location: admin_panel.php');
    } else {
        echo "Error al actualizar la información del usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>
<body>

    <h1>Modifica Utente</h1>
<div class="page-user">

    <form action="" method="POST" class="user-container">
        
        <label for="nombre">Nome:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?= $user['nome'] ?>"><br>
    
    <label for="apellido">Cognome:</label><br>
    <input type="text" id="apellido" name="apellido" value="<?= $user['cognome'] ?>"><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?>"><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" value="<?= $user['password'] ?>"><br>

    <input  class="button" type="submit" value="Salva Modifiche">
    <a  class="button" href="admin_panel.php">Visualizza informazioni</a>
</form>
</div>
