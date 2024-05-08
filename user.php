<?php
include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $search = mysqli_real_escape_string($con, $search);
}

$rowsPerPage = 8;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$startingLimit = ($page - 1) * $rowsPerPage;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLk Coursework</title>
    <link rel="stylesheet" href="css/user.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
</head>

<body>
    <nav class="navbar">
        <img src="asset/logo.png" class="img-logo" alt="CodeLK Logo">
        <form method="GET" action="user.php" class="search-form" id="searchForm">
            <input type="text" id="searchInput" name="search" placeholder="Search by name or email" value="<?php echo htmlspecialchars($search); ?>">
        </form>
        <div>
            <a href="createUser.php" class="btn-create-user">Create User</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

    </nav>
    <div class="container">

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users`";
                if (!empty($search)) {
                    $sql .= " WHERE `name` LIKE ? OR `email` LIKE ?";
                }
                $sql .= " LIMIT ?, ?";

                $stmt = mysqli_prepare($con, $sql);
                if ($stmt) {
                    if (!empty($search)) {
                        $param = "%{$search}%";
                        mysqli_stmt_bind_param($stmt, "ssii", $param, $param, $startingLimit, $rowsPerPage);
                    } else {
                        mysqli_stmt_bind_param($stmt, "ii", $startingLimit, $rowsPerPage);
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

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
                                <td><button class="delete-button"><a href="delete.php?deleteid=' . $id . '">Delete</a></button></td>
                            </tr>';
                    }
                } else {
                    error_log("Failed to execute the SQL query: " . mysqli_error($con));
                    echo "An error occurred while retrieving data. Please try again later.";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            $sql = "SELECT COUNT(*) AS count FROM `users`";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalRows = $row['count'];

            $totalPages = ceil($totalRows / $rowsPerPage);

            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<button class="btn-pages"><a href="user.php?page=' . htmlspecialchars($i) . '">' . htmlspecialchars($i) . '</a></button>';
            }
            ?>
        </div>

    </div>

    <script>
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const userTableBody = document.querySelector('.user-table tbody');
        const paginationLinks = document.querySelector('.pagination');

        searchInput.addEventListener('input', function() {
            clearTimeout(this.timer);
            this.timer = setTimeout(function() {
                performSearch();
            }, 200);
        });

        function performSearch() {
            const searchValue = searchInput.value.trim();
            fetch(`search.php?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.text())
                .then(data => {
                    userTableBody.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const confirmation = confirm("Are you sure you want to delete this user?");
                if (confirmation) {

                    window.location.href = this.querySelector('a').href;
                }
            });
        });
    </script>


</body>

</html>