<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit();
}

if (isset($_POST['submit'])) {
    $image = $_FILES['image'];

    // เช็คว่ามีการอัพโหลดไฟล์รูปภาพหรือไม่
    if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบประเภทของไฟล์
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($image['type'], $allowed_types)) {
            $_SESSION['error'] = 'กรุณาเลือกไฟล์รูปภาพให้ถูกต้อง (JPG, JPEG, PNG)';
            header('location: user.php');
            exit();
        }

        // สร้างชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
        $filename = uniqid('image_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

        // อัพโหลดไฟล์รูปภาพ
        $upload_path = $upload_dir . $filename;
        if (move_uploaded_file($image['tmp_name'], $upload_path)) {
            // บันทึกข้อมูลลงฐานข้อมูล
            $insert_stmt = $conn->prepare("INSERT INTO images (user_id, filename) VALUES (:user_id, :filename)");
            $insert_stmt->bindParam(':user_id', $_SESSION['user_login']);
            $insert_stmt->bindParam(':filename', $filename);

            if ($insert_stmt->execute()) {
                $_SESSION['success'] = 'อัพโหลดรูปภาพสำเร็จแล้ว!';
                header('location: user.php');
                exit();
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล';
                header('location: user.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'ไม่สามารถอัพโหลดรูปภาพได้';
            header('location: user.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'กรุณาเลือกไฟล์รูปภาพ';
        header('location: user.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'คำร้องขอไม่ถูกต้อง';
    header('location: user.php');
    exit();
}