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

    if (isset($_POST['btnsubmit'])) {
        isset($_FILES['imge']) ? $imge = $_FILES['imge'] : $imge = "";
        $company_name = $_POST['company_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $province_id = $_POST['province_id'];
        $district_id = $_POST['district_id'];
        $subdistrict_id = $_POST['subdistrict_id'];
        $zipcode = $_POST['zipcode'];
        $url = $_POST['url'];

        $temp = explode(".", $imge['name']);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $file_ext = strtolower(end($temp));

        $allowed_extensions = array("jpg", "jpeg", "png");
        move_uploaded_file($imge['tmp_name'], "../admin/place/" . $newfilename);

        $sql = "INSERT INTO tb_place(company_name, address, email, phonenumber, province_id, district_id, subdistrict_id, zipcode, imge, url)
          VALUE ('$company_name', '$address', '$email', '$phonenumber', '$province_id', '$district_id', '$subdistrict_id', '$zipcode', '$newfilename', '$url')";

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
                text : 'มีปัญหาในการนำเข้าข้อมูล ลองใหม่อีกครั้ง',
                icon : 'warning',
                timer : 2000,
                showConfirmButton : false
            });
        });
        </script>";
        }
    }

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
        $img = $_FILES['imge'];

        isset($_POST['img2']) ? $img2 = $_POST['img2'] : $img2 = "";
        // $img2 = $_POST['img2'];
        $upload = $_FILES['imge']['name'];

        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'place/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    move_uploaded_file($img['tmp_name'], $filePath);
                }
            }
        } else {
            $fileNew = $img2;
        }

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
          title : 'แก้ไขข้อมูลสำเร็จ',
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
                        <a class="btn w-100 p-3 text-start  border-bottom rounded-0" href="form_file.php" role="button"><i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร</a>
                        <a class="btn w-100 p-3 text-start text-primary border-bottom rounded-0" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>


                <!-- Button trigger modal -->
                <div class="col-12 col-md-9 pb-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-header text-center">
                                <button type="button" class="btn btn-primary p-3 my-3" data-bs-toggle="modal" data-bs-target="#exampleModal" title="เพิ่มสถานที่ฝึกงาน">
                                    <i class="fa-solid fa-plus fa-lg"></i>&nbsp;&nbsp;สถานที่ฝึกงาน</button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #003366;">
                                            <div class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot fs-3"></i>&nbsp;&nbsp;เพิ่มสถานที่สถานที่ฝึกงาน</div>
                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="background-color: #e5eaef;">

                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row justify-content-center align-items-center mt-3">
                                                    <div class="col-12 mt-2 mt-md-0 mt-sm-0">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingInput" name="company_name" placeholder="ชื่อบริษัท" required>
                                                            <label for="floatingInput">ชื่อบริษัท</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating">
                                                            <select class="form-select" name="province_id" id="province_id" required>
                                                                <option value="">กรุณาเลือกจังหวัด</option>
                                                                <?php
                                                                $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
                                                                $query = mysqli_query($conn, $sql_province);
                                                                while ($province = mysqli_fetch_array($query)) { ?>
                                                                    <option value="<?php echo $province['province_id'] ?>"><?php echo $province['name_th'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <label for="provinces">จังหวัด</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating">
                                                            <select class="form-select" name="district_id" id="district_id" required>
                                                                <option value="">กรุณาเลือกอำเภอ</option>
                                                            </select>
                                                            <label for="district_id">อำเภอ</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating">
                                                            <select class="form-select" name="subdistrict_id" id="subdistrict_id" required>
                                                                <option value="">กรุณาเลือกตำบล</option>
                                                            </select>
                                                            <label for="subdistrict_id">ตำบล</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control" name="zipcode" id="zipcode" readonly required>
                                                            <label for="zipcode">รหัสไปรษณีย์</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center align-items-center mt-md-3 mt-sm-0">
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">อีเมล</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" class="form-control" name="phonenumber" id="floatingInput" placeholder="name@example.com" minlength="10" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                            <label for="floatingInput">เบอร์โทรศัพท์</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center align-items-center g-2 ">
                                                    <div class="form-floating mt-3">
                                                        <textarea class="form-control" id="floatingTextarea2" name="address" style="height: 100px" placeholder="รายละเอียดที่อยู่" required></textarea>
                                                        <label for="floatingTextarea2">รายละเอียดที่อยู่</label>
                                                    </div>
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="floatingInput5" placeholder="เพิ่มลิ้งค์" name="url" required>
                                                        <label for="floatingInput5">เพิ่มลิ้งค์</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="formFile">รูปภาพ</label>
                                                        <input type="file" class="form-control" name="imge" id="formFile" accept="image/jpeg, image/png, image/jpg" required>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="btnsubmit"><i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;&nbsp;บันทึก</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <div class="container my-2 fs-5">
                                <form action="place.php?load=SUBMIT" method="get">
                                    <p class="form-label text-center mt-3">&nbsp;&nbsp;ค้นหาสถานที่</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-describedby="button-addon2" name="ename">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2" title="ค้นหา"><i class="fa-solid fa-magnifying-glass fa-lg"></i>&nbsp;&nbsp;</button>
                                    </div>
                                    <div class="text-start">
                                        <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>&nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด </label>
                                    </div>
                                </form>
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

                        <div class="fs-5">
                            <?php if (mysqli_num_rows($result) > 0) { ?>
                                <div class="row ">
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <div class="col-12 col-md-12 my-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row justify-content-center align-items-center g-2">
                                                        <div class="col-8">
                                                            <div class="btn-group dropend">
                                                                <button type="button" class="btn btn-light dropdown-toggle fs-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-map-location-dot fa-lg"></i>&nbsp;&nbsp;<?php echo $row['company_name']; ?>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <?php echo $row['url']; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 text-end">

                                                            <a href="edit_place.php?id=<?php echo $row['id']; ?>" class="btn btn-warning p-3"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <!-- End model -->

                                                            <a href="del_place.php?delplace=<?php echo $row["id"]; ?>" class="btn btn-danger p-3" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" title="ลบ"><i class="fa-solid fa-trash-can"></i></a>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center align-items-center g-2">
                                                        <div class="col-12 col-md-6 col-sm-12 text-center">
                                                            <?php if (isset($row["imge"]) && (strpos($row["imge"], ".png") !== false || strpos($row["imge"], ".jpeg") !== false || strpos($row["imge"], ".jpg") !== false)) { ?>

                                                                <img src="place/<?php echo $row["imge"]; ?>" class="img-fluid rounded my-2" style="max-width: 100%; height: auto;">
                                                            <?php } else { ?>
                                                                <img src="no_image.jpg" class="img-fluid rounded my-2" style="max-width: 100%; height: auto;">

                                                            <?php } ?>
                                                        </div>
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
                                            <script src="js/script.js" charset="utf-8"></script>
                                        </div>
                                    <?php } ?>
                                </div>
                        </div>
                    <?php } else {
                                echo '<div class="container text-center"><div class="card bg-dark text-light p-5 my-3">' . "ไม่มีข้อมูลลองค้นหาข้อมูลอีกครั้ง" . '</div></div>';
                            } ?>

                    </div>
                </div>
                <?php require_once '../design/footer.php'; ?>
            <?php } ?>
    </body>

    </html>