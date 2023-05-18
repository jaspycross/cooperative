<?php require_once 'dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'design/head.php'; ?>

<body>
  <!-- nav -->
  <header class="bg-dark p-4 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
        <div class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="Logo.png" width="40" height="64">&nbsp;&nbsp;
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Logo"><use xlink:href="#Logo"></use></svg> -->
        </div>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
          <li><a href="indexmes.php" class="nav-link px-2 link-light"><i class="fa-regular fa-message"></i>&nbsp;&nbsp;กระทู้</a></li>
          <li><a href="index2.php" class="nav-link px-2 link-secondary"><i class="fa-solid fa-map-location-dot"></i>&nbsp;&nbsp;สถานที่ฝึกสหกิจศึกษา</a></li>
        </ul>
        <a class="btn btn btn-outline-light" href="home.php" role="button">เข้าสู่ระบบ</a>
      </div>
    </div>
  </header>
  <!-- End nav -->

  <div class="container my-2 fs-5">
    <div class="card">
      <div class="card-body">
        <form action="index2.php?load=SUBMIT" method="get">
          <p class="form-label">&nbsp;&nbsp;ค้นหาสถานที่</p>
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-describedby="button-addon2" name="ename">
            <button class="btn btn-primary" type="submit" id="button-addon2" title="ค้นหา"><i class="fa-solid fa-magnifying-glass fa-lg"></i>&nbsp;&nbsp;</button>
          </div>
          <div class="text-start">
            <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>&nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด </label>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (isset($_GET['ename']) ? $name = $_GET['ename'] : $name = ""); {
    $sql = "SELECT 
    tb_place.id,
    tb_place.company_name,
    tb_place.address,
    tb_place.email,
    tb_place.phonenumber,
    tb_place.province_id,
    th_province.name_th AS provincesname, 
    tb_place.district_id,
    th_district.name_th AS districtname, 
    tb_place.subdistrict_id,
    th_subdistrict.name_th AS subdistrictname, 
    tb_place.zipcode,
    tb_place.imge,
    tb_place.url,
    tb_place.time
    FROM tb_place
    LEFT JOIN th_province ON tb_place.province_id = th_province.province_id 
    LEFT JOIN th_district ON tb_place.district_id = th_district.district_id
    LEFT JOIN th_subdistrict ON tb_place.subdistrict_id = th_subdistrict.subdistrict_id
    WHERE 
    tb_place.company_name LIKE '%$name%' OR 
    tb_place.address LIKE '%$name%' OR 
    th_province.name_th LIKE '%$name%' OR 
    th_district.name_th LIKE '%$name%' OR 
    th_subdistrict.name_th LIKE '%$name%' OR 
    tb_place.zipcode LIKE '%$name%' ORDER BY tb_place.id DESC";
    $result = mysqli_query($conn, $sql);
  }
  ?>

  <div class="container  fs-5">
    <?php if (mysqli_num_rows($result) > 0) { ?>
      <div class="row ">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <div class="col-md-12 my-3">
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-center align-items-center g-2">
                  <div class="col">
                    <div class="btn-group dropend">
                      <button type="button" class="btn btn-light dropdown-toggle fs-3" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-map-location-dot fa-lg"></i>&nbsp;&nbsp;<?php echo $row['company_name']; ?>
                      </button>
                      <ul class="dropdown-menu">
                        <?php echo $row['url']; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row justify-content-center align-items-center g-2">
                  <?php
                  $imageFileName = $row["imge"];
                  $imageFilePath = 'admin/place/' . $imageFileName;
                  if (!empty($imageFileName) && file_exists($imageFilePath)) { ?>
                    <div class="col-6 text-center">
                      <img src="<?= $imageFilePath ?>" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    </div>
                  <?php } else { ?>
                    <div class="col-6 text-center">
                      <img src="admin/no_image.jpg" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    </div>
                  <?php } ?>
                  <div class="col-12 col-md-6 col-sm-12">
                    <p><?php echo $row['company_name']; ?></p>
                    <p><?php echo 'จังหวัด : ' . $row['provincesname']; ?></p>
                    <p><?php echo 'อำเภอ : ' . $row['districtname']; ?></p>
                    <p><?php echo 'ตำบล : ' . $row['subdistrictname']; ?></p>
                    <p><?php echo 'รหัสไปรษณีย์ : ' . $row['zipcode']; ?></p>
                    <p><?php echo 'อีเมล : ' . $row['email']; ?></p>
                    <p><?php echo 'เบอร์โทรศัพท์ : ' . $row['phonenumber']; ?></p>
                    <p><?php echo 'รายละเอียด : ' . $row['address']; ?></p>
                    <p class="fs-6 text-muted"><?php
                                                setlocale(LC_TIME, "th_TH.UTF-8"); // เลือก locale ภาษาไทย
                                                $thai_month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); // อาเรย์ชื่อเดือนภาษาไทย
                                                echo date('d', strtotime($row['time'])) . ' ' . $thai_month[date('m', strtotime($row['time'])) - 1] . ' ' . (date('Y', strtotime($row['time'])) + 543) . ' ' . date('H:i:s', strtotime($row['time'])); // แสดงวันที่ ด้วยเดือนภาษาไทยและปี พ.ศ. และเวลา
                                                ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
  </div>
<?php } else {
      echo '<div class="text-center"><div class="card p-5 my-3">' . "ไม่มีข้อมูลลองค้นหาข้อมูลอีกครั้ง" . '</div></div>';
    } ?>
</div>







<?php require_once 'design/footer.php'; ?>

</body>

</html>