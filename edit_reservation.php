<?php
require_once 'config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่า ID ที่ต้องการแก้ไขจากฟอร์ม
    $resever_id = $_POST['resever_id'];

    // ดึงข้อมูลการจองจากฐานข้อมูล
    $stmt = $conn->prepare('SELECT * FROM football_field WHERE resever_id = :resever_id');
    $stmt->bindParam(':resever_id', $resever_id);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีการจองที่ต้องการหรือไม่
    if (!$reservation) {
        $_SESSION['error'] = 'ไม่พบการจองที่ต้องการแก้ไข';
        header('Location: admin_test.php');
        exit;
    }

    // ส่งข้อมูลการจองไปยังหน้าแก้ไข
    $_SESSION['reservation'] = $reservation;
    header('Location: edit_reservation_form.php');
    exit;
}

// ถ้ามีการกลับมายังหน้านี้โดยไม่ผ่านการส่งค่าจากฟอร์ม
$_SESSION['error'] = 'ไม่พบการจองที่ต้องการแก้ไข';
header('Location: admin_test.php');