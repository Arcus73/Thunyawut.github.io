<?php
require_once 'config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $resever_id = $_POST['resever_id']; // เพิ่มบรรทัดนี้เพื่อกำหนดค่าให้กับตัวแปร $resever_id
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['tel'];
    $date_reserve = $_POST['date_reserve'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $field_number = $_POST['field_number'];
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM football_field WHERE field_number = :field_number AND date_reserve = :date_reserve AND ((start_time <= :start_time AND end_time >= :start_time) OR (start_time <= :end_time AND end_time >= :end_time) OR (:start_time <= start_time AND :end_time >= start_time) OR (:start_time <= end_time AND :end_time >= end_time))");
    $stmt->bindParam(":field_number", $field_number);
    $stmt->bindParam(":date_reserve", $date_reserve);
    $stmt->bindParam(":start_time", $start_time);
    $stmt->bindParam(":end_time", $end_time);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $_SESSION['error'] = "สนามนี้ได้ถูกจองไปแล้ว กรุณาเลือกเวลาหรือสนามอื่น";
        header("location:admin_test.php");
        exit();
    }

    $update_stmt = $conn->prepare('UPDATE football_field SET firstname = ?, lastname = ?, tel = ?, date_reserve = ?, start_time = ?, end_time = ?, field_number = ? WHERE resever_id = ?');
    $update_stmt->execute([$firstname, $lastname, $tel, $date_reserve, $start_time, $end_time, $field_number, $resever_id]);

    $_SESSION['success'] = 'อัปเดตข้อมูลการจองเรียบร้อยแล้ว';
    header('location: admin_test.php');
} else {
    header('location: admin_test.php');
    exit();
}
?>