<?php
require "../assets/db/conexion.php";
$message = "";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $sql = "INSERT INTO users (email, password) VALUES(:email, :password,)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $_POST["email"]);

    //primero ciframos la contraseña para que no se vea en la base de dat
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt->bindParam(":password", $password);

    if ($stmt->execute()) {
        $message = "Registration successful";
    } else {
        $message = "Sorry, there was an error";
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
<?php require '../partials/header.php' ?>
    <?php
    if (!empty($message)): ?>
        <p>
            <?= $message ?>
        </p>
    <?php endif; ?>



    <h1>Sign Up</h1>
    <form action="signup.php" method="post">
        <input type="text" name="name" placeholder="Enter your first name">
        <input type="text" name="lastname" placeholder="Enter yout last name">
        <input type="text" name="email" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">
        <input type="password" name="confirm_password" placeholder="Confirm your password">
        <input type="submit" value="Send">
</body>

</html>