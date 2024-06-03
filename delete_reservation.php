<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}

if (isset($_POST['resever_id'])) {
    $resever_id = $_POST['resever_id'];

    // แก้ไขค่า image_id เป็น NULL ในตาราง football_field
    $update_image_id_stmt = $conn->prepare('UPDATE football_field SET image_id = NULL WHERE resever_id = :resever_id');
    $update_image_id_stmt->bindParam(':resever_id', $resever_id);
    $update_image_id_stmt->execute();

    // ลบแถวในตาราง football_field
    $delete_field_stmt = $conn->prepare('DELETE FROM football_field WHERE resever_id = :resever_id');
    $delete_field_stmt->bindParam(':resever_id', $resever_id);
    $delete_field_stmt->execute();

    $_SESSION['success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
    header('location: admin_test.php');
    exit();
}
?>
