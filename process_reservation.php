<?php

require_once 'config/db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['tel'];
    $date_reserve = $_POST['date_reserve'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $field_number = $_POST['field_number'];
    $status = "รอยืนยันการจอง"; // กำหนดค่าสถานะ "รอดำเนินการ" เมื่อมีการเพิ่มการจองในฐานข้อมูล

    // Check if the field is available on that date and time
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM football_field WHERE field_number = :field_number AND date_reserve = :date_reserve AND ((start_time <= :start_time AND end_time >= :start_time) OR (start_time <= :end_time AND end_time >= :end_time) OR (:start_time <= start_time AND :end_time >= start_time) OR (:start_time <= end_time AND :end_time >= end_time))");
    $stmt->bindParam(":field_number", $field_number);
    $stmt->bindParam(':date_reserve', $date_reserve);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        $_SESSION['error'] = 'มีการจองในวันและเวลาดังกล่าวแล้ว';
        header('location: admin_test.php');
        exit();
    }

    // Prepare SQL statement for inserting the reservation into the database
    $insert_stmt = $conn->prepare('INSERT INTO football_field (firstname, lastname, tel, date_reserve, start_time, end_time, field_number, status) VALUES (:firstname, :lastname, :tel, :date_reserve, :start_time, :end_time, :field_number, :status)');
    $insert_stmt->bindParam(':firstname', $firstname);
    $insert_stmt->bindParam(':lastname', $lastname);
    $insert_stmt->bindParam(':tel', $tel);
    $insert_stmt->bindParam(':date_reserve', $date_reserve);
    $insert_stmt->bindParam(':start_time', $start_time);
    $insert_stmt->bindParam(':end_time', $end_time);
    $insert_stmt->bindParam(':field_number', $field_number);
    $insert_stmt->bindParam(':status', $status);

    // Insert the reservation into the database
    if ($insert_stmt->execute()) {
        $_SESSION['success'] = 'บันทึกการจองเรียบร้อยแล้ว';
        header('location: admin_test.php');
        exit();
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลการจอง';
        header('location: admin_test.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'คำขอไม่ถูกต้อง';
    header('location: admin_test.php');
    exit();
}
?>
