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
    // Get the ID of the employee to delete
    $emp_id = $_POST['emp_id'];

    // Prepare the SQL query to delete the employee from both tables
    $sql = "DELETE employee, user FROM employee 
            LEFT JOIN user ON employee.ID = user.ID 
            WHERE employee.ID = $emp_id";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // Update the IDs in the employee table
        $updateIdsQuery = "SET @count = 0; UPDATE employee SET employee.ID = (@count:= @count + 1) ORDER BY employee.ID;";
        mysqli_query($conn, $updateIdsQuery);

        // Redirect the user to the employee list page
        header('Location: admin-emp_info.php');
        exit;
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Check if the "Update" button has been clicked
if (isset($_POST['update'])) {
    // Get the ID of the employee to update
    $emp_id = $_POST['emp_id'];

    // Redirect the user to the update employee page
    header("Location:admin-updateform_emp.php?id=$emp_id");
    exit;
}

// Pagination variables
$limit = 6; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate the offset for the SQL query
$offset = ($page - 1) * $limit;

// Prepare the SQL query to retrieve the total number of employees
$totalEmployeesQuery = "SELECT COUNT(*) AS total FROM employee";

// Execute the total employees query
$totalEmployeesResult = mysqli_query($conn, $totalEmployeesQuery);
$totalEmployeesRow = mysqli_fetch_assoc($totalEmployeesResult);
$totalEmployees = $totalEmployeesRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalEmployees / $limit);

// Prepare the SQL query to retrieve the list of employees with pagination
$sql = "SELECT * FROM employee LIMIT $limit OFFSET $offset";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Employee List</title>
    <link rel="stylesheet" type="text/css" href="style\admin-emp_info.css?v=<?php echo time(); ?>">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this information?');
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
        <h2>Employee List</h2>
        <div class="register-button">
            <a href="admin-register_emp.php">Register Employee</a>
        </div>
    </div>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>IC</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Date</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['Emp_name']; ?></td>
                        <td><?php echo $row['Emp_ic']; ?></td>
                        <td><?php echo $row['Emp_phonenum']; ?></td>
                        <td><?php echo $row['Emp_addr']; ?></td>
                        <td><?php echo $row['Emp_state']; ?></td>
                        <td><?php echo $row['Emp_date']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form method="post" action="admin-updateform_emp.php?id=<?php echo $row['id']; ?>">
                                <input type="hidden" name="emp_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="update" id="update">Update</button>
                            </form>
                            <form method="post" action="admin-emp_info.php" onsubmit="return confirmDelete();">
                                <input type="hidden" name="emp_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" id="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php } ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php } ?>
            <?php if ($page < $totalPages) { ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php } ?>
        </div>
    </div>
</body>

</html>