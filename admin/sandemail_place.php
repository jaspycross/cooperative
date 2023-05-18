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

    if (isset($_POST["submit"])) {
        require '../dbconnect.php';
        $email = $_POST["email"];

        $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
        $query = mysqli_num_rows($sql);
        $fetch = mysqli_fetch_assoc($sql);

        if (mysqli_num_rows($sql) <= 0) {


            echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                    title : 'แจ้งเตือน',
                    text : 'ไม่มีอีเมลในระบบ!!!',
                    icon : 'error'
                }).then(function() {
                    window.location.href = 'sandemail_place.php';
                });
            });
            </script>";
        } else if ($fetch["userlevel"] != 1) {


            echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                    title : 'แจ้งเตือน',
                    text : 'กรุณาสมัครสมาชิกก่อน!!!',
                    icon : 'warning'
                }).then(function() {
                    window.location.href = 'sandemail_place.php';
                });
            });
            </script>";
        } else {
            // generate token by binaryhexa 
            $token = bin2hex(random_bytes(50));

            //session_start ();

            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;


            require "../Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            // h-hotel account
            $mail->Username = 'nightwindytt@gmail.com';
            $mail->Password = 'wsamuotkppavqvdg';

            // send by h-hotel email
            $mail->setFrom('nightwindytt@gmail.com', 'OFFICE OF COOPERATIVE EDUCATION');
            // get email from input
            $mail->addAddress($_POST["email"]);


            // HTML body
            $mail->isHTML(true);
            $mail->Subject = $_POST["texthead"];
            $mail->CharSet = 'UTF-8'; // กำหนด charset เป็น UTF-8
            $mail->Encoding = 'base64'; // กำหนดวิธีการเข้ารหัสเป็น base64

            $body = "ชื่อสถานประกอบการ: " . $_POST["company"] . "<br>" .
                "ที่อยู่: " . $_POST["location"] . "<br>" .
                "ชื่อผู้ประสานงานของสถานประกอบการ: " . $_POST["name"] . "<br>" .
                "ตำแหน่ง: " . $_POST["position"] . "<br>" .
                "โทรศัพท์: " . $_POST["telorgan1"] . "<br>" .
                "โทรสาร: " . $_POST["telorgan2"] . "<br>" .
                "โทรศัพท์เคลื่อนที่: " . $_POST["telorgan3"] . "<br>" .
                "ลักษณะงานที่นักศึกษาจะปฏิบัติ: " . $_POST["jobstyle"] . "<br>" .
                "" . "<br>" .
                "" . "<br>" .
                "กรุณากรอกข้อมูลที่ลิงก์ด้านล่าง" . "<br>" .
                "โดยการกดไปที่ปุ่มแก้ไขข้อมูล" . "<br>" .
                "http://localhost/newprojectme/student/insertss02.php";


            // เพิ่ม Content-Type และ charset ใน Header
            $mail->addCustomHeader('Content-Type: text/html; charset=UTF-8');
            $mail->Body = $body;


            if (!$mail->send()) {

                echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                    title : 'แจ้งเตือน',
                    text : 'อีเมลไม่ถูกต้อง',
                    icon : 'error',
                    timer : 2000,
                    showConfirmButton : false
                    });
                });
                </script>";
            } else {


                echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                    title : 'ส่งอีเมลสำเร็จ',
                    text : '',
                    icon : 'success'
                }).then(function() {
                    window.location.href = 'sandemail_place.php';
                    });
                    });
                    </script>";
            }
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
                        <a class="btn w-100 p-3 text-start text-primary border-bottom rounded-0" href="sandemail_place.php" role="button"><i class="fa-solid fa-map-location-dot"></i>&nbsp;การจัดหาสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="form_file.php" role="button"><i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร</a>
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

                <?php
                if (isset($_GET['ename']) ? $name = $_GET['ename'] : $name = "");
                $i = 1;
                $sql = mysqli_query($conn, "SELECT  
                ss02.id ,
                ss02.userid_ss02,
                ss02.academicyear,
                tb_year.year,
                ss02.firstname,
                ss02.lastname,
                ss02.studentcode,
                tb_user.email,
                ss02.term,
                tb_term.term AS tbterm,
                ss02.classyear,
                ss02.status,
                ss02.status1,
                ss02.status2,
                ss02.status3,
                ss02.pak,
                ss02.pak1,
                ss02.grade,
                ss02.branchname,
                tb_branch.branch,
                ss02.department,
                department.namedepartment,
                ss02.faculty,
                ss02.address,
                ss02.telme1,
                ss02.telme2,
                ss02.email,
                ss02.firstname1,
                ss02.relevant,
                ss02.career,
                ss02.address1,
                ss02.telmom1,
                ss02.telmom2,
                ss02.telmom3,
                ss02.operative,
                ss02.me,
                ss02.organization,
                ss02.adressorgan,
                ss02.mentor,
                ss02.position,
                ss02.telorgan1,
                ss02.telorgan2,
                ss02.telorgan3,
                ss02.jobstyle,
                ss02.status_ss02 ,
                ss02.see,
                ss02.no_see,
                ss02.text_no_see,
                ss01.status_ss01 
                FROM ss02 
                LEFT JOIN ss01 ON ss02.userid_ss02 = ss01.userid_ss01 
                LEFT JOIN department ON ss02.department = department.id 
                LEFT JOIN tb_term ON ss02.term = tb_term.id_term 
                LEFT JOIN tb_year ON ss02.academicyear = tb_year.id_year
                LEFT JOIN tb_branch ON ss02.branchname = tb_branch.idbranch
                LEFT JOIN tb_user ON ss02.userid_ss02 = tb_user.id
                WHERE (ss02.operative = '/') AND
                (tb_year.year LIKE '%$name%' OR 
                ss02.firstname LIKE '%$name%' OR
                ss02.lastname LIKE '%$name%' OR
                ss02.studentcode LIKE '%$name%' OR
                tb_term.term LIKE '%$name%' OR
                tb_branch.branch LIKE '%$name%' OR
                department.namedepartment LIKE '%$name%') AND (ss02.status_ss02 != 2) 
                ORDER BY id DESC");
                ?>

                <div class="col-12 col-md-9 pb-3 pb-md-0 pb-sm-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-body">


                                <p class="text-center my-3 fs-3">เอกสารแบบฟอร์ม สสศ.02</p>

                                <form action="sandemail_place.php?load=SUBMIT" method="get">
                                    <div class="input-group my-3">
                                        <input type="text" class="form-control form-control-lg" name="ename" placeholder="รหัสนักศึกษา ชื่อ นามสกุล ปีการศึกษา ภาคการศึกษา สาขาวิชา ภาควิชา">
                                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>&nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด </label>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center table-hover fs-5 align-middle" style="width: max-content;">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสนักศึกษา</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
                                                <th>ภาคการศึกษา</th>
                                                <th>ปีการศึกษา</th>
                                                <th>สาขาวิชา</th>
                                                <th>คณะ</th>
                                                <th>ภาควิชา</th>
                                                <th>อีเมล</th>
                                                <th>4 ปี</th>
                                                <th>เทียบโอน</th>
                                                <th>อื่น ๆ</th>
                                                <!-- <th>(ใส่ข้อความ)</th> -->

                                                <th><i class="fa-solid fa-sliders"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($sql) > 0) {
                                                while ($row = mysqli_fetch_array($sql)) {
                                                    $status_ss02 = $row['status_ss02'];
                                                    $idss02 = $row['id'];
                                                    $userid_ss02 = $row['userid_ss02'];

                                            ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?> </td>
                                                        <td><?php echo $row['studentcode']; ?></td>
                                                        <td><?php echo $row['firstname']; ?></td>
                                                        <td><?php echo $row['lastname']; ?></td>
                                                        <td><?php echo $row['tbterm']; ?></td>
                                                        <td><?php echo $row['year']; ?></td>
                                                        <td><?php echo $row['branch']; ?></td>
                                                        <td><?php echo $row['faculty']; ?></td>
                                                        <td><?php echo $row['namedepartment']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td><?php echo $row['status1']; ?></td>
                                                        <td><?php echo $row['status3']; ?></td>
                                                        <!-- <td><?php echo $row['status2']; ?></td> -->
                                                      
                                                        <td>

                                                            <?php if ($row['operative'] == '/') { ?>
                                                                <!-- Button trigger modal -->
                                                                <button type="button" class="btn btn-primary w-100 " data-bs-toggle="modal" data-bs-target="#modalmail<?php echo $row['id'] ?>">
                                                                    <i class="fa-solid fa-envelope"></i> อีเมล
                                                                </button>
                                                        </td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modalmail<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalTitleId">การจัดหาสถานที่ฝึกสหกิจศึกษา</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <form class="text-start" action="" method="POST">
                                                                            <div class="form-group row">
                                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                                    <label for="email_address" class="form-label">อีเมล</label>
                                                                                    <input type="email" id="email_address" class="form-control" value="<?php echo $row['email'] ?>" name="email" required autofocus>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                                    <label for="texthead" class="form-label">หัวเรื่อง</label>
                                                                                    <input type="text" id="text" class="form-control" name="texthead" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="company" class="form-label">ชื่อสถานประกอบการ</label>
                                                                                    <input type="text" id="text" class="form-control" name="company" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="location" class="form-label">ที่อยุ่</label>
                                                                                    <input type="text" id="text" class="form-control" name="location" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="name" class="form-label">ชื่อผู้ประสานงานของสถานประกอบการ</label>
                                                                                    <input type="text" id="text" class="form-control" name="name" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="position" class="form-label">ตำแหน่ง</label>
                                                                                    <input type="text" id="text" class="form-control" name="position" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="telorgan1" class="form-label">โทรศัพท์</label>
                                                                                    <input type="number" class="form-control" name="telorgan1" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="telorgan2" class="form-label">โทรสาร</label>
                                                                                    <input type="number" class="form-control" name="telorgan2" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="telorgan3" class="form-label">โทรศัพท์เคลื่อนที่</label>
                                                                                    <input type="number" class="form-control" name="telorgan3" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                                                </div>
                                                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                                                    <label for="jobstye" class="form-label">ลักษณะงานที่นักศึกษาจะปฏิบัติ</label>
                                                                                    <input type="text" id="text" class="form-control" name="jobstyle" required>
                                                                                </div>

                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-6 offset-md-4">
                                <input class="btn btn-dark mt-3" type="submit" value="ส่ง" name="submit">
                            </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary fs-5 p-2" title="ยืนยัน"><i class="fa-solid fa-paper-plane"></i></button>
                                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">ยกเลิก</button>
                                                                    </div>
                                                                    </form>
                                                                <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                            </div>
                                                        </div>

                                                    <?php } else { ?>
                                                        <td class="fs-5" colspan="14">ไม่พบข้อมูล</td>
                                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include '../design/footer.php';
            ?>
        <?php } ?>
    </body>

    </html>