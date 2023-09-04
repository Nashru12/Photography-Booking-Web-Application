<?php
// Start a session
session_start();

// Check if the user is an admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect the user to the login page
    header('Location: index.php');
    exit;
}

include 'connect.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $emp_id = $_POST['emp_id'];
    $emp_name = isset($_POST['emp_name']) ? $_POST['emp_name'] : '';
    $emp_ic = isset($_POST['emp_ic']) ? $_POST['emp_ic'] : '';
    $emp_phonenum = isset($_POST['emp_phonenum']) ? $_POST['emp_phonenum'] : '';
    $emp_addr = isset($_POST['emp_addr']) ? $_POST['emp_addr'] : '';
    $emp_state = isset($_POST['emp_state']) ? $_POST['emp_state'] : '';
    $emp_date = isset($_POST['emp_date']) ? $_POST['emp_date'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Check if the required fields are filled in
    if ($emp_name && $emp_ic && $emp_phonenum && $emp_addr && $emp_state && $emp_date) {
        // Prepare the SQL query to update the employee
        $sql = "UPDATE employee SET Emp_name = '$emp_name', Emp_ic = '$emp_ic', Emp_phonenum = '$emp_phonenum',
                Emp_addr = '$emp_addr', Emp_state = '$emp_state', Emp_date = '$emp_date', role = '$role'  WHERE id = $emp_id";

        // Execute the SQL query
        if (mysqli_query($conn, $sql)) {
            // Redirect the user to the employee list page
            header('Location: admin-emp_info.php');
            exit;
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}

// Check if the employee ID is provided in the URL
if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    // Prepare the SQL query to retrieve the employee's information
    $sql = "SELECT * FROM employee WHERE id = $emp_id";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if a package was found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Redirect the user if the package was not found
        header('Location: admin-emp_info.php');
        exit;
    }
} else {
    // Redirect the user if the package ID is not provided
    header('Location: admin-emp_info.php');
    exit;
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style\admin-updateform_emp.css?v=<?php echo time(); ?>">
    <title>Update Form</title>
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

    <form method="POST" action="admin-updateform_emp.php?id=<?php echo $row['id']; ?>">
        <input type="hidden" name="emp_id" value="<?php echo $row['id']; ?>">
        <label for="package_name">Name:</label>
        <input type="text" name="emp_name" value="<?php echo $row['Emp_name']; ?>">
        <label for="package_name">IC Number:</label>
        <input type="text" name="emp_ic" value="<?php echo $row['Emp_ic']; ?>">
        <label for="package_name">Phone Number:</label>
        <input type="text" name="emp_phonenum" value="<?php echo $row['Emp_phonenum']; ?>">
        <label for="package_name">Address:</label>
        <input type="text" name="emp_addr" value="<?php echo $row['Emp_addr']; ?>">
        <label for="package_name">State:</label>
        <input type="text" name="emp_state" value="<?php echo $row['Emp_state']; ?>">
        <label for="package_name">Start Date:</label>
        <input type="text" name="emp_date" value="<?php echo $row['Emp_date']; ?>">
        <label for="package_name">Role:</label>
        <input type="text" name="role" value="<?php echo $row['role']; ?>">
        <input type="submit" value="Update">
    </form>

</body>

</html>