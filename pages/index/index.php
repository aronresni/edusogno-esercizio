<?php
  session_start();

  require '../../db/conexion.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to you WebApp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">

  </head>
  <body>

    <?php require '../../partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <br> Welcome. <?= $user['email']; ?>
      <br>You are Successfully Logged In
      <a href="http://localhost/edusogno/edusogno-esercizio/pages/logout/logout.php">
        Logout
      </a>
    <?php else: ?>
      <h1>Crea il tuo account</h1>

      <a class="button" href="http://localhost/edusogno/edusogno-esercizio/pages/login/login.php">ACCEDI</a> or
      <a class="button" href="http://localhost/edusogno/edusogno-esercizio/pages/signup/signup.php">REGISTRATI</a>
    <?php endif; ?>
  </body>
</html>