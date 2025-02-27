<?php
session_start();

require '../../db/conexion.php';

if (!isset ($_SESSION['user_email'])) {
    header('Location: http://localhost/edusogno/edusogno-esercizio/pages/login/login.php');
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
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I tuoi Eventi</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">

</head>

<body>
    <?php require '../../partials/header-on.php' ?>
    <div class="container-button">
        <a class="button create-event" href="http://localhost/edusogno/edusogno-esercizio/admin/create_event.php">Crea nuovo evento</a>
        <a class="button logout" href="http://localhost/edusogno/edusogno-esercizio/pages/logout/logout.php">Logout</a>
    </div>
    <h1>Ciao NOME ecco i tuoi eventi</h1>
    <?php if (empty ($events)): ?>
        <p class="no-events-message">Nessun evento trovato per questo utente.</p>
    <?php else: ?>
        <div class="listas-profile">

            <div class="events-list">
                <?php foreach ($events as $event): ?>
                    <div class="event-item">
                        <a class="button-close" href="http://localhost/edusogno/edusogno-esercizio/admin/delete_event.php?id=<?= $event['id'] ?>"
                            onclick="return confirm('¿Sei sicuro di voler eliminare questo evento?')">x</a>
                        <strong>
                            <?= $event['nome_evento'] ?>
                        </strong><br>
                        <div class="attendees-container">
                            Partecipanti:
                            <?= $event['attendees'] ?><br>
                        </div>
                        Data:
                        <?= $event['data_evento'] ?>
                        <a class="button">Unisciti</a>
                        <a class="button" href="http://localhost/edusogno/edusogno-esercizio/admin/edit_event.php?id=<?= $event['id'] ?>">Modifica</a>


                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</body>


</html>