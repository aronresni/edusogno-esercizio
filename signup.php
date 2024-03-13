<?php
require "assets/db/conexion.php";
$message = "";
session_start();

if (isset($_SESSION['user_email'])) {
  header('Location: profile.php');
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
            header("Location: login.php");
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
    <title>Sign Up</title>
</head>

<body>
    <?php require 'partials/header.php' ?>
    <?php if (!empty($message)): ?>
        <p>
            <?= $message ?>
        </p>
    <?php endif; ?>
    <h1>Sign Up</h1>
    <form action="signup.php" method="post" onsubmit="return validateForm()">
    <input type="text" name="nome" placeholder="Enter your first name" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>">
    <input type="text" name="cognome" placeholder="Enter your last name" value="<?php echo isset($_POST['cognome']) ? $_POST['cognome'] : ''; ?>">
    <input type="text" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
    <input type="password" name="password" placeholder="Enter your password">
    <input type="password" name="confirm_password" placeholder="Confirm your password">
    <input type="submit" value="Send">
</form>

<script>
    function validateForm() {
        var password = document.forms["signupForm"]["password"].value;
        var confirm_password = document.forms["signupForm"]["confirm_password"].value;
        var name = document.forms["signupForm"]["nome"].value;
        var lastname = document.forms["signupForm"]["cognome"].value;
        var email = document.forms["signupForm"]["email"].value;

        if (password != confirm_password) {
            alert("Passwords do not match");
            return false;
        }

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