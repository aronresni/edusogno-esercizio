<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login for EduSog</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
<?php require '../partials/header.php' ?>
    <h1>Log In</h1>
    <form action="login.php" method="post">
        <input type="text" name="email" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">
<input type="submit" value="Send">
</body>

</html>