<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    

</head>
<body>  
        <nav class="navbar navbar-expand-lg" style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; " >
  <div class="container-fluid">
    <a class="navbar-brand" href="user.php">หน้าแรก</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="data_reserve.php">ข้อมูลการจอง</a>
        </li>
        
      </ul>
      
    </div>
  </div>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</nav> 

<br>
<br>

<section>
<div class="container-md" id="tabal" style="background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ">

<table class="table table-striped table-bordered table-hover  ">

      

  <thead>
    <tr>
      
      <th>ชื่อ</th>
      <th>นามสกุล</th>
      <th>เบอร์โทร</th>
      <th>วันที่</th>
      <th>เวลาเริ่ม</th>
      <th>เวลาเลิก</th>
      <th>สนามที่</th>


    </tr>
  </thead>
  
    <tbody>
        <h2>ค้นหา</h2>
     <?php 
        $select_stmt = $conn->prepare("SELECT * FROM football_field ");
        $select_stmt->execute();

        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)){         
     ?>
        <tr>
          <td><?php  echo $row['firstname']; ?></td>
          <td><?php  echo $row['lastname']; ?></td>
          <td><?php  echo $row['tel']; ?></td>
          <td><?php  echo $row['date_reserve']; ?></td>
          <td><?php  echo $row['start_time']; ?></td>
          <td><?php  echo $row['end_time']; ?></td>
          <td><?php  echo $row['field_number']; ?></td>
          
        </tr>
    <?php } ?>



    </tbody>
</table>

        </div>

</div>

</section>

</body>
</html>