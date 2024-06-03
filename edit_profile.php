<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = !empty($_POST['firstname']) ? $_POST['firstname'] : $user['firstname'];
    $lastname = !empty($_POST['lastname']) ? $_POST['lastname'] : $user['lastname'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $user['email'];

    // ดำเนินการอัปเดตข้อมูลในฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :user_id");
    $update_stmt->bindParam(':firstname', $firstname);
    $update_stmt->bindParam(':lastname', $lastname);
    $update_stmt->bindParam(':email', $email);
    $update_stmt->bindParam(':user_id', $_SESSION['user_login']);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = 'บันทึกการแก้ไขเรียบร้อยแล้ว';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกการแก้ไข';
    }

    // หลังจากอัปเดตข้อมูล หรือเกิดข้อผิดพลาดในการตรวจสอบข้อมูล ให้กลับไปยังหน้า "user_info.php" หรือหน้าอื่น ๆ ตามที่คุณต้องการ
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
      <div class="mb-3">
        <label for="firstname" class="form-label">ชื่อ</label>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" />
      </div>
      <div class="mb-3">
        <label for="lastname" class="form-label">นามสกุล</label>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" />
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">username</label>
        <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" />
      </div>
      <button type="submit" name="submit-reserve" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
    <br>
  </div>
  </div>
</body>

</html>