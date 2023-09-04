<?php
include 'connect.php';

session_start();
if ($_SESSION['user_role'] !== 'admin') {
  header('Location: index.php');
  exit;
}

// Fetch total sales from the sales table based on event dates from the booking table
$query = "SELECT MONTH(b.event_date) AS month, SUM(s.amount) AS monthly_sales FROM sales s INNER JOIN booking b ON s.booking_id = b.booking_id GROUP BY MONTH(b.event_date)";
$result = mysqli_query($conn, $query);
$sales_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Prepare an array to store monthly sales data
$monthly_sales = [];
for ($i = 1; $i <= 12; $i++) {
  $monthly_sales[$i] = 0;
}

// Populate the monthly sales array with the fetched data
foreach ($sales_data as $data) {
  $month = $data['month'];
  $monthly_sales[$month] = $data['monthly_sales'];
}

// Fetch monthly earnings based on the selected year from the booking table
$selected_year = isset($_GET['year']) ? $_GET['year'] : (int)date('Y');

$monthly_query = "SELECT MONTH(b.event_date) AS month, SUM(s.amount) AS monthly_earnings FROM sales s INNER JOIN booking b ON s.booking_id = b.booking_id";

if (isset($_GET['year'])) {
  $monthly_query .= " WHERE YEAR(b.event_date) = $selected_year";
}

$monthly_query .= " GROUP BY MONTH(b.event_date)";
$monthly_result = mysqli_query($conn, $monthly_query);
$monthly_sales_data = mysqli_fetch_all($monthly_result, MYSQLI_ASSOC);

// Prepare an array to store monthly earnings data
$monthly_earnings = [];
for ($i = 1; $i <= 12; $i++) {
  $monthly_earnings[$i] = 0;
}

// Populate the monthly earnings array with the fetched data
foreach ($monthly_sales_data as $data) {
  $month = $data['month'];
  $monthly_earnings[$month] = $data['monthly_earnings'];
}

// Fetch total number of employees
$employee_query = "SELECT COUNT(*) AS total_employee FROM employee";
$employee_result = mysqli_query($conn, $employee_query);
$employee_row = mysqli_fetch_assoc($employee_result);
$total_employees = $employee_row['total_employee'];

// Fetch total number of bookings
$booking_query = "SELECT COUNT(*) AS total_bookings FROM booking";
$booking_result = mysqli_query($conn, $booking_query);
$booking_row = mysqli_fetch_assoc($booking_result);
$total_bookings = $booking_row['total_bookings'];

// Fetch list of packages with name and picture
$package_query = "SELECT package_name, image_link FROM packages";
$package_result = mysqli_query($conn, $package_query);
$packages = mysqli_fetch_all($package_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="style\admin-dashboard.css?v=<?php echo time(); ?>">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
  <h2>Dashboard</h2>
  <div class="container">
    <div class="box">
      <div class="inner-box" style="width: 90%;">
        <h3 style="margin-top:-4px;">Annual Earning</h3>
        <form id="earningForm" method="GET" action="admin-dashboard.php">
          <select name="year">
            <?php for ($year = date('Y'); $year >= 2000; $year--) : ?>
              <option value="<?php echo $year; ?>" <?php if ($selected_year == $year) echo 'selected'; ?>><?php echo $year; ?></option>
            <?php endfor; ?>
          </select>
          <input type="submit" value="View">
        </form>
        <p id="earningValue" style="font-weight:normal;">RM<?php echo htmlspecialchars(array_sum($monthly_earnings)); ?></p>

      </div>
    </div>
    <div class="box">
      <div class="inner-box" style="width: 90%;height:75%;">
        <h3 style="margin:auto;">Monthly Earning</h3>
        <form id="monthlyEarningForm" method="GET" action="admin-monthlysale-report.php">
          <select name="month">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
          <input type="hidden" name="year" value="<?php echo $selected_year; ?>">
          <input type="submit" value="View">
        </form>
      </div>
    </div>

    <div class="box">
      <div class="inner-box" style="width:90%;">
        <h3>Total Employees</h3>
        <p id="employeeValue"><?php echo htmlspecialchars($total_employees); ?></p>
      </div>
    </div>
    <div class="box">
      <div class="inner-box" style="width:90%;">
        <h3>Total Bookings</h3>
        <p id="bookingValue"><?php echo htmlspecialchars($total_bookings); ?></p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="package-list">
      <h3 id="pakej">Packages</h3>
      <a class="add-package-button" href="admin-register_package.php">Add Package</a>

      <table>
        <tr>
          <th>Package</th>
          <th>Image</th>
        </tr>
        <?php foreach ($packages as $package) : ?>
          <tr>
            <td><?php echo $package['package_name']; ?></td>
            <td><img src="images/<?php echo $package['image_link']; ?>" alt="<?php echo $package['package_name']; ?>"></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>


    <div class="chart">
      <canvas id="salesChart"></canvas>
    </div>
  </div>

  <script>
    // Chart.js code
    // Chart.js code
    const chartYear = <?php echo $selected_year; ?>;
    const monthlyEarnings = <?php echo json_encode(array_values($monthly_earnings)); ?>;
    const chartLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: chartLabels,
        datasets: [{
          label: `Monthly Sales (${chartYear})`,
          data: monthlyEarnings,
          backgroundColor: 'rgba(0, 123, 255, 0.5)',
          borderColor: 'rgba(0, 123, 255, 1)',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>

</html>