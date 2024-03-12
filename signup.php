<?php
require 'assets/db/Conexion.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $check_email_sql = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bindParam(':email', $_POST['email']);
    $check_email_stmt->execute();
    $result = $check_email_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $message = 'Sorry, that email is already in use';
    } else {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql); 
        $stmt->bindParam(':email', $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $message = 'Successfully created new user';
            header("Location: login.php");
        } else {
            $message = 'Sorry there must have been an issue creating your account';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SignUp</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require 'partials/header.php' ?>

<?php if(!empty($message)): ?>
  <p> <?= $message ?></p>
<?php endif; ?>

<h1>SignUp</h1>
<span>or <a href="login.php">Login</a></span>

<form name="signupForm" action="signup.php" method="POST" onsubmit="return validateForm()">
  <input name="name" type="text" placeholder="Enter your name" required>
  <input name="lastname" type="text" placeholder="Enter your last name" required>
  <input name="email" type="email" placeholder="Enter your email" required>
  <input name="password" id="password" type="password" placeholder="Enter your Password" required>
  <input name="confirm_password" id="confirm_password" type="password" placeholder="Confirm Password" required>
  <input type="submit" value="Submit">
</form>

<script>
  function validateForm() {
    var password = document.forms["signupForm"]["password"].value;
    var confirm_password = document.forms["signupForm"]["confirm_password"].value;
    var name = document.forms["signupForm"]["name"].value;
    var lastname = document.forms["signupForm"]["lastname"].value;
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