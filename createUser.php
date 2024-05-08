<?php
include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $age = intval($_POST['age']);

  if (empty($name) || empty($email) || $age <= 0) {
    echo "Please fill out all required fields and ensure age is a positive number.";
    exit;
  }

  $sql = "INSERT INTO `users` (name, email, age) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $age);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
      header('location:user.php');
      exit;
    } else {
      echo "Error: " . mysqli_error($con);
    }
  } else {
    echo "Error preparing statement: " . mysqli_error($con);
  }

  mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Information Form</title>
  <link rel="stylesheet" href="css/createUser.css">
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <script>
    function validateForm() {
      var name = document.getElementById("name").value.trim();
      var email = document.getElementById("email").value.trim();
      var age = document.getElementById("age").value.trim();

      if (name === "" || email === "" || age === "") {
        alert("Please fill out all required fields.");
        return false;
      }

      var emailRegex = /^[\w-\.]+@([\w-]+\.)+[a-zA-Z]{2,4}$/;
      if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      if (isNaN(age) || age <= 0 || age > 100) {
        alert("Please enter a valid age.");
        return false;
      }

      return true;
    }
  </script>
</head>

<body>
  <nav class="navbar">
    <img src="asset/logo.png" class="img-logo" alt="CodeLK Logo">
    <a href="user.php" class="btn-home">Home</a>
  </nav>
  <form method="post" onsubmit="return validateForm()">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="age">Age</label>
    <input type="number" id="age" name="age" required>
    <br>
    <button type="submit" name="submit">Create User</button>
  </form>
</body>

</html>