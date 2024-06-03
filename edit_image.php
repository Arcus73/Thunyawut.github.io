<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

if (isset($_GET['resever_id'])) {
    // รับค่า resever_id จาก URL
    $resever_id = $_GET['resever_id'];
} else {
    // ถ้าไม่มีค่า resever_id ใน URL ให้กลับไปที่หน้า my_data_reserve.php หรือทำอย่างอื่นตามที่ต้องการ
    header('location: my_data_reserve.php');
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$conn = new PDO("mysql:host=localhost;dbname=register_db", "root", "");

// คำสั่ง SQL ในการดึงข้อมูลรูปภาพจากตาราง imagesdb โดยใช้ resever_id เพื่อแก้ไข
$stmt = $conn->prepare("SELECT * FROM imagesdb WHERE resever_id = :resever_id");
$stmt->bindParam(':resever_id', $resever_id);
$stmt->execute();
$image = $stmt->fetch();

if (!$image) {
    // ถ้าไม่พบข้อมูลรูปภาพ ให้กลับไปที่หน้า my_data_reserve.php หรือทำอย่างอื่นตามที่ต้องการ
    $_SESSION['error'] = 'ไม่พบรูปภาพที่ต้องการแก้ไข';
    header('location: my_data_reserve.php');
    exit();
}

// ตรวจสอบว่ามีการส่งฟอร์มเข้ามาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resever_id'])) {
    // รับค่า resever_id จากฟอร์ม
    $resever_id = $_POST['resever_id'];

    // รับค่าชื่อไฟล์รูปภาพใหม่
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $extensions = array("jpeg", "jpg", "png");

    // ตรวจสอบส่วนขยายของไฟล์ว่าอยู่ในส่วนขยายที่อนุญาตหรือไม่
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($file_ext, $extensions)) {
        $_SESSION['error'] = "ส่วนขยายไฟล์ที่อนุญาตคือ jpeg, jpg, และ png เท่านั้น";
        header("Location: edit_image.php?resever_id={$resever_id}");
        exit();
    }

    // ตรวจสอบขนาดของไฟล์
    if ($file_size > 2097152) {
        $_SESSION['error'] = 'ขนาดไฟล์ควรไม่เกิน 2MB';
        header("Location: edit_image.php?resever_id={$resever_id}");
        exit();
    }

    // สร้างชื่อไฟล์ใหม่
    $new_file_name = time() . '_' . $file_name;

    // อัพโหลดไฟล์ภาพไปยังโฟลเดอร์ที่กำหนด
    if (move_uploaded_file($file_tmp, "uploads/" . $new_file_name)) {
        // อัปเดตชื่อไฟล์รูปภาพในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE imagesdb SET image = :image, status = 'อัปโหลดสลิปแล้ว' WHERE resever_id = :resever_id ");
        $stmt->bindParam(':image', $new_file_name);
        $stmt->bindParam(':resever_id', $resever_id);


        if ($stmt->execute()) {
            $_SESSION['success'] = 'อัปโหลดรูปภาพใหม่เรียบร้อยแล้ว!';
            header("Location: my_data_reserve.php");
            exit();
        } else {
            $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปเดตรูปภาพ';
            header("Location: edit_image.php?resever_id={$resever_id}");
            exit();
        }
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ';
        header("Location: edit_image.php?resever_id={$resever_id}");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Image</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>


<body>
  <div class="container">

    <img width="600px" height="750px" src="img/qrcode.jpg" alt="">
    <h1>Edit Image</h1>
    <?php if(isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
    </div>
    <?php } ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?resever_id=' . $resever_id; ?>" method="POST"
      enctype="multipart/form-data">
      <div class="form-group">
        <label for="image_id">อัปโหลดรูปภาพใหม่:</label>
        <input type="file" name="image" id="image_id" required>
        <!-- เพิ่ม input hidden เพื่อส่ง resever_id ไปยังการอัปโหลดรูปภาพใหม่ -->
        <input type="hidden" name="resever_id" value="<?php echo $resever_id; ?>">
      </div>
      <button type="submit" class="btn btn-primary">บันทึก</button>
      <a href="my_data_reserve.php" class="btn btn-secondary">ย้อนกลับ</a>
    </form>

  </div>
</body>

</html>