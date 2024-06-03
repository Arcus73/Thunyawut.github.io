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
      <span class="navbar-text">
        ยินดีต้อนรับ,
        <br>
        <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
      </span>
    </div>

    <a href="logout.php" class="btn btn-danger ">Logout</a>
  </nav>

  <script>
  function uploadImage(resever_id) {
    // ส่งค่า resever_id ไปยังหน้า confirm_reserve.php โดยใช้ URL parameter
    window.location.href = "confirm_reserve.php?resever_id=" + resever_id;
  }
  </script>

  <!--กรอกข้อมูลการจอง-->
  <div class="container">

    <h3 class="mt-4">จองสนามฟุตบอล</h3>

    <hr>
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



    <form action="db_stadium3.php" method="POST">
      <div id="booking-alert" style="display: none;">
        <p>สนามนี้มีผู้จองในช่วงเวลานี้แล้ว กรุณาเลือกสนามหรือเวลาอื่น</p>
      </div>
      <div class="mb-3">
        <script>
        $(document).ready(function() {
          $("form button").attr("disabled", true);
          $("input[name='date_reserve'], input[name='start_time'], input[name='end_time'], select[name='field_number']")
            .change(function() {
              var date_reserve = $("input[name='date_reserve']").val();
              var start_time = $("input[name='start_time']").val();
              var end_time = $("input[name='end_time']").val();
              var field_number = $("select[name='field_number']").val();

              $.ajax({
                type: "POST",
                url: "check_availability.php",
                data: {
                  date_reserve: date_reserve,
                  start_time: start_time,
                  end_time: end_time,
                  field_number: field_number,
                  check_availability: 1
                },
                dataType: "json",
                success: function(response) {
                  if (response.error) {
                    $("form button").attr("disabled", true);
                    alert(response.error);
                  } else if (response.success) {
                    $("form button").attr("disabled", false);
                    alert(response.success);
                  }
                },
                error: function() {
                  alert("เกิดข้อผิดพลาดในการตรวจสอบสถานะของสนาม");
                }
              });
            });
        });
        </script>

        <label for="firstname" class="form-label">ชื่อ</label>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" readonly />
      </div>
      <div class="mb-3">
        <label for="lastname" class="form-label">นามสกุล</label>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" readonly />
      </div>
      <div class="mb-3">
        <label for="tel" class="form-label">เบอร์โทร</label>
        <input type="tel" class="form-control" name="tel">
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">วันที่</label>
        <input type="date" class="form-control" name="date_reserve">
      </div>
      <div class="mb-3">
        <label for="start_time" class="form-label">เวลาเริ่ม</label>
        <input type="time" class="form-control" name="start_time">
        <br>
        <label for="end_time" class="form-label">เวลาเริ่มเลิก</label>
        <input type="time" class="form-control" name="end_time">

        <br>

        <p>กรุณาเลือกสนาม</p>
        <select name="field_number">
          <option value="1">สนามที่ 1</option>
          <option value="2">สนามที่ 2</option>
          <option value="3">สนามที่ 3</option>
        </select>
      </div>
      <div>

        <button type="submit" name="submit-reserve" class="btn btn-primary">จองสนามฟุตบอล</button>

    </form>

    <hr>
  </div>




</body>

</html>