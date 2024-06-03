<?php
require_once 'config/db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบการเข้าสู่ระบบก่อนในกรณีที่ต้องการแสดงรายการจองของยูสเซอร์นั้น ๆ
if (isset($_SESSION['user_login'])) {
    // ถ้ามีค่า id ให้เก็บไว้ในตัวแปร $user_id
    $user_id = $_SESSION['user_login'];

    // ทำอย่างอื่นตามต้องการโดยใช้ค่า $user_id ที่ได้รับจาก $_SESSION['user_login']['id']
    // ...
} else {
    // ถ้าไม่มีค่า id ใน $_SESSION ให้ทำอย่างอื่นตามต้องการ
    echo "ไม่พบค่า id ที่เก็บมา";
}

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head>
<script>
function uploadImage(resever_id) {
  // ส่งค่า resever_id ไปยังหน้าที่ให้ผู้ใช้อัพโหลดรูปภาพ
  window.location.href = "confirm_reserve.php?resever_id=" + resever_id;
}

function viewImage(imagePath) {
  // สร้างตัวแปร popup ในหน้าต่างใหม่เพื่อแสดงภาพ
  var popup = window.open("", "_blank", "width=600, height=400");
  // แสดงภาพในตัวแปร popup
  popup.document.write('<img src="' + imagePath + '" style="max-width:100%; max-height:100%;" />');
}
</script>

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
  <?php if(isset($_SESSION['error'])) { ?>
  <div class="alert alert-danger" role="alert">
    <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
  </div>
  <?php } ?>

  <br>
  <br>

  <div class="container">
    <h4>รายการจองของคุณ</h4>
    <?php
        $conn = new PDO("mysql:host=localhost;dbname=register_db", "root", "");
        $stmt = $conn->prepare("SELECT ff.*, img.image AS image, img.status AS image_status
                       FROM football_field AS ff 
                       LEFT JOIN imagesdb AS img 
                       ON ff.resever_id = img.resever_id 
                       WHERE ff.user_id = :user_id ORDER BY ff.resever_id DESC"
                       ); 

        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($stmt->rowCount() > 0) {
        ?>
    <table class="table table-striped">
      <thead>
        <tr>
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
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>วันที่</th>
          <th>เวลาเริ่ม</th>
          <th>เวลาสิ้นสุด</th>
          <th>สนามที่</th>
          <th>สถานะอัปโหลดสลิป</th>
          <th>รูปภาพ</th> <!-- คอลัมน์สำหรับแสดงรูปภาพ -->
          <th>อัปโหลดสลิปใหม่อีกครั้ง</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row): ?>
        <tr>
          <td><?= $row['firstname'] ?></td>
          <td><?= $row['lastname'] ?></td>
          <td><?= date('d/m/Y', strtotime($row['date_reserve'])) ?></td>
          <td><?= $row['start_time'] ?></td>
          <td><?= $row['end_time'] ?></td>
          <td><?= $row['field_number'] ?></td>

          <td>
            <?php if ($row['status'] === 'อัปโหลดสลิปแล้ว' || $row['status'] === 'ยกเลิกการจอง' || $row['status'] === 'ยืนยันการจองแล้ว') : ?>
            <?= $row['status'] ?>
            <?php else : ?>
            <a href="confirm_reserve.php?resever_id=<?= $row['resever_id'] ?>"><?= $row['status'] ?></a>
            <?php endif; ?>
          </td>

          <td>
            <?php if ($row['image_status'] === 'อัปโหลดสลิปแล้ว' || $row['status'] === 'ยกเลิกการจองแล้ว' && $row['image']) : ?>
            <!-- แสดงรูปภาพและเพิ่มลิงก์ไปยังรูปภาพในขนาดใหญ่ -->
            <a href="#" onclick="viewImage('uploads/<?= $row['image'] ?>')">
              <img src="uploads/<?= $row['image'] ?>" alt="รูปภาพที่อัปโหลด"
                style="max-width: 300px; max-height: 300px;">
            </a>
            <?php elseif ($row['image_status'] === 'รออัปโหลดสลิป') : ?>
            <!-- แสดงข้อความ "รออัปโหลดสลิป" แต่ไม่แสดงภาพ -->

            <span>รออัปโหลดสลิป</span>
            <?php else : ?>
            <!-- แสดงข้อความ "ไม่มีรูปภาพ" แต่ไม่แสดงภาพ -->
            <span>ไม่มีรูปภาพ</span>
            <?php endif; ?>



          </td>
          <td>
            <a href="edit_image.php?resever_id=<?= $row['resever_id'] ?>"
              class="btn btn-primary">อัปโหลดสลิปใหม่อีกครั้ง</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php } else {
            echo '<p>คุณยังไม่มีรายการจอง</p>';
        }
        ?>
  </div>
</body>

</html>