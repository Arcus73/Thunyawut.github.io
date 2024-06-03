<?php
session_start();
$reservation = $_SESSION['reservation'];
unset($_SESSION['reservation']);

require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแก้ไขข้อมูลการจองสนามฟุตบอล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>  
        <nav class="navbar navbar-expand-lg" style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; " >
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_test.php">ข้อมูลการจอง</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="manage_data_users.php">จัดการข้อมูลสมาชิก</a>
        </li>
        
      </ul>
      
    </div>
  </div>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</nav>    


<div class="container">
    <br>
    <h3>แก้ไขข้อมูลการจอง</h3>
    <form action="update_reservation.php" method="POST">
        <div class="mb-3">
            <label for="firstname" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $reservation['firstname'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $reservation['lastname'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">เบอร์</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="<?= $reservation['tel'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">วันที่</label>
            <input type="date" class="form-control" id="date_reserve" name="date_reserve" value="<?= $reservation['date_reserve'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">เวลาเริ่ม</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="<?= $reservation['start_time'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">เวลาเลิก</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="<?= $reservation['end_time'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="field_number" class="form-label">สนามที่</label>
            <input type="text" class="form-control" id="field_number" name="field_number" value="<?= $reservation['field_number'] ?>" required>
        </div>
        <input type="hidden" name="resever_id" value="<?= $reservation['resever_id'] ?>">
        <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">Update</button>

        <br>
        <br>
    </form>
        <script>
        function confirmSubmit() {
            return confirm('คุณต้องการที่จะแก้ไขข้อมูลการจองนี้ใช่หรือไม่?');
        }
        </script>
</div>
</body>
</html>