<?php
require_once 'config/db.php';
session_start();
require_once 'config/db.php';
date_default_timezone_set("Asia/Bangkok");

if (isset($_POST['submit-reserve'])) {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['tel'];
    $date_reserve = $_POST['date_reserve'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $field_number = $_POST['field_number'];

    if (strtotime($date_reserve) < strtotime('today')) {
        $_SESSION['error'] = "ไม่สามารถจองย้อนหลังได้";
        header("location:user.php");
        exit();
    }

    // เช็คว่า start_time ไม่เป็นเวลาย้อนหลัง
    if (strtotime($start_time) < strtotime('now') && strtotime($date_reserve) == strtotime('today')) {
        $_SESSION['error'] = "ไม่สามารถจองเวลาย้อนหลังได้";
        header("location:user.php");
        exit();
    }
    

    if (empty($firstname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อ';
        header("location: user.php");
        exit();
    } else if (empty($lastname)) {
        $_SESSION['error'] = 'กรุณากรอกนามสกุล';
        header("location: user.php");
        exit();
    } else if (empty($tel)) {
        $_SESSION['error'] = 'กรุณากรอกเบอร์โทร';
        header("location: user.php");                                   
        exit();
    } else if (strlen($_POST['tel']) != 10) {
        $_SESSION['error'] = 'กรุณากรอกเบอร์ให้ครบ หรือ กรอกให้ถูกต้อง';
        header("location: user.php");                               
        exit();
    } else if (empty($date_reserve)) {
        $_SESSION['error'] = 'กรุณากรอกวันที่';
        header("location: user.php");                               
        exit();
    } else if (empty($start_time)) {
        $_SESSION['error'] = 'กรุณากรอกเวลาเริ่ม';
        header("location: user.php");                               
        exit();
    } else if (empty($end_time)) {
        $_SESSION['error'] = 'กรุณากรอกเวลาเลิก';
        header("location: user.php");                               
        exit();
    }


    

    // ตรวจสอบว่ามีข้อมูลผู้ใช้ในตาราง user หรือไม่
    $stmt = $conn->prepare("SELECT id FROM users WHERE firstname = :firstname AND lastname = :lastname");
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้ในระบบ";
        header("location:user.php");
        exit();
    }

    // หากมีข้อมูลผู้ใช้ในตาราง user จะดึงค่า id ของผู้ใช้จาก $user มาเก็บในตัวแปร $user_id
    $user_id = $user['id'];

    
    $stmt_check_duplicate = $conn->prepare("SELECT COUNT(*) as count FROM football_field WHERE field_number = :field_number AND date_reserve = :date_reserve AND ((start_time <= :start_time AND end_time >= :start_time) OR (start_time <= :end_time AND end_time >= :end_time) OR (:start_time <= start_time AND :end_time >= start_time) OR (:start_time <= end_time AND :end_time >= end_time)) AND status != 'ยกเลิกการจอง'");
    $stmt_check_duplicate->bindParam(":field_number", $field_number);
    $stmt_check_duplicate->bindParam(":date_reserve", $date_reserve);
    $stmt_check_duplicate->bindParam(":start_time", $start_time);
    $stmt_check_duplicate->bindParam(":end_time", $end_time);
    $stmt_check_duplicate->execute();
    $result_check_duplicate = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);

    if ($result_check_duplicate['count'] > 0) {
    $_SESSION['error'] = "มีการจองซ้ำกันในช่วงเวลานี้ กรุณาเลือกเวลาหรือสนามอื่น";
    header("location:user.php");
    exit();
}

    // เช็คสถานะการจองของสนามในช่วงเวลานี้


    // ตรงนี้คือการเพิ่มรายการของการจองลงในตาราง football_field
    $status = "รออัปโหลดสลิป"; // เพิ่มสถานะ "รอดำเนินการ" ที่จะให้แสดงในตาราง
    $image_status = "รออัปโหลดสลิป";
    $stmt = $conn->prepare("INSERT INTO football_field(user_id, firstname, lastname, tel, date_reserve, start_time, end_time, field_number, status ,image_status) VALUES(:user_id, :firstname, :lastname, :tel, :date_reserve, :start_time, :end_time, :field_number, :status ,:image_status)");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":tel", $tel);
    $stmt->bindParam(":date_reserve", $date_reserve);
    $stmt->bindParam(":start_time", $start_time);
    $stmt->bindParam(":end_time", $end_time);
    $stmt->bindParam(":field_number", $field_number);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(':image_status', $image_status);
    $stmt->execute();

    $resever_id = $conn->lastInsertId(); // รับค่า resever_id ที่เพิ่งเพิ่มลงในฐานข้อมูล
    $image_status = $conn->lastInsertId();
    $_SESSION['resever_id'] = $resever_id;
    $_SESSION['image_status'] = $image_status;


    $_SESSION['success'] = "จองสนามเรียบร้อยแล้ว!";
    header("location:my_data_reserve.php");
    exit();
}
?>