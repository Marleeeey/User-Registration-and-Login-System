<?php
    session_start();

    require "db.php";

    if ($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //PREPARE THE SQL FUNCTION
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        //CHECK IF THE DATE SUCCEFULLY ADDED TO THE DATABASE
        if ($stmt->execute())
        {
            $_SESSION['message'] = "Registration successful! You can now log in.";
            header ("Location: login.php");
            exit;
        }
        else 
        {
            $_SESSION['error'] = "Registration failed!" .$stmt->error;
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="styles.css" />
  <!-- Font Awesome CDN link for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>
  <div class="wrapper">
    <div class="title"><span>Register Form</span></div>
    <form action="" method = "POST">
      <div class="row">
        <i class="fas fa-user"></i>
        <input type="email" placeholder="Email or Phone" name = "username" required />
      </div>
      <div class="row">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name = "password" required />
      </div>
      <div class="row button">
        <input type="submit" value="Register" />
      </div>
      <div class="signup-link">Not a member? <a href="login.php">sign now</a></div>
    </form>
    <?php if (isset($_SESSION['error'])): ?>
        <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
  </div>
</body>
</html>