<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-ny9vMlWHTdWJLQ8Et5kN8/X4ANc33EX7M0v8s9GyT0A=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">



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

    <div class="mb-3">
      <label for="id" class="form-label">User_Id</label>
      <input type="text" name="id" value="<?php echo $user['id']; ?>" readonly />
    </div>
    <div class="mb-3">
      <label for="firstname" class="form-label">ชื่อ</label>
      <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" readonly />
    </div>
    <div class="mb-3">
      <label for="lastname" class="form-label">นามสกุล</label>
      <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" readonly />
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">username</label>
      <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" readonly />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">password</label>
      <input type="password" class="form-control" name="password" value="<?php echo $user['password']; ?>" readonly />
    </div>


    <div>

      <div>
        <a href="edit_profile.php" class="btn btn-primary">แก้ไขข้อมูล</a>
        <a href="change_password.php" class="btn btn-primary">เปลี่ยนรหัสผ่าน</a>
      </div>

      </form>

      <hr>
    </div>
</body>

</html>