<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

if (isset($_GET['resever_id'])) {
    // รับค่า reserve_id จาก URL
    $resever_id = $_GET['resever_id'];
} else {
    // ถ้าไม่มีค่า reserve_id ใน URL ให้กลับไปที่หน้า my_data_reserve.php หรือทำอย่างอื่นตามที่ต้องการ
    
    exit();
}

// ...

// ตรวจสอบว่ามีการส่งฟอร์มเข้ามาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าวันที่และเวลา
    $date = $_POST['date'];
    $time = $_POST['time'];

    // ตรวจสอบว่ามีการอัพโหลดไฟล์ภาพหรือไม่
    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $extensions = array("jpeg", "jpg", "png");

        // ตรวจสอบส่วนขยายของไฟล์ว่าอยู่ในส่วนขยายที่อนุญาตหรือไม่
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $extensions)) {
            $_SESSION['error'] = "ส่วนขยายไฟล์ที่อนุญาตคือ jpeg, jpg, และ png เท่านั้น";
            header("Location: confirm_reserve.php");
            exit();
        }

        // ตรวจสอบขนาดของไฟล์
        if ($file_size > 2097152) {
            $_SESSION['error'] = 'ขนาดไฟล์ควรไม่เกิน 2MB';
            header("Location: confirm_reserve.php?resever_id={$resever_id}");
            exit();
        }

        // สร้างชื่อไฟล์ใหม่
        $new_file_name = time() . '_' . $file_name;

        // อัพโหลดไฟล์ภาพไปยังโฟลเดอร์ที่กำหนด
        if (move_uploaded_file($file_tmp, "uploads/" . $new_file_name)) {
            // เชื่อมต่อกับฐานข้อมูลและบันทึกข้อมูลลงฐานข้อมูล
            $conn = new PDO("mysql:host=localhost;dbname=register_db", "root", "");

            // คำสั่ง SQL ในการเพิ่มข้อมูลรูปภาพลงในตาราง imagesdb
            $status = "อัปโหลดสลิปแล้ว"; // สถานะเริ่มต้นเป็น "รอตรวจสอบ"           
            $id = $_SESSION['user_login']; // กำหนดค่า id จากตัวแปร session หรือข้อมูลของผู้ใช้ที่เกี่ยวข้องกับการอัพโหลดรูปภาพ
            $stmt = $conn->prepare("INSERT INTO imagesdb (image, status, id, resever_id) VALUES (:image, :status, :id, :resever_id)");
            $stmt->bindParam(':image', $new_file_name);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':resever_id', $resever_id);

            if ($stmt->execute()) {
                // หากบันทึกข้อมูลรูปภาพลงฐานข้อมูลสำเร็จ ให้ดึงค่า image_id ที่เพิ่มล่าสุดเพื่อนแนบไปในตาราง football_field
                $image_id = $conn->lastInsertId();
        
                // คำสั่ง SQL ในการอัปเดต image_id และ status ในตาราง football_field                
                $stmt = $conn->prepare("UPDATE football_field SET image_id = :image_id, status = :status WHERE resever_id = :resever_id");
                $stmt->bindParam(':image_id', $image_id);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':resever_id', $resever_id);
        
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'อัพโหลดรูปภาพและอัปเดตสถานะเรียบร้อย!';
                    header("Location: my_data_reserve.php");
                    exit();
                } else {
                    $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปเดต';
                    header("Location: confirm_reserve.php?resever_id={$resever_id}");
                    exit();
                }
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพลงฐานข้อมูล';
                header("Location: confirm_reserve.php?resever_id={$resever_id}");
                exit();
            }
        } else {
            $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ';
            header("Location: confirm_reserve.php?resever_id={$resever_id}");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        .center {
            margin: auto;
            width: 35%;
            padding: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
        } 
        div#front { text-align: center }
        h3 { text-align: center }
        
    </style>
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
</head>
<body>  
    
                
    <div class="center">
        <img src="img/qrcode.jpg" width="500" height="600">
    </div>
    <div class="front">
    <h3>สแกนจ่ายตาม Qr code ด้านบนนี้ได้เลยค่ะ!!</h3>
    <h3>ค่าสนามต่อชั่วโมงอยู่ที่ 800 บาทนะคะ</h3>
    </div>

    <div class="center">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?resever_id=' . $resever_id; ?>" method="POST" enctype="multipart/form-data">
        <!-- เพิ่ม input hidden เพื่อเก็บค่า reserve_id -->
        <input type="hidden" name="resever_id" value="<?php echo $resever_id; ?>">
        <div class="form-group">
            <label for="image">อัพโหลดรูปภาพ:</label>
            <input type="file" name="image" id="image" required>
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
        <a href="my_data_reserve.php" class="btn btn-secondary">ย้อนกลับ</a>
    </form>
</div>

</body>
</html>
