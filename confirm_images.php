<?php

require_once 'config/db.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];

    $conn = new PDO("mysql:host=localhost;dbname=register_db", "root", "");
    $stmt = $conn->prepare("UPDATE imagesdb SET status = 'ตรวจสอบเรียบร้อยแล้ว' WHERE image_id = :image_id");
    $stmt->bindParam(':image_id', $image_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'เปลี่ยนสถานะเป็น "ตรวจสอบเรียบร้อยแล้ว" สำเร็จ!';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการเปลี่ยนสถานะ';
    }

    header('location: admin_confirm_reserve.php');
    exit();
    
} else {
    $_SESSION['error'] = 'ไม่พบรหัสรายการจอง';
    header('location: admin_confirm_reserve.php');
    exit();
}