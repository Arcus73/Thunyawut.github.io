<?php 
session_start();
require_once 'config/db.php';


if (isset($_POST['id'])) {
    $delete_stmt = $conn->prepare('DELETE FROM users WHERE id = :id');
    $delete_stmt->bindParam(':id', $_POST['id']);
    $delete_stmt->execute();
    $_SESSION['success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
    header('Location: manage_data_users.php');
}
?>