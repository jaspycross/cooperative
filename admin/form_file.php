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
    </script>";
    // header("refresh:2; url=../home.php");
    session_destroy();
    header("location: ../home.php");
} else {
?>


    <?php

    require_once '../dbconnect.php';
    if (isset($_POST['submit']) != "") {
        $name_file = $_FILES['photo']['name'];
        $size = $_FILES['photo']['size'];
        $type = $_FILES['photo']['type'];
        $temp = $_FILES['photo']['tmp_name'];
        $date_addfile = date('Y/m/d H:i:sa');
        $user_uploadfile = $_POST['user_uploadfile'];

        //   $caption1 = $_POST['caption'];
        //   $link = $_POST['link'];

        move_uploaded_file($temp, "files/" . $name_file);

        $query = $conn->query("INSERT INTO document_file (name_file, date_addfile, user_uploadfile) 
                        VALUES ('$name_file','$date_addfile', '$user_uploadfile')");
        if ($query) {
            echo "<script>
        $(document).ready(function() {
          Swal.fire( {
              title : 'อัปโหลดสำเร็จ',
              icon : 'success',
              timer : 2000,
              showConfirmButton : false
            }).then(function() {
                window.location.href = 'form_file.php';
            });
        });
      </script>";
        } else {
            echo "<script>
        $(document).ready(function() {
          Swal.fire( {
              title : 'อัปโหลดไฟล์ไม่สำเร็จ',
              icon : 'error',
              timer : 2000,
              showConfirmButton : false
            }).then(function() {
                window.location.href = 'form_file.php';
            });
        });
      </script>";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php include '../design/head.php'; ?>

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
                        <a class="btn w-100 p-3 text-start text-primary border-bottom rounded-0" href="form_file.php" role="button"><i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร</a>
                        <a class="btn w-100 p-3 text-start  border-bottom rounded-0" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>

                <?php
                $a = $_SESSION['user_tm'];
                ?>

                <div class="col-12 col-md-9 pb-3 pb-md-0 pb-sm-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="container my-3">
                                <form enctype="multipart/form-data" action="" method="post">
                                    <input class="form-control" type="hidden" name="user_uploadfile" value="<?php echo $a; ?>" readonly>
                                    <input class="form-control" type="file" name="photo" id="photo" required>
                                    <input type="submit" class="form-control btn btn-primary mt-3" value="อัปโหลด" name="submit">
                                    <p class="text-muted text-start mt-3 fs-5"><i class="fa-solid fa-ban fa-lg"></i>&nbsp;&nbsp;ห้ามใช้ชื่อไฟล์เหมือนกัน</p>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center">
                                        <thead class="table-dark fs-6">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อไฟล์เอกสาร</th>
                                                <th>ผู้อัพโหลด</th>
                                                <th>ปี/เดือน/วัน/เวลา</th>
                                                <th><i class="fa-solid fa-sliders"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM document_file ORDER BY id DESC")/*or die(mysqli_error($conn))*/;
                                            while ($row = mysqli_fetch_array($query)) {
                                                $name_file = $row['name_file'];
                                            ?>
                                                <tr>
                                                    <form method="post" action="">
                                                        <td><?php echo $order++; ?></td>
                                                        <td><?php echo $row['name_file'] ?></td>
                                                        <td><?php echo $row['user_uploadfile'] ?></td>
                                                        <td><?php echo $row['date_addfile'] ?></td>
                                                        <td>
                                                            <a href="download_file.php?filename=<?php echo $name_file; ?>" type="button" class="fa-solid fa-download btn btn-warning mt-2" title="คลิกดาวน์โหลด"></a>
                                                            <a href="del_file.php?del=<?php echo $row['id'] ?>" type="button" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" class="fa-solid fa-trash-can btn btn-danger mt-2" title="คลิกลบข้อมูล"></a>
                                                        </td>
                                                </tr>
                                                </form>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div><!-- // grid -->
                            </div>
                            <!--card-body -->
                        </div><!-- row -->
                    </div><!-- col -->
                </div>
            </div>
        </div>

        <?php
        include '../design/footer.php';
        ?>

    <?php } ?>
    </body>

    </html>