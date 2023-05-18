<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once '../dbconnect.php';

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm']) {
    echo "<script>
    $(document).ready(function() {
      Swal.fire( {
          title : 'แจ้งเตือน',
          text : 'คุณไม่สามารถเข้าหน้านี้ได้!',
          icon : 'warning',
          timer : 3000,
          showConfirmButton : false
        });
    });
  </>";
    // header("refresh:2; url=../home.php");
    session_destroy();
    header("location: ../home.php");
} else {

    $user_id = $_GET['id'];
    $sql = "SELECT * FROM tb_place where id='$user_id'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $id = $row["id"];
    $company_name = $row["company_name"];
    $imageFileName = $row["imge"];
    $imageFilePath = 'place/' . $imageFileName;

    $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
    $query_province = mysqli_query($conn, $sql_province);
    $sql_district = "SELECT * FROM th_district where province_id = '" . $row['province_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
    $query_district = mysqli_query($conn, $sql_district);
    $sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '" . $row['district_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
    $query_subdistrict = mysqli_query($conn, $sql_subdistrict);

    if (isset($_POST['btnupdate'])) {
        $id = $_POST['id'];
        $company_name = $_POST['company_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $province_id = $_POST['province_id'];
        $district_id = $_POST['district_id'];
        $subdistrict_id = $_POST['subdistrict_id'];
        $zipcode = $_POST['zipcode'];
        $url = $_POST['url'];

        // check if a new image was uploaded
        if (!empty($_FILES['imge']['name'])) {
            $imge = $_FILES['imge'];
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $imge['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'place/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($imge['size'] > 0 && $imge['error'] == 0) {
                    // delete the old image if it exists
                    $sql = "SELECT imge FROM tb_place WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'place/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        if (is_file($oldFilePath)) { // เพิ่มเงื่อนไขนี้
                            unlink($oldFilePath);
                        }
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);

                    $sql = "UPDATE tb_place 
    SET company_name = '$company_name',
    address = '$address',
    email = '$email',
    phonenumber = '$phonenumber',
    province_id = '$province_id',
    district_id = '$district_id',
    subdistrict_id = '$subdistrict_id',
    zipcode = '$zipcode',
    url = '$url',
    imge = '$fileNew' 
    WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<script>
                          $(document).ready(function() {
                          Swal.fire( {
                              title : 'บันทึกข้อมูลสำเร็จ',
                              icon : 'success',
                              timer : 2000,
                              showConfirmButton : false
                            }).then(function() {
                              window.location.href = 'place.php';
                            });
                          });
                        </script>";
                    } else {
                        echo "<script>
  $(document).ready(function() {
  Swal.fire( {
      title : 'แจ้งเตือน',
      text : 'แก้ไขข้อมูลไม่สำเร็จ',
      icon : 'warning',
      timer : 2000
      });
});
</script>";
                    }
                }
            }
        } else {
            // no new image was uploaded, just update the other fields
            $sql = "UPDATE tb_place 
            SET company_name = '$company_name',
            address = '$address',
            email = '$email',
            phonenumber = '$phonenumber',
            province_id = '$province_id',
            district_id = '$district_id',
            subdistrict_id = '$subdistrict_id',
            zipcode = '$zipcode',
            url = '$url'
            WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                title : 'บันทึกข้อมูลสำเร็จ',
                icon : 'success',
                timer : 2000,
                showConfirmButton : false
                }).then(function() {
                    window.location.href = 'place.php';
                });
                });
                </script>";
            } else {
                echo "<script>
        $(document).ready(function() {
        Swal.fire( {
        title : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
        icon : 'warning',
        timer : 2000
        });
        });
        </script>";
            }
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <?php require_once '../design/head.php'; ?>

    <body>

        <!-- btn top -->
        <!-- โค้ด HTML ของปุ่ม scroll-to-top -->
        <button id="scroll-to-top" title="เลื่อนไปข้างบนสุด">
            <i class="fas fa-chevron-up"></i>
        </button>

        <!-- โค้ด JavaScript สำหรับ Smooth Scrolling -->
        <script>
            $(document).ready(function() {
                // เมื่อคลิกปุ่ม scroll-to-top
                $('#scroll-to-top').click(function() {
                    // ใช้ animate() function เพื่อเลื่อนขึ้นด้านบนสุดของหน้าจอ
                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');
                });

                // ตรวจสอบเมื่อมีการเลื่อนหน้าจอและแสดงหรือซ่อนปุ่มตามตำแหน่งของเลื่อนหน้าจอ
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 300) {
                        $('#scroll-to-top').fadeIn();
                    } else {
                        $('#scroll-to-top').fadeOut();
                    }
                });
            });
        </script>
        <!-- end btn top -->

        <!-- nav -->
        <header class="bg-dark p-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
                    <div class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <a class="navbar-brand" href="index.php"><img src="../Logo.png" width="40" height="64"></a>
                    </div>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                        <li><a href="index.php" class="nav-link px-2 link-light">&nbsp;&nbsp;<i class="fa-regular fa-message"></i>&nbsp;กระทู้</a></li>
                        <li><a href="form_register.php" class="nav-link px-2 link-secondary"><i class="fa-solid fa-gears"></i>&nbsp;การจัดการผู้ดูแลระบบ</a></li>
                    </ul>

                    <div class="text-end">
                        <p class="fs-6 fw-bold text-light p-2 text-center badge bg-danger text-wrap"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</p>
                        &nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

        <div class="container-fluid">
            <div class="row justify-content-start">
                <div class="col-12 col-md-3 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="accordion accordion-flush border" id="accordionPanelsStayOpenExample">
                        <a class="btn w-100 p-3 text-start rounded-0" href="profile_tm.php" role="button"><i class="fa-solid fa-user-gear"></i>&nbsp;ข้อมูลส่วนตัว</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="work_history.php" role="button"><i class="fa-solid fa-business-time"></i>&nbsp;ประวัติการทำงาน</a>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    <i class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูลสมาชิก</button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_register.php" class="text-decoration-none text-dark">เพิ่มข้อมูลนักศึกษาสหกิจ</a></li>
                                        <li class="list-group-item"><a href="form_register2.php" class="text-decoration-none text-dark ">เพิ่มข้อมูลอาจารย์ที่ปรึกษาหรืออาจารย์ประสานงาน</a></li>
                                        <li class="list-group-item"><a href="form_register3.php" class="text-decoration-none text-dark">เพิ่มข้อมูลพี่เลี้ยงนักศึกษาสหกิจ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    <i class="fa-solid fa-user-plus"></i>&nbsp;เพิ่มข้อมูลหลายคน</button>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_csv.php" class="text-decoration-none text-dark">เพิ่มข้อมูลนักศึกษาสหกิจ</a></li>
                                        <li class="list-group-item"><a href="form_csv2.php" class="text-decoration-none text-dark">เพิ่มข้อมูลอาจารย์ที่ปรึกษาหรืออาจารย์ประสานงาน</a></li>
                                        <li class="list-group-item"><a href="form_csv3.php" class="text-decoration-none text-dark">เพิ่มข้อมูลพี่เลี้ยงนักศึกษาสหกิจ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="sandemail_place.php" role="button"><i class="fa-solid fa-map-location-dot"></i>&nbsp;การจัดหาสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="form_file.php" role="button"><i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0 text-primary" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>

                <?php
                // $id = $row["id"];
                // $imageFileName = $row["imge"];
                // $imageFilePath = 'place/' . $imageFileName;
                ?>

                <div class="col-12 col-md-9 pb-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-header fs-3 text-center">
                                <div><span class="badge rounded-pill text-bg-warning">แก้ไข</span>&nbsp;<?php echo $company_name; ?> </div>
                            </div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <?php if (isset($imageFileName) && (strpos($imageFileName, ".png") !== false || strpos($imageFileName, ".jpeg") !== false || strpos($imageFileName, ".jpg") !== false)) { ?>
                                        <div class="row align-items-center mb-3">
                                            <div class="col text-end">
                                                <a class="btn btn-danger" href="del_imgeplace.php?del=<?php echo $id; ?>" role="button" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')"><i class="fa-solid fa-trash-can"></i>&nbsp;ลบรูปภาพ</a>
                                                <!-- <button type="submit" class="btn btn-sm btn-danger" name="btndelimage" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')"><i class="fa-solid fa-trash-can"></i>&nbsp;ลบรูปภาพ</button> -->
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <span></span>
                                    <?php } ?>
                                </form>

                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                                    <?php if (!empty($imageFileName) && file_exists($imageFilePath)) { ?>
                                        <div class="col-12 text-center">
                                            <img src="<?= $imageFilePath ?>" class="img-fluid rounded mb-3" style="max-height: 300px;">
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center mb-3">
                                            <img src="no_image.jpg" class="img-fluid rounded" style="max-width: 400px; max-height: 400px;">
                                        </div>
                                    <?php } ?>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupFile01"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                        <input type="file" name="imge" class="form-control" id="inputGroupFile01" accept="image/jpeg, image/png, image/jpg" value="<?php echo $imageFileName; ?>">
                                    </div>

                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInput6" name="company_name" placeholder="บริษัท" value="<?php echo $company_name; ?>" required>
                                                <label for="floatingInput6">บริษัท</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="province_id" id="province_id" required>
                                                    <?php
                                                    $provinces = $row['province_id'];
                                                    $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
                                                    $query_province = mysqli_query($conn, $sql_province);
                                                    while ($province = mysqli_fetch_assoc($query_province)) { ?>
                                                        <option <?= ($provinces == $province['province_id']) ? 'selected' : ''; ?> value="<?php echo $province['province_id'] ?>"><?php echo $province['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="provinces">จังหวัด</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="district_id" id="district_id" required>
                                                    <?php
                                                    $district_id = $row['district_id'];
                                                    $sql_district = "SELECT * FROM th_district where province_id = '" . $row['province_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
                                                    $query_district = mysqli_query($conn, $sql_district);
                                                    while ($district = mysqli_fetch_array($query_district)) { ?>
                                                        <option <?= ($district_id == $district['district_id']) ? 'selected' : ''; ?> value="<?php echo $district['district_id'] ?>"><?php echo $district['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="district_id">อำเภอ</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="subdistrict_id" id="subdistrict_id" required>
                                                    <?php
                                                    $districts = $row['subdistrict_id'];
                                                    $sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '" . $row['district_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
                                                    $query_subdistrict = mysqli_query($conn, $sql_subdistrict);
                                                    while ($subdistrict = mysqli_fetch_array($query_subdistrict)) { ?>
                                                        <option <?= ($districts == $subdistrict['subdistrict_id']) ? 'selected' : ''; ?> value="<?php echo $subdistrict['subdistrict_id'] ?>"><?php echo $subdistrict['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="districts">ตำบล</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo $row['zipcode']; ?>" readonly required>
                                                <label for="zip_code">รหัสไปรษณีย์</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com" value="<?php echo $row['email']; ?>">
                                                <label for="floatingInput">อีเมล</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="phonenumber" id="floatingInput" value="<?php echo $row['phonenumber']; ?>" placeholder="name@example.com" minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                <label for="floatingInput">เบอร์โทรศัพท์</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com" value="<?php echo $row['email']; ?>">
                                                <label for="floatingInput">อีเมล</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="phonenumber" id="floatingInput" value="<?php echo $row['phonenumber']; ?>" placeholder="name@example.com" minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                <label for="floatingInput">เบอร์โทรศัพท์</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput10" name="address" placeholder="รายละเอียดที่อยู่" value="<?php echo $row['address']; ?>" required>
                                        <label for="floatingInput10">รายละเอียดที่อยู่</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput9" name="url" placeholder="รายละเอียดที่อยู่" value="<?php echo $row['url'] ?>" required>
                                        <label for="floatingInput9">เพิ่มลิ้งค์</label>
                                    </div>

                            </div>
                            <div class="card-footer text-end">
                                <!-- <a class="btn btn-success" href="updateplace.php?edituser=<?php echo $row['id'] ?>" role="button"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</a> -->
                                <button type="submit" name="btnupdate" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                <a class="btn btn-danger" href="place.php" role="button">ยกเลิก</a>
                                <!-- <button type="button" class="btn btn-danger"></button> -->
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <script src="js/script.js" charset="utf-8"></script>
            <?php } ?>
            <?php require_once '../design/footer.php'; ?>

    </body>

    </html>