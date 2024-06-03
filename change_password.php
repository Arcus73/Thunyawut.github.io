<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // ตรวจสอบรหัสผ่านเก่า
    $select_password_stmt = $conn->prepare("SELECT password FROM users WHERE id = :user_id");
    $select_password_stmt->bindParam(':user_id', $_SESSION['user_login']);
    $select_password_stmt->execute();
    $user_password = $select_password_stmt->fetchColumn();

    if (password_verify($old_password, $user_password)) {
        // ตรวจสอบว่ารหัสผ่านใหม่ตรงกันกับยืนยันรหัสผ่านใหม่หรือไม่
        if ($new_password === $confirm_password) {
            // ดำเนินการอัปเดตรหัสผ่านใหม่
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $update_password_stmt->bindParam(':password', $hashed_password);
            $update_password_stmt->bindParam(':user_id', $_SESSION['user_login']);

            if ($update_password_stmt->execute()) {
                $_SESSION['success'] = 'บันทึกรหัสผ่านใหม่เรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกรหัสผ่านใหม่';
            }
        } else {
            $_SESSION['error'] = 'รหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ไม่ตรงกัน';
        }
    } else {
        $_SESSION['error'] = 'รหัสผ่านเก่าไม่ถูกต้อง';
    }

    // หลังจากอัปเดตรหัสผ่านหรือเกิดข้อผิดพลาดในการตรวจสอบข้อมูล ให้กลับไปยังหน้า "user_info.php" หรือหน้าอื่น ๆ ตามที่คุณต้องการ
    header('location: user_info.php');
    exit;
}

$select_stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$select_stmt->bindParam(':user_id', $_SESSION['user_login']);
$select_stmt->execute();
$user = $select_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">


</head>

<body>
  <nav class="navbar navbar-expand-lg" style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">
    <div class="container-fluid">
      <a class="navbar-brand" href="user.php">หน้าแรก</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="my_data_reserve.php">ข้อมูลการจองของฉัน</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="data_reserve_user.php">ข้อมูลการจองทั้งหมด</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="user_info.php">แก้ไขข้อมูลส่วนตัว</a>
          </li>
        </ul>

      </div>
    </div>

    <span class="navbar-text">
      ยินดีต้อนรับ, <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
    </span>

    <a href="logout.php" class="btn btn-danger">Logout</a>
  </nav>
  <div class="container">
    <br>
    <?php if(isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION['success'])) { ?>
    <div class="alert alert-success" role="alert">
      <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION['warning'])) { ?>
    <div class="alert alert-warning" role="alert">
      <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
    </div>
    <?php } ?>
    <br>
    <form method="POST">
      <!-- ฟอร์มรหัสผ่านเก่า -->
      <div class="mb-3">
        <label for="old_password" class="form-label">รหัสผ่านเก่า</label>
        <input type="password" name="old_password" />
      </div>

      <!-- ฟอร์มรหัสผ่านใหม่ -->
      <div class="mb-3">
        <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
        <input type="password" name="new_password" />
      </div>

      <!-- ฟอร์มยืนยันรหัสผ่านใหม่ -->
      <div class="mb-3">
        <label for="confirm_password" class="form-label">ยืนยันรหัสผ่านใหม่</label>
        <input type="password" name="confirm_password" />
      </div>

      <!-- ส่วนอื่น ๆ ในฟอร์ม (ชื่อ, นามสกุล, อีเมล, และอื่น ๆ) -->

      <button type="submit" name="submit-reserve" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
    <br>
  </div>
  </div>
</body>

</html>