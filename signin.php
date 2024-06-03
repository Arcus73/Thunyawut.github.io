<?php session_start(); 


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <h3 class="mt-4">เข้าสู่ระบบ</h3>
    <hr>
    <form action="signin_db.php" method="post">
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
      <div class="mb-3">
        <label for="email" class="form-label">ชื่อบัญชีผู้ใช้งาน</label>
        <input type="text" class="form-control" name="email" aria-describedby="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">รหัสผ่าน</label>
        <input type="password" class="form-control" name="password">
      </div>
      <button type="submit" name="signin" class="btn btn-primary">เข้าสู่ระบบ</button>
    </form>
    <hr>
    <div class="signup_link">
      <p>ยังไม่เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="index.php">สมัครสมาชิก</a></p>
    </div>

</body>

</html>