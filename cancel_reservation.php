<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resever_id = $_POST['resever_id'];

    // ทำการอัปเดตสถานะการจองเป็น "ยกเลิก"
    $cancel_stmt = $conn->prepare('UPDATE football_field SET status = "ยกเลิกการจอง" WHERE resever_id = :resever_id');
    $cancel_stmt->bindParam(':resever_id', $resever_id);
    $cancel_stmt->execute();

    $_SESSION['success'] = 'ยกเลิกรายการจองเรียบร้อยแล้ว';
    header('location: admin_test.php');
    exit();
} else {
    $_SESSION['error'] = 'ไม่สามารถเข้าถึงหน้านี้โดยตรงได้';
    header('location: admin_test.php');
    exit();
}
?>