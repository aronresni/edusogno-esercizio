<?php
  require '../../db/conexion.php';
$message = "";
session_start();

if (isset($_SESSION['user_email'])) {
  header('Location:  http://localhost/edusogno/edusogno-esercizio/pages/login/login.php');
}

if (
    !empty($_POST["email"]) && !empty($_POST["password"])
    && !empty($_POST["nome"]) && !empty($_POST["cognome"])
) {
    $name = $_POST["nome"];
    $lastname = $_POST["cognome"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    $sql = "INSERT INTO utenti (nome , cognome, email, password)
     VALUES(:nome , :cognome, :email, :password)";
    if ($conn) {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nome", $name);
        $stmt->bindParam(":cognome", $lastname);
        $stmt->bindParam(":email", $email);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $hashed_password);

        if ($stmt->execute()) {
            $message = "Registration successful";
            header("Location:  http://localhost/edusogno/edusogno-esercizio/pages/login/login.php");
        } else {
            $message = "Sorry, there was an error";
        }
    } else {
        echo "Error: No se pudo conectar a la base de datos.";
    }
} else {
    $message = "Email and password are required";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea il tuo account</title>
    <link rel="stylesheet" href="http://localhost/edusogno/edusogno-esercizio/assets/styles/style.css">
</head>

<body>
    <?php require 'partials/header.php' ?>
   
    <h1>Crea il tuo account</h1>
    <div class="container">

        <form action="signup.php" method="post" onsubmit="return validateForm()">
            <label>Inserisci il nome</label>
            <input type="text" name="nome" placeholder="Mario" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>">
            <label>Inserisci il cognome</label>
            <input type="text" name="cognome" placeholder="Rossi" value="<?php echo isset($_POST['cognome']) ? $_POST['cognome'] : ''; ?>">
            <label>Inserisci l’email</label>
            <input type="text" name="email" placeholder="name@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <label>Inserisci la password</label>
            <input type="password" name="password" placeholder="Scrivila qui">
            <?php if (!empty($message)): ?>
        <p style="color: red;">
            <?= $message  ?>
        </p>
    <?php endif; ?>

            <input class="button" type="submit" value="Send">
            <a href="login.php">Hai già un account? Accedi</a>
        </form>
    </div>

<script>
    function validateForm() {
        var password = document.forms["signupForm"]["password"].value;
       
        var name = document.forms["signupForm"]["nome"].value;
        var lastname = document.forms["signupForm"]["cognome"].value;
        var email = document.forms["signupForm"]["email"].value;

 

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Invalid email format");
            return false;
        }

        if (name.trim() === "" || lastname.trim() === "") {
            alert("Name and last name are required");
            return false;
        }

        return true;
    }
</script>

</body>

</html>