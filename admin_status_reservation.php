<?php
require_once 'config/db.php';
session_start();

if (isset($_POST['resever_id'])) {
    

    
    $new_status = 'ยืนยันการจองแล้ว'; // กำหนดสถานะที่ต้องการให้กับตัวแปร $new_status
    $status_stmt = $conn->prepare('UPDATE football_field SET status = :status WHERE resever_id = :resever_id');
    $status_stmt->bindValue(':status', $new_status); // กำหนดค่าสถานะให้กับ :status
    $status_stmt->bindParam(':resever_id', $_POST['resever_id']);
    
    // ทำการเปลี่ยนสถานะก็ต่อเมื่อมีการส่งคำขอเปลี่ยนสถานะมาจากฟอร์ม
    if ($status_stmt->execute()) {
        $_SESSION['success'] = 'ยืนยันการจองเรียบร้อยแล้ว';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการดำเนินการ';
    }

    // กลับไปที่หน้า "admin_test.php" หลังจากที่ได้ทำการเปลี่ยนสถานะ
    header('Location: admin_test.php');
    exit;
}

?>