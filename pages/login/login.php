<?php
session_start();

if (isset($_SESSION['user_email'])) {
  header('Location: ../profile/profile.php');
}

require '../../db/conexion.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $records = $conn->prepare('SELECT email, password FROM utenti WHERE email = :email');
  $records->bindParam(':email', $_POST['email']);
  $records->execute();
  $user = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user_email'] = $user['email'];
    header("Location: login.php");
  } else {
    $message = 'Sorry, those credentials do not match';
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
  </head>
  <body>
  <?php require '../../partials/header.php' ?>


    <h1>Hai già un account?</h1>
<div class="container">
  <form action="http://localhost/edusogno/edusogno-esercizio/pages/login/login.php" method="POST">
    <label>Inserisci l’e-mail</label>
    <input name="email" type="text" placeholder="Enter your email">
    <label>Inserisci la password</label>
    <input name="password" type="password" placeholder="Enter your Password">
    <?php if (!empty($message)): ?>
        <p style="color: red;">
            <?= $message  ?>
        </p>
    <?php endif; ?>
    <input class="button" type="submit" value="ACCEDI">
    
    <a href="http://localhost/edusogno/edusogno-esercizio/pages/signup/signup.php">Non hai ancora un profilo? Registrati</a>
    </form>
  </body>
</html>