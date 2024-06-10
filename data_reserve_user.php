<?php
require_once 'config/db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

$records_per_page = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page or set default to 1
$start_from = ($page - 1) * $records_per_page; // Calculate the starting record

// If a search query is present, filter records by the search query
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    $stmt_total = $conn->prepare("SELECT COUNT(*) FROM football_field WHERE date_reserve = ?");
    $stmt_total->execute([$query]);
    $total_records = $stmt_total->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM football_field WHERE date_reserve = ? ORDER BY date_reserve DESC, start_time ASC LIMIT :start_from, :records_per_page");
    $stmt->bindParam(":start_from", $start_from, PDO::PARAM_INT);
    $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
    $stmt->execute([$query]);
} else {
    $stmt_total = $conn->prepare("SELECT COUNT(*) FROM football_field");
    $stmt_total->execute();
    $total_records = $stmt_total->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM football_field ORDER BY date_reserve DESC, start_time ASC LIMIT :start_from, :records_per_page");
    $stmt->bindParam(":start_from", $start_from, PDO::PARAM_INT);
    $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
}

$result = $stmt->fetchAll();
$total_pages = ceil($total_records / $records_per_page); // Calculate total pages
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-ny9vMlWHTdWJLQ8Et5kN8/X4ANc33EX7M0v8s9GyT0A=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>ตารางแสดงข้อมูลการจอง</title>
  <style type="text/css">
  /* สไตล์ตามที่คุณต้องการ */
  </style>
</head>

<body>
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
            <a class="nav-link active text-primary" aria-current="page" href="user.php">หน้าแรก</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page"
              href="my_data_reserve.php">ข้อมูลการจองของฉัน</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page"
              href="data_reserve_user.php">ข้อมูลการจองทั้งหมด</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="user_info.php">แก้ไขข้อมูลส่วนตัว</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="report.php">สรุปรายงาน</a>
          </li>
        </ul>
      </div>
    </div>

    <a href="logout.php" class="btn btn-danger ">Logout</a>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12"> <br>
        <h4>ตารางแสดงข้อมูลการจอง</h4>
        <form action="" method="get">
          <div class="input-group mb-3">
            <input type="date" name="q" class="form-control" data-date-format="dd-mm-Y">
            <button type="submit" class="btn btn-primary">ค้นหา</button>
            <a href="data_reserve_user.php" class="btn btn-warning">เคลียร์</a>
          </div>
        </form>

        <?php
        if ($stmt->rowCount() > 0) {
            ?>
        <table class="table table-striped table-hover table-responsive table-bordered">
          <thead>
            <tr>
              <th>วันที่</th>
              <th>เวลาเริ่ม</th>
              <th>เวลาเลิก</th>
              <th>สนามที่</th>
              <th>สถานะการจอง</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row): ?>
            <tr>
              <td><?= date('d/m/Y', strtotime($row['date_reserve'])) ?></td>
              <td><?= $row['start_time'] ?></td>
              <td><?= $row['end_time'] ?></td>
              <td><?= $row['field_number'] ?></td>
              <td><?= $row['status'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php } else {
            echo '<center> -ไม่พบข้อมูล !! </center>';
        }
        ?>
      </div>
    </div>
  </div>

  <?php if ($total_pages > 1): ?>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
      <?php endfor; ?>
      <?php if ($page < $total_pages): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
      <?php endif; ?>
    </ul>
  </nav>
  <?php endif; ?>
</body>

</html>