<?php
require_once 'config/db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <title>ระบบจองสนามฟุตบอล</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">
        
    </nav>
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
    <div class="container">
        <h3>ตรวจสอบสลิปโอนเงิน</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เวลาเริ่มเล่น</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                    <th>ตรวจสอบ</th>
                    <th>ชื่อ-นามสกุลผู้อัปโหลด</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new PDO("mysql:host=localhost;dbname=register_db", "root", "");
                $stmt = $conn->prepare("SELECT imagesdb.*, users.id AS user_id, users.firstname, users.lastname FROM imagesdb LEFT JOIN users ON imagesdb.id = users.id ORDER BY date DESC, time DESC");
                $stmt->execute();                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['time']}</td>";
                    echo "<td><a href='uploads/{$row['image']}' target='_blank'><img src='uploads/{$row['image']}' width='100' height='200'></a></td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>";
                    if ($row['status'] === 'รอตรวจสอบ') {
                        // เรียกใช้ confirmCheckComplete() เมื่อกดปุ่ม "ตรวจสอบเรียบร้อยแล้ว"
                        echo "<button onclick=\"confirmCheckComplete('{$row['image_id']}')\" class='btn btn-primary'>ตรวจสอบเรียบร้อยแล้ว</button>";
                    } else {
                        echo "ตรวจสอบเรียบร้อยแล้ว";
                    }
                    echo "</td>";
                    echo "<td>{$row['firstname']} {$row['lastname']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- ส่วนนี้คือ SweetAlert สำหรับแสดง alert -->
    <script>
        function confirmCheckComplete(image_id) {
            Swal.fire({
                title: 'คุณต้องการเปลี่ยนสถานะเป็น "ตรวจสอบเรียบร้อยแล้ว" ใช่หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `confirm_images.php?image_id=${image_id}`;
                }
            });
        }
    </script>
</body>
</html>
</body>
</html>
