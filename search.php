<?php
include 'db_connection.php';

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT * FROM `users`";
if (!empty($search)) {
    $sql .= " WHERE `name` LIKE ? OR `email` LIKE ?";
    $searchParam = "%{$search}%";
}

if ($stmt = mysqli_prepare($con, $sql)) {
    if (!empty($search)) {
        mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);
    }
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = htmlspecialchars($row['id']);
            $name = htmlspecialchars($row['name']);
            $email = htmlspecialchars($row['email']);
            $age = htmlspecialchars($row['age']);

            echo '
            <tr>
                <td>' . $id . '</td>
                <td>' . $name . '</td>
                <td>' . $email . '</td>
                <td>' . $age . '</td>
                <td><button><a href="update.php?updateid=' . $id . '">Update</a></button></td>
                <td><button class="delete-button"><a href="#" onclick="confirmDelete(' . $id . ')">Delete</a></button></td>
            </tr>';
        }
    } else {
        echo "No records found.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($con);
}
?>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = 'delete.php?deleteid=' + id;
        }
    }
</script>