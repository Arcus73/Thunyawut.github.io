<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_availability'])) {
    $date_reserve = $_POST['date_reserve'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $field_number = $_POST['field_number'];

    $check_stmt = $conn->prepare("SELECT COUNT(*) as count, status FROM football_field WHERE field_number = :field_number AND date_reserve = :date_reserve AND ((start_time <= :start_time AND end_time >= :start_time) OR (start_time <= :end_time AND end_time >= :end_time) OR (:start_time <= start_time AND :end_time >= start_time) OR (:start_time <= end_time AND :end_time >= end_time))");
    $check_stmt->bindParam(":field_number", $field_number);
    $check_stmt->bindParam(':date_reserve', $date_reserve);
    $check_stmt->bindParam(':start_time', $start_time);
    $check_stmt->bindParam(':end_time', $end_time);
    $check_stmt->execute();

    $response = array();
    $row = $check_stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        if ($row['status'] == 'อัปโหลดสลิปแล้ว') {
            $response['error'] = 'สนามนี้มีผู้ใช้งานจองแล้ว กรุณาเลือกวันและเวลาหรือสนามอื่น';
        } elseif ($row['status'] == 'รออัปโหลดสลิป') {
            $response['success'] = 'สนามนี้อยู่ในระหว่างรออัพโหลดสลิป ไม่สามารถจองได้ในขณะนี้';
        }
    } else {
        $response['success'] = 'คุณสามารถจองวัน หรือ เวลา หรือ สนามนี้ได้';
    }

    echo json_encode($response);
    exit();
} else {
    echo 'Invalid Request';
    exit();
}
?>