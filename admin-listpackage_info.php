<?php
// Start a session
session_start();

// Check if the user is an admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect the user to the login page
    header('Location: index.php');
    exit;
}

// Include the database connection file
include 'connect.php';

// Check if the delete button has been clicked
if (isset($_POST['delete'])) {
    // Get the ID of the package to delete
    $package_id = $_POST['package_id'];

    // Prepare the SQL query to delete the package from the table
    $sql = "DELETE FROM packages WHERE package_id = $package_id";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // Redirect the user to the package list page
        header('Location: admin-listpackage_info.php');
        exit;
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Check if the "Update" button has been clicked
if (isset($_POST['update'])) {
    // Get the ID of the package to update
    $package_id = $_POST['package_id'];

    // Redirect the user to the update package page
    header("Location: admin-updateform_package.php?id=$package_id");
    exit;
}

// Add the following variables to configure pagination
$rowsPerPage = 5; // Number of rows to display per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Get the current page number
$startRow = ($page - 1) * $rowsPerPage; // Calculate the starting row for the current page

// Prepare the SQL query to retrieve a limited number of packages based on pagination
$sql = "SELECT * FROM packages LIMIT $startRow, $rowsPerPage";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Get the total number of packages
$totalPackages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM packages"));

// Calculate the total number of pages
$totalPages = ceil($totalPackages / $rowsPerPage);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Package List</title>
    <link rel="stylesheet" type="text/css" href="style\admin-listpackage_info.css?v=<?php echo time(); ?>">
    <style>
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: #305573;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: 1px solid #305573;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #305573;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this package?');
        }
    </script>
</head>

<body>

    <nav>
        <ul>
            <div class="logo">
                <img src="images\logo company.jpg" alt="Logo">
            </div>
            <li><a href="admin-dashboard.php" class="active">Dashboard</a></li>
            <li><a href="admin-emp_info.php">Employee Information</a></li>
            <li><a href="admin-listpackage_info.php">Package Information</a></li>
            <li><a href="admin-listbooking.php">Booking</a></li>
            <li><a href="admin-contact.php">Contact</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <div class="header-container">
        <h2>Package List</h2>
        <div class="register-button">
            <a href="admin-register_package.php">New Package</a>
        </div>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package Name</th>
                    <th>Package Price</th>
                    <th>Information 1</th>
                    <th>Information 2</th>
                    <th>Information 3</th>
                    <th>Information 4</th>
                    <th>Information 5</th>
                    <th>Information 6</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['package_id']; ?></td>
                        <td><?php echo $row['package_name']; ?></td>
                        <td><?php echo $row['package_price']; ?></td>
                        <td><?php echo $row['information_1']; ?></td>
                        <td><?php echo $row['information_2']; ?></td>
                        <td><?php echo $row['information_3']; ?></td>
                        <td><?php echo $row['information_4']; ?></td>
                        <td><?php echo $row['information_5']; ?></td>
                        <td><?php echo $row['information_6']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td>
                            <form method="post" action="admin-updateform_package.php?id=<?php echo $row['package_id']; ?>">
                                <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
                                <button type="submit" name="update" id="update">Update</button>
                            </form>
                            <form method="post" action="admin-listpackage_info.php" onsubmit="return confirmDelete();">
                                <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
                                <button type="submit" name="delete" id="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
            <?php } ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i === $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php } ?>
            <?php if ($page < $totalPages) { ?>
                <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php } ?>
        </div>
    </div>
</body>

</html>