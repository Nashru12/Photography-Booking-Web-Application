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

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $emp_name = $_POST['emp_name'];
    $emp_ic = $_POST['emp_ic'];
    $emp_phonenum = $_POST['emp_phonenum'];
    $emp_addr = $_POST['emp_addr'];
    $emp_state = $_POST['emp_state'];
    $emp_date = $_POST['emp_date'];
    $email = $_POST['User_email'];
    $password = password_hash($_POST['User_pass'], PASSWORD_DEFAULT);
    $role = $_POST['User_role'];


    // Prepare the SQL query to insert a new employee
    // Prepare the SQL query to insert a new employee and a new user
    $sql = "INSERT INTO employee (Emp_name, Emp_ic, Emp_phonenum, Emp_addr, Emp_state, Emp_date, role) VALUES ('$emp_name', '$emp_ic', '$emp_phonenum', '$emp_addr', '$emp_state', '$emp_date', '$role'); INSERT INTO user (User_email, User_pass, User_role) VALUES ('$email', '$password', '$role')";

    // Execute the SQL query
    if (mysqli_multi_query($conn, $sql)) {
        // Redirect the user to the admin dashboard
        header('Location: admin-dashboard.php');
        exit;
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register Employee</title>
    <link rel="stylesheet" type="text/css" href="style\admin-register_emp.css?v=<?php echo time(); ?>">
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
    <!-- <div class="container">
        <h1>Register Employee</h1>
    </div>
    <br> -->

    <form method="post">
        <h2>REGISTER EMPLOYEE</h2>
        <label for="emp_name">Name:</label>
        <input type="text" id="emp_name" name="emp_name" required><br>
        <label for="emp_ic">IC:</label>
        <input type="text" id="emp_ic" name="emp_ic" required><br>
        <label for="emp_phonenum">Phone Number:</label>
        <input type="text" id="emp_phonenum" name="emp_phonenum" required><br>
        <label for="emp_addr">Address:</label>
        <input type="text" id="emp_addr" name="emp_addr" required><br>
        <label for="emp_state">State:</label>
        <input type="text" id="emp_state" name="emp_state" required><br>
        <label for="emp_date">Date:</label>
        <input type="date" id="emp_date" name="emp_date" required><br>
        <label for="User_role">Role:</label>
        <select id="User_role" name="User_role" required onchange="toggleEmailPassword(this.value)">
            <option value="">Select Role</option>
            <option value="admin">admin</option>
            <option value="photographer">photographer</option>
        </select><br>
        <label for="User_email">Email:</label>
        <input type="email" id="User_email" name="User_email" <?php echo (isset($_POST['User_role']) && $_POST['User_role'] === 'admin') ? 'required' : 'readonly'; ?>><br>
        <label for="User_pass">Password:</label>
        <input type="password" id="User_pass" name="User_pass" <?php echo (isset($_POST['User_role']) && $_POST['User_role'] === 'admin') ? 'required' : 'readonly'; ?>><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        function toggleEmailPassword(role) {
            var emailInput = document.getElementById('User_email');
            var passwordInput = document.getElementById('User_pass');

            if (role === 'photographer') {
                emailInput.readOnly = true;
                passwordInput.readOnly = true;
                emailInput.removeAttribute('required');
                passwordInput.removeAttribute('required');
            } else {
                emailInput.readOnly = false;
                passwordInput.readOnly = false;
                emailInput.setAttribute('required', 'required');
                passwordInput.setAttribute('required', 'required');
            }
        }
    </script>
</body>
</html>