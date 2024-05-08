<?php
session_start();
$login_error = "";

if (isset($_SESSION['user_id'])) {

    header("Location: user.php");
    exit;
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT password FROM `userauth` WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashed_db_password);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $hashed_db_password)) {
        $_SESSION['user_id'] = $email;
        header("Location: user.php");
        exit;
    } else {
        $login_error = "Invalid email or password!!!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            if (email.trim() === "" || password.trim() === "") {
                alert("Please fill in all fields.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <nav class="navbar">
        <img src="asset/logo.png" class="img-logo" alt="CodeLK Logo">
        <h2>Login</h2>
    </nav>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="submit">Login</button>

        <?php if (!empty($login_error)) echo "<div class='error'><p class='error-message'>$login_error</p></div>"; ?>
    </form>

</body>

</html>