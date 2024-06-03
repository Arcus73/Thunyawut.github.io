<?php 
session_start();
require_once 'config/db.php';

// Check if user is not logged in
require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }

// Get user information
$select_stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$select_stmt->bindParam(':user_id', $_SESSION['user_login']);
$select_stmt->execute();
$user = $select_stmt->fetch(PDO::FETCH_ASSOC);


// Function to get daily reservation data by day and time range
function getDailyReservationData($day, $start_time, $end_time, $month ,$field_number) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM football_field WHERE DAYOFWEEK(date_reserve) = :day 
        AND start_time >= :start_time AND end_time <= :end_time AND MONTH(date_reserve) = :month AND field_number = :field_number");
    $stmt->bindParam(":day", $day);
    $stmt->bindParam(":start_time", $start_time);
    $stmt->bindParam(":end_time", $end_time);
    $stmt->bindParam(":month", $month);
    $stmt->bindParam(":field_number", $field_number);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Array to store daily reservation data
$dailyData = array();

// Define time ranges
$timeRanges = array(
    '09-12' => array('09:00', '12:00'),
    '12-15' => array('12:00', '15:00'),
    '15-18' => array('15:00', '18:00'),
    '18-21' => array('18:00', '21:00'),
    '22-24' => array('22:00', '24:00')
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="report.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-ny9vMlWHTdWJLQ8Et5kN8/X4ANc33EX7M0v8s9GyT0A=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
  <!-- Navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light "
    style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="admin_test.php">ข้อมูลการจอง</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page"
              href="manage_data_users.php">จัดการข้อมูลสมาชิก</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="report_admin.php">สรุปรายงาน</a>
          </li>
        </ul>
      </div>
    </div>

    <a href="logout.php" class="btn btn-danger ">Logout</a>
  </nav>
  <!-- Your navigation bar code here -->

  <div class="box-form">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="month">Select Month:</label>
      <select name="month" id="month">
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
      <input type="submit" name="submit" value="Show Report">
    </form>

    <div class="box-table">
      <h1>Daily Reservation Report</h1>
      <h2>สนามที่ 1 </h2>
      <table class="table-report" border="1">
        <tr>
          <th>day / time of day </th>
          <th>9-12</th>
          <th>12-15</th>
          <th>15-18</th>
          <th>18-21</th>
          <th>21-24</th>
        </tr>
        <?php 
        
        $selectedMonth = 1;
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $selectedMonth = $_POST['month'];
        }
          // Loop through days of the week and time ranges to get reservation data
          for ($day = 1; $day <= 7; $day++) {
              foreach ($timeRanges as $key => $range) {
                  $count = getDailyReservationData($day, $range[0], $range[1], $selectedMonth , 1);
                  $dailyData[$day][$key] = $count;
              }
          }
        
        foreach ($dailyData as $day => $timeData) { ?>
        <tr>
          <td><?php echo date('l', strtotime("Sunday +{$day} days")); ?></td>
          <?php foreach ($timeData as $timeRange => $count) { ?>
          <td><?php echo $count; ?></td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>

      <br>

      <h2>สนามที่ 2</h2>
      <table class="table-report" border="1">
        <tr>
          <th>day / time of day </th>
          <th>9-12</th>
          <th>12-15</th>
          <th>15-18</th>
          <th>18-21</th>
          <th>21-24</th>
        </tr>
        <?php 

        for ($day = 1; $day <= 7; $day++) {
            foreach ($timeRanges as $key => $range) {
                $count = getDailyReservationData($day, $range[0], $range[1], $selectedMonth , 2);
                $dailyData[$day][$key] = $count;
            }
        }
          foreach ($dailyData as $day => $timeData) { ?>
        <tr>
          <td><?php echo date('l', strtotime("Sunday +{$day} days")); ?></td>
          <?php foreach ($timeData as $timeRange => $count) { ?>
          <td><?php echo $count; ?></td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
      <br>

      <h2>สนามที่ 3 </h2>
      <table class="table-report" border="1">
        <tr>
          <th>day / time of day </th>
          <th>9-12</th>
          <th>12-15</th>
          <th>15-18</th>
          <th>18-21</th>
          <th>21-24</th>
        </tr>
        <?php 

          for ($day = 1; $day <= 7; $day++) {
          foreach ($timeRanges as $key => $range) {
              $count = getDailyReservationData($day, $range[0], $range[1], $selectedMonth , 3);
              $dailyData[$day][$key] = $count;
          }
      }
        
        foreach ($dailyData as $day => $timeData) { ?>
        <tr>
          <td><?php echo date('l', strtotime("Sunday +{$day} days")); ?></td>
          <?php foreach ($timeData as $timeRange => $count) { ?>
          <td><?php echo $count; ?></td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</body>

</html>