<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}

if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

    // ตรวจสอบว่ามีการอ้างอิงผู้ใช้งานนี้ในตาราง football_field หรือไม่
    $check_stmt = $conn->prepare('SELECT * FROM football_field WHERE user_id = :user_id');
    $check_stmt->bindParam(':user_id', $user_id);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        $_SESSION['error'] = 'ไม่สามารถลบผู้ใช้งานนี้ได้ เนื่องจากมีการอ้างอิงในการจองสนาม';
        header('location: manage_data_users.php');
        exit();
    }

    // ลบผู้ใช้งาน
    $delete_stmt = $conn->prepare('DELETE FROM users WHERE id = :id');
    $delete_stmt->bindParam(':id', $user_id);
    
    if ($delete_stmt->execute()) {
        $_SESSION['success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการลบข้อมูล';
    }

    header('location: manage_data_users.php');
    exit();
}

if (isset($_POST['update_id'])) {
    $update_stmt = $conn->prepare('UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, urole = :urole WHERE id = :id');
    $update_stmt->bindParam(':firstname', $_POST['firstname']);
    $update_stmt->bindParam(':lastname', $_POST['lastname']);
    $update_stmt->bindParam(':email', $_POST['email']);
    $update_stmt->bindParam(':urole', $_POST['urole']);
    $update_stmt->bindParam(':id', $_POST['update_id']);
    if ($update_stmt->execute()) {
        $_SESSION['success'] = 'อัปเดตข้อมูลเรียบร้อยแล้ว';
        echo '<script>alert("อัปเดตข้อมูลเรียบร้อยแล้ว");</script>';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดตข้อมูล");</script>';
    }
    header('location: manage_data_users.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light "
    style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="admin_test.php">ข้อมูลการจอง</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page"
              href="manage_data_users.php">จัดการข้อมูลสมาชิก</a>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="report_admin.php">สรุปรายงาน</a>
          </li>
        </ul>
      </div>
    </div>

    <a href="logout.php" class="btn btn-danger ">Logout</a>
  </nav>
  <br>
  <br>

  <section>

    <div class="container-md" id="tabal"
      style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">
      <br>
      <h2 style="color:#296bfa;">ตารางแสดงข้อมูลสมาชิก</h2>

      <table class="table table-striped table-bordered table-hover  ">

        <thead>
          <div>

            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

          </div>
          <tr>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>ชื่อเข้าใช้งาน</th>
            <th>สิทธิ์เข้าการใช้งาน</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
          </tr>
        </thead>

        <tbody>

          <?php
                    $select_stmt = $conn->prepare("SELECT * FROM users ");
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
          <tr>
            <form action="manage_data_users.php" method="post">
              <td><input type="text" name="firstname" value="<?php echo $row['firstname']; ?>"></td>
              <td><input type="text" name="lastname" value="<?php echo $row['lastname']; ?>"></td>
              <td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
              <td>
                <select name="urole">
                  <option value="admin" <?php if ($row['urole'] == 'admin') echo 'selected'; ?>>Admin</option>
                  <option value="user" <?php if ($row['urole'] == 'user') echo 'selected'; ?>>User</option>
                </select>
              </td>
              <td>
                <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-primary" id="updateButton">อัปเดต</button>

              </td>
            </form>
            <td>
              <a href="manage_data_users.php?delete_id=<?php echo $row['id']; ?>"
                onclick="return confirm('คุณต้องการลบผู้ใช้งานนี้หรือไม่?')" class="btn btn-danger">ลบ</a>

            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>

    </div>

    </div>

    </nav>
</body>

</html>