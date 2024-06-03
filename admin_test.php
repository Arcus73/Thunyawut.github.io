<?php

require_once 'config/db.php';
session_start();
date_default_timezone_set("Asia/Bangkok");

    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }

if (isset($_GET['delete_id'])) {
    $delete_stmt = $conn->prepare('DELETE FROM football_field WHERE resever_id = :resever_id');
    $delete_stmt->bindParam(':resever_id', $_GET['delete_id']);
    $delete_stmt->execute();
    $_SESSION['success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
    header('location: admin_test.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>ระบบจองสนามฟุตบอล</title>
  <style type="text/css">
  input[type="date"]::-webkit-datetime-edit,
  input[type="date"]::-webkit-inner-spin-button,
  input[type="date"]::-webkit-clear-button {
    color: #fff;
    position: relative;
  }

  input[type="date"]::-webkit-datetime-edit-year-field {
    position: absolute !important;
    border-left: 1px solid #8c8c8c;
    padding: 2px;
    color: red;
    left: 56px;
  }

  input[type="date"]::-webkit-datetime-edit-month-field {
    position: absolute !important;
    border-left: 1px solid #8c8c8c;
    padding: 2px;
    color: red;
    left: 26px;
  }

  input[type="date"]::-webkit-datetime-edit-day-field {
    position: absolute !important;
    color: red;
    padding: 2px;
    left: 4px;
  }
  </style>
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
          </li>
          <li class="nav-item">
            <a class="nav-link active text-primary" aria-current="page" href="report_admin.php">สรุปรายงาน</a>
          </li>
        </ul>
      </div>
    </div>

    <a href="logout.php" class="btn btn-danger ">Logout</a>
  </nav>
  <br>
  <script>
  function uploadImage(resever_id) {
    // ส่งค่า resever_id ไปยังหน้า confirm_reserve.php โดยใช้ URL parameter
    window.location.href = "confirm_reserve.php?resever_id=" + resever_id;
  }
  </script>
  <div class="container">
    <div class="row">
      <div class="col-md-12"> <br>
        <h4>ตารางแสดงข้อมูลการจอง</h4>
        <form action="" method="get">
          <input type="date" name="q" data-date-format="dd-mm-Y" class="form-control">

          <br>
          <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button>
          <a href="admin_test.php" class="btn btn-warning">เคลียร์ข้อมูล</a>
        </form>
        <div class="col-md-6"> <br>
          <h4>เพิ่มการจองสนาม</h4>
          <button class="btn btn-primary" onclick="openReservationForm()">เพิ่มการจองสนาม</button>
          <script>
          function openReservationForm() {
            window.open("reservation_form.php", "_blank");
          }
          </script>
        </div>

        </form>


        <?php
            // ถ้ามีการส่ง $_GET['q']
            if (isset($_GET['q'])) {
                $stmt = $conn->prepare("SELECT ff.*, img.image AS image, img.status AS image_status
                                       FROM football_field AS ff 
                                       LEFT JOIN imagesdb AS img 
                                       ON ff.resever_id = img.resever_id 
                                       WHERE ff.date_reserve = ?  ORDER BY ff.resever_id DESC, ff.start_time ASC ");
                $stmt->execute([$_GET['q']]);
            } else {
                $stmt = $conn->prepare("SELECT ff.*, img.image AS image, img.status AS image_status
                                       FROM football_field AS ff 
                                       LEFT JOIN imagesdb AS img 
                                       ON ff.resever_id = img.resever_id 
                                       ORDER BY ff.resever_id DESC, ff.start_time ASC");
                $stmt->execute();
            }
         
            $result = $stmt->fetchAll();
            
            // แสดงข้อมูลทั้งหมด

                // ถ้าเจอข้อมูลมากกว่า 0
                if ($stmt->rowCount() > 0): ?>
        <br>
        <table class="table table-striped table-hover table-responsive table-bordered">
          <thead>
            <tr>
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
              <th>ชื่อ</th>
              <th>นามสกุล</th>
              <th>เบอร์โทร</th>
              <th>วันที่</th>
              <th>เวลาเริ่ม</th>
              <th>เวลาเลิก</th>
              <th>สนามที่</th>
              <th>รูป</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
              <th>สถานะดำเนินการ</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row): ?>
            <tr>
              <td><?= $row['firstname'] ?></td>
              <td><?= $row['lastname'] ?></td>
              <td><?= $row['tel'] ?></td>
              <td><?= date('d/m/Y', strtotime($row['date_reserve'])) ?></td>
              <td><?= $row['start_time'] ?></td>
              <td><?= $row['end_time'] ?></td>
              <td><?= $row['field_number'] ?></td>
              <td>
                <?php if ($row['image_status'] === 'อัปโหลดสลิปแล้ว' && ($row['image'])): ?>
                <a href="javascript:void(0);" onclick="openImage('uploads/<?= $row['image'] ?>')">
                  <img src="uploads/<?= $row['image'] ?>" alt="ไม่มีรูปภาพ" width="50">
                </a>
                <?php else: ?>
                No Image
                <?php endif; ?>
              </td>

              <script>
              function openImage(imageUrl) {
                window.open(imageUrl, '_blank');
              }
              </script>
              <td>
                <form action="edit_reservation.php" method="POST">
                  <input type="hidden" name="resever_id" value="<?= $row['resever_id']; ?>">
                  <button type="submit" class="btn btn-primary">แก้ไข</button>
                </form>
              </td>
              <td>
                <form id="deleteForm-<?= $row['resever_id']; ?>" action="delete_reservation.php" method="POST">
                  <input type="hidden" name="resever_id" value="<?= $row['resever_id']; ?>">
                  <button type="button" onclick="confirmDelete(<?= $row['resever_id']; ?>)"
                    class="btn btn-danger">ลบ</button>
                </form>
                <script>
                function confirmDelete(resever_id) {
                  Swal.fire({
                    title: 'คุณต้องการลบรายการนี้ใช่หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                    reverseButtons: true,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // หากผู้ใช้กด "ใช่" ให้ทำการส่งคำขอลบข้อมูลไปยัง "delete_reservation.php" โดยใช้เมธอด POST
                      const deleteForm = document.getElementById('deleteForm-' + resever_id);
                      deleteForm.submit();
                    }
                  });
                }
                </script>
              </td>
              <td>
                <?php if ($row['status'] === 'รอยืนยันการจอง' || $row['status'] === 'อัปโหลดสลิปแล้ว') : ?>
                <form id="statusForm-<?php echo $row['resever_id']; ?>" action="admin_status_reservation.php"
                  method="POST">
                  <input type="hidden" name="resever_id" value="<?php echo $row['resever_id']; ?>">
                  <button type="button" onclick="confirmStatus(<?php echo $row['resever_id']; ?>)"
                    class="btn btn-success">กดเพื่อยืนยันการจอง</button>
                </form>
                <?php else: ?>
                <?= $row['status'] ?>
                <?php endif; ?>
              </td>
              <script>
              function confirmStatus(resever_id) {
                Swal.fire({
                  title: 'คุณต้องการเปลี่ยนสถานะการดำเนินการใช่หรือไม่?',
                  text: 'คุณแน่ใจหรือไม่ที่จะดำเนินการต่อ?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonText: 'ใช่',
                  cancelButtonText: 'ไม่',
                  reverseButtons: true,
                }).then((result) => {
                  if (result.isConfirmed) {
                    // หากผู้ใช้กด "ใช่" ให้ทำการส่งคำขอเปลี่ยนสถานะไปยัง "admin_status_reservation.php" โดยใช้เมธอด POST
                    const statusForm = document.getElementById('statusForm-' + resever_id);
                    statusForm.submit();
                  }
                });
              }
              </script>
              <td>
                <form id="cancelForm-<?= $row['resever_id']; ?>" action="cancel_reservation.php" method="POST">
                  <input type="hidden" name="resever_id" value="<?= $row['resever_id']; ?>">
                  <button type="button" onclick="confirmCancel(<?= $row['resever_id']; ?>)"
                    class="btn btn-danger">ยกเลิกรายการจอง</button>
                </form>
                <script>
                function confirmCancel(resever_id) {
                  Swal.fire({
                    title: 'คุณต้องการยกเลิกรายการจองนี้ใช่หรือไม่?',
                    text: 'การกระทำนี้ไม่สามารถยกเลิกได้ภายหลัง',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                    reverseButtons: true,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // หากผู้ใช้กด "ใช่" ให้ทำการส่งคำขอยกเลิกรายการจองไปยัง "cancel_reservation.php" โดยใช้เมธอด POST
                      const cancelForm = document.getElementById('cancelForm-' + resever_id);
                      cancelForm.submit();
                    }
                  });
                }
                </script>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <a> -ไม่พบข้อมูล !! </a>
        <?php endif; ?>
      </div>

      <!-- ... your JavaScript imports and other content ... -->
</body>

</html>