<?php
include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['deleteid']) && filter_var($_GET['deleteid'], FILTER_VALIDATE_INT)) {
  $id = $_GET['deleteid'];

  $sql = "DELETE FROM `users` WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
      header("Location: {$_SERVER['HTTP_REFERER']}");
      exit;
    } else {
      echo "Error deleting record: " . mysqli_error($con);
    }
  } else {
    echo "Error preparing statement: " . mysqli_error($con);
  }

  mysqli_stmt_close($stmt);
} else {
  echo "Invalid delete request.";
}
