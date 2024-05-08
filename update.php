<?php
include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['updateid'] ?? null;
$name = $email = $age = '';

if ($id) {
  $fetchSql = "SELECT * FROM `users` WHERE id = ?";
  $stmt = mysqli_prepare($con, $fetchSql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $name = htmlspecialchars($row['name']);
    $email = htmlspecialchars($row['email']);
    $age = htmlspecialchars($row['age']);
  } else {
    echo "User not found.";
    exit;
  }
}

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $age = $_POST['age'];

  $sql = "UPDATE `users` SET name=?, email=?, age=? WHERE id=?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssii", $name, $email, $age, $id);
  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    header('location:user.php');
    exit;
  } else {
    echo "Error: " . mysqli_error($con);
  }
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
    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
    <br>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
    <br>
    <label for="age">Age</label>
    <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
    <br>
    <button type="submit" name="submit">Update User</button>
  </form>
</body>

</html>