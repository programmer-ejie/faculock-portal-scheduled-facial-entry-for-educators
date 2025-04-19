<?php
session_start();
include('../db_connection/conn.php');

// Fetch data for graphs
// Logs count by month
$logsData = [];
$logsQuery = mysqli_query($conn, "SELECT MONTH(notif_date) AS month, COUNT(*) AS count FROM logs GROUP BY MONTH(notif_date)");
while ($row = mysqli_fetch_assoc($logsQuery)) {
    $logsData[(int)$row['month']] = (int)$row['count'];
}

// Notifications count by month
$notificationsData = [];
$notificationsQuery = mysqli_query($conn, "SELECT MONTH(notif_date) AS month, COUNT(*) AS count FROM notifications GROUP BY MONTH(notif_date)");
while ($row = mysqli_fetch_assoc($notificationsQuery)) {
    $notificationsData[(int)$row['month']] = (int)$row['count'];
}

// User registrations by month
$usersData = [];
$usersQuery = mysqli_query($conn, "SELECT MONTH(date_created) AS month, COUNT(*) AS count FROM users GROUP BY MONTH(date_created)");
while ($row = mysqli_fetch_assoc($usersQuery)) {
    $usersData[(int)$row['month']] = (int)$row['count'];
}

// Schedules distribution
$schedulesData = [];
$schedulesQuery = mysqli_query($conn, "SELECT subject_name, COUNT(*) AS count FROM schedules GROUP BY subject_name");
while ($row = mysqli_fetch_assoc($schedulesQuery)) {
    $schedulesData[$row['subject_name']] = (int)$row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard | FacuLock</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <link rel="shortcut icon" type="image/png" href="../template/auth/assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/feather.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/material.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/css/style.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/css/style-preset.css">
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="dashboard.php" class="logo d-flex align-items-center me-auto" style="text-decoration: none;">
          <i class="fas fa-lock me-2" style="font-size: 15px;"></i>
          <span class="sitename" style="font-weight: bolder; font-size: 16px; color: grey; padding-right: 10px;">FacuLock</span>
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="livecamera.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-camera"></i></span>
              <span class="pc-mtext">Live Camera</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="dashboard.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>
          <li class="pc-item pc-caption">
            <label>System Functions</label>
            <i class="ti ti-settings"></i>
          </li>
          <li class="pc-item">
            <a href="accounts.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Accounts</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="schedules.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar"></i></span>
              <span class="pc-mtext">Schedules</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="notification.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-bell"></i></span>
              <span class="pc-mtext">User Notifications</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="logs.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-file"></i></span>
              <span class="pc-mtext">Logs</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button">
              <img src="../images/admin.webp" alt="user-image" class="user-avtar">
              <span>Administrator</span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <a href="../index.php" class="dropdown-item">
                <i class="ti ti-power"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <!-- [ Header Topbar ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Admin</a></li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Overview Cards -->
      <div class="row">
        <!-- Total Users -->
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Users</h6>
              <?php
              $totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
              ?>
              <h4 class="mb-3"><?php echo $totalUsers; ?></h4>
            </div>
          </div>
        </div>

        <!-- Total Notifications -->
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Notifications</h6>
              <?php
              $totalNotifications = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notifications"))['total'];
              ?>
              <h4 class="mb-3"><?php echo $totalNotifications; ?></h4>
            </div>
          </div>
        </div>

        <!-- Total Schedules -->
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Schedules</h6>
              <?php
              $totalSchedules = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM schedules"))['total'];
              ?>
              <h4 class="mb-3"><?php echo $totalSchedules; ?></h4>
            </div>
          </div>
        </div>

        <!-- Total Logs -->
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Logs</h6>
              <?php
              $totalLogs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM logs"))['total'];
              ?>
              <h4 class="mb-3"><?php echo $totalLogs; ?></h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Graph Section -->
      <div class="row">
        <!-- Activity Overview Chart -->
        <div class="col-md-6">
          <h5 class="mb-3">Activity Overview</h5>
          <div class="card">
            <div class="card-body">
              <div id="activity-overview-chart"></div>
            </div>
          </div>
        </div>

        <!-- User Registrations Chart -->
        <div class="col-md-6">
          <h5 class="mb-3">User Registrations</h5>
          <div class="card">
            <div class="card-body">
              <div id="user-registrations-chart"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Notifications Overview Chart -->
        <div class="col-md-6">
          <h5 class="mb-3">Notifications Overview</h5>
          <div class="card">
            <div class="card-body">
              <div id="notifications-overview-chart"></div>
            </div>
          </div>
        </div>

        <!-- Schedules Overview Chart -->
    
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">Capstone Project &#9829; By IT301 6 Students</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="../template/admin/dist/assets/js/plugins/apexcharts.min.js"></script>
  <script>
    // Convert PHP arrays to JavaScript
    const logsData = <?php echo json_encode(array_values($logsData)); ?>;
    const notificationsData = <?php echo json_encode(array_values($notificationsData)); ?>;
    const usersData = <?php echo json_encode(array_values($usersData)); ?>;
    const schedulesLabels = <?php echo json_encode(array_keys($schedulesData)); ?>;
    const schedulesData = <?php echo json_encode(array_values($schedulesData)); ?>;

    // Activity Overview Chart
    var activityOptions = {
      series: [{
        name: 'Logs',
        data: logsData
      }, {
        name: 'Notifications',
        data: notificationsData
      }],
      chart: {
        type: 'line',
        height: 350
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      }
    };
    var activityChart = new ApexCharts(document.querySelector("#activity-overview-chart"), activityOptions);
    activityChart.render();

    // User Registrations Chart
    var userOptions = {
      series: [{
        name: 'Users',
        data: usersData
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      }
    };
    var userChart = new ApexCharts(document.querySelector("#user-registrations-chart"), userOptions);
    userChart.render();

    // Notifications Overview Chart
    var notificationsOptions = {
      series: [{
        name: 'Notifications',
        data: notificationsData
      }],
      chart: {
        type: 'area',
        height: 350
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      }
    };
    var notificationsChart = new ApexCharts(document.querySelector("#notifications-overview-chart"), notificationsOptions);
    notificationsChart.render();

    // Schedules Overview Chart
    var schedulesOptions = {
      series: [{
        name: 'Schedules',
        data: schedulesData
      }],
      chart: {
        type: 'pie',
        height: 350
      },
      labels: schedulesLabels
    };
    var schedulesChart = new ApexCharts(document.querySelector("#schedules-overview-chart"), schedulesOptions);
    schedulesChart.render();
  </script>
</body>

</html>