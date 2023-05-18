<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require '../dbconnect.php';

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
    session_unset();
    session_destroy();
    header("location: ../home.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="en">
    <?php require_once "../design/head.php"; ?>

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
                        <!-- <li><a href="doument.php" class="nav-link px-2 link-secondary"><i class="fa-regular fa-folder-open"></i>&nbsp;เอกสารแบบฟอร์ม</a></li>
                        <li><a href="calendar/index.php" class="nav-link px-2 link-light"><i class="fa-solid fa-calendar-days"></i>&nbsp;ปฏิทินนัดหมาย</a></li> -->
                    </ul>

                    <div class="text-end">
                        <p class="fs-6 text-light p-2 mb-2 justify-content-center badge bg-danger text-wrap">ผู้ดูแลระบบ</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

        <div class="container-fluid">
            <div class="row justify-content-start ">
                <div class="col-12 col-md-3 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="accordion accordion-flush border" id="accordionPanelsStayOpenExample">
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="profile_tm.php" role="button"><i class="fa-solid fa-user-gear"></i>&nbsp;ข้อมูลส่วนตัว</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0 text-primary" href="work_history.php" role="button"><i class="fa-solid fa-business-time"></i>&nbsp;ประวัติการทำงาน</a>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
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
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>

                <div class="col-12 col-md-9 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0" style="background-color: #f2f2f2;">
                    <div class="my-3 my-md-3 my-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-body">



                                <?php

                                // เช็คว่ามีค่า ename ที่รับเข้ามาหรือไม่ ถ้าไม่มีกำหนดให้เป็นค่าว่าง
                                $name = isset($_GET['ename']) ? $_GET['ename'] : "";

                                $sql = "SELECT 
                                ss0902.id,
                                ss0902.userid_ss0902,
                                tb_user.student_id,
                                tb_user.prefix,
                                tb_user.firstname,
                                tb_user.lastname,
                                tb_user.faculty,
                                tb_user.year,
                                tb_year.year AS nameyear,
                                tb_user.term,
                                ss0902.ss09_id_tm5,
                                tb_teacher_admin_tm5.prefix_tm AS prefix_tm5,
                                tb_prefix5.nameprefix AS nameprefix5,
                                tb_teacher_admin_tm5.firstname_tm AS firstname_tm5,
                                tb_teacher_admin_tm5.lastname_tm AS lastname_tm5,
                                tb_teacher_admin_tm5.faculty_tm AS faculty_tm5,
                                tb_teacher_admin_tm5.branch_tm AS branch_tm5,
                                tb_branch5.branch AS branch5,
                                tb_teacher_admin_tm5.userlevel_tm AS userlevel_tm5,
                                ss0902.ss09_id_tm,
                                tb_teacher_admin_tm.prefix_tm,
                                tb_prefix.nameprefix,
                                tb_teacher_admin_tm.firstname_tm,
                                tb_teacher_admin_tm.lastname_tm,
                                tb_teacher_admin_tm.faculty_tm,
                                tb_teacher_admin_tm.branch_tm,
                                tb_branch.branch,
                                tb_teacher_admin_tm.userlevel_tm,
                                ss0902.ss09_id_m,
                                tb_mentor.prefix_m,
                                tb_prefix_m.nameprefix AS nameprefix_m,
                                tb_mentor.firstname_m,
                                tb_mentor.lastname_m,
                                tb_mentor.company_name,
                                tb_mentor.userlevel_m,
                                tb_mentor.position,
                                tb_year.id_year
                                FROM ss0902 
                                LEFT JOIN tb_teacher_admin AS tb_teacher_admin_tm5 ON ss0902.ss09_id_tm5 = tb_teacher_admin_tm5.id_tm
                                LEFT JOIN tb_teacher_admin AS tb_teacher_admin_tm ON ss0902.ss09_id_tm = tb_teacher_admin_tm.id_tm
                                LEFT JOIN tb_user ON ss0902.userid_ss0902 = tb_user.id
                                LEFT JOIN tb_year ON tb_user.year = tb_year.id_year
                                LEFT JOIN tb_branch ON tb_teacher_admin_tm.branch_tm = tb_branch.idbranch
                                LEFT JOIN tb_branch AS tb_branch5 ON tb_teacher_admin_tm5.branch_tm = tb_branch5.idbranch
                                LEFT JOIN tb_prefix ON tb_teacher_admin_tm.prefix_tm = tb_prefix.id
                                LEFT JOIN tb_prefix AS tb_prefix5 ON tb_teacher_admin_tm5.prefix_tm = tb_prefix5.id
                                LEFT JOIN tb_mentor ON ss0902.ss09_id_m = tb_mentor.id_m
                                LEFT JOIN tb_prefix AS tb_prefix_m ON tb_mentor.prefix_m = tb_prefix_m.id  
                                WHERE tb_year.year LIKE '%$name%' ORDER BY id ASC ";
                                $qury = mysqli_query($conn, $sql);
                                $qury2 = mysqli_query($conn, $sql);
                                $qury3 = mysqli_query($conn, $sql);
                                ?>

                                <!-- เพิ่มปุ่ม "ค้นหา 2566" ที่คลิกจะค้นหาและแสดงข้อมูล "2566" -->
                                <div class="container text-center">
                                    <div class="row row-cols-5">
                                        <div class="col">
                                            <a class="btn btn-primary w-100" href="work_history.php" role="button"><i class="fa-regular fa-calendar"></i> ทั้งหมด</a>
                                        </div>
                                        <div class="col">
                                            <form action="work_history.php?load=SUBMIT" method="get">
                                                <input type="hidden" name="ename" value="2565">
                                                <button class="btn btn-primary fs-5" type="submit">ปีการศึกษา 2565</button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <form action="work_history.php?load=SUBMIT" method="get">
                                                <input type="hidden" name="ename" value="2566">
                                                <button class="btn btn-primary fs-5" type="submit">ปีการศึกษา 2566</button>
                                            </form>
                                        </div>
                                        <!-- <div class="col">
                                        <form action="work_history.php?load=SUBMIT" method="get">
                                            <input type="hidden" name="ename" value="2567">
                                            <button class="btn btn-primary" type="submit">ปีการศึกษา 2567</button>
                                        </form>
                                    </div> -->
                                    </div>
                                </div>

                                <div class="fs-5 my-3">อาจารย์ประสานงาน</div>
                                <div class="table-responsive mb-3 align-middle">
                                    <table class="table fs-5">
                                        <thead class="table-dark">
                                            <tr style="text-align: center;">
                                                <th>ลำดับ</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>คณะ</th>
                                                <th>สาขา</th>
                                                <th>ปีการศึกษา</th>
                                                <th>ภาคการศึกษา</th>
                                                <th>สถานะ</th>
                                                <th>นักศึกษาในการดูแล</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;

                                            if (mysqli_num_rows($qury) > 0) {
                                                while ($row = mysqli_fetch_array($qury)) {
                                            ?>
                                                    <tr class="" style="text-align: center;">
                                                        <?php if ($i == 1) { ?>
                                                            <td><?php echo $i++  ?></td>

                                                            <td><?php echo $row['nameprefix5'] . "" . $row['firstname_tm5'] . "  " . $row['lastname_tm5'] ?></td>

                                                            <td><?php echo $row['faculty_tm5']  ?></td>
                                                            <td><?php echo $row['branch5']  ?></td>
                                                            <td><?php echo $row['nameyear']  ?></td>
                                                            <td><?php echo $row['term']  ?></td>
                                                            <td><?php if ($row['userlevel_tm5'] == 1) {
                                                                    echo "นักศึกษาสหกิจ";
                                                                } elseif ($row['userlevel_tm5'] == 2) {
                                                                    echo "อาจารย์ปรึกษา";
                                                                } elseif ($row['userlevel_tm5'] == 3) {
                                                                    echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                                } elseif ($row['userlevel_tm5'] == 4) {
                                                                    echo "อาจารย์ประสานงาน";
                                                                } elseif ($row['userlevel_tm5'] == 5) {
                                                                    echo "ผู้ดูแลระบบ";
                                                                }  ?></td>

                                                        <?php } else { ?>
                                                            <td colspan="7"></td>
                                                        <?php } ?>
                                                        <td colspan="7">
                                                           <?php
                                                             $student_id = $row['student_id'];
                                                            $formatted_student_id = substr($student_id, 0, 11) . '-' . substr($student_id, 11);
                                                            echo $formatted_student_id . '<br>' . $row['firstname'] . ' ' . $row['lastname'];
                                                            ?>
                                                         </td>
                                                    </tr>
                                        </tbody>
                                    <?php } ?>
                                    </table>
                                </div>
                            <?php } else {
                                                echo '<td class="fs-5 text-center" colspan="12">ไม่พบข้อมูล</td>';
                                            } ?>


                            <div class="fs-5 mb-3">อาจารย์ที่ปรึกษา</div>
                            <div class="table-responsive align-middle">
                                <table class="table fs-5">
                                    <thead class="table-dark">
                                        <tr style="text-align: center;">
                                            <th>ลำดับ</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>คณะ</th>
                                            <th>สาขา</th>
                                            <th>ปีการศึกษา</th>
                                            <th>ภาคการศึกษา</th>
                                            <th>สถานะ</th>
                                            <th>นักศึกษาในการดูแล</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        $p = 1;
                                        if (mysqli_num_rows($qury2) > 0) {
                                            while ($row = mysqli_fetch_array($qury2)) {
                                        ?>
                                                <tr style="text-align: center;">
                                                    <?php if ($p == 1) { ?>
                                                        <td><?php echo $p++  ?></td>
                                                        <td><?php echo $row['nameprefix'] . "" . $row['firstname_tm'] . "  " . $row['lastname_tm'] ?></td>
                                                        <td><?php echo $row['faculty_tm']  ?></td>
                                                        <td><?php echo $row['branch']  ?></td>
                                                        <td><?php echo $row['nameyear']  ?></td>
                                                        <td><?php echo $row['term']  ?></td>
                                                        <td><?php if ($row['userlevel_tm'] == 1) {
                                                                echo "นักศึกษาสหกิจ";
                                                            } elseif ($row['userlevel_tm'] == 2) {
                                                                echo "อาจารย์ปรึกษา";
                                                            } elseif ($row['userlevel_tm'] == 3) {
                                                                echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                            } elseif ($row['userlevel_tm'] == 4) {
                                                                echo "อาจารย์ประสานงาน";
                                                            } elseif ($row['userlevel_tm'] == 5) {
                                                                echo "ผู้ดูแลระบบ";
                                                            }  ?></td>
                                                    <?php } else { ?>
                                                        <td colspan="7"></td>
                                                    <?php } ?>

                                                    <td colspan="7">
                                                           <?php
                                                             $student_id = $row['student_id'];
                                                            $formatted_student_id = substr($student_id, 0, 11) . '-' . substr($student_id, 11);
                                                            echo $formatted_student_id . '<br>' . $row['firstname'] . ' ' . $row['lastname'];
                                                            ?>
                                                         </td>
                                                </tr>
                                    </tbody>
                                <?php } ?>
                                </table>
                            </div>

                        <?php } else { ?>
                            <td class="fs-5 text-center" colspan="12">ไม่พบข้อมูล</td>
                        <?php } ?>


                        <div class="fs-5 my-3">พี่เลี้ยงนักศึกษาสหกิจ</div>
                        <div class="table-responsive mb-3 align-middle">
                            <table class="table fs-5">
                                <thead class="table-dark">
                                    <tr style="text-align: center;">
                                        <th>ลำดับ</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>สถานที่ทำงาน</th>
                                        <th>ตำแหน่ง</th>
                                        <th>ปีการศึกษา</th>
                                        <th>ภาคการศึกษา</th>
                                        <th>สถานะ</th>
                                        <th>นักศึกษาในการดูแล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;

                                    if (mysqli_num_rows($qury3) > 0) {
                                        while ($row = mysqli_fetch_array($qury3)) {
                                    ?>
                                            <tr class="" style="text-align: center;">
                                                <?php if ($i == 1) { ?>
                                                    <td><?php echo $i++  ?></td>

                                                    <td><?php echo $row['nameprefix_m'] . "" . $row['firstname_m'] . "  " . $row['lastname_m'] ?></td>

                                                    <td><?php echo $row['company_name']  ?></td>
                                                    <td><?php echo $row['position']  ?></td>
                                                    <td><?php echo $row['nameyear']  ?></td>
                                                    <td><?php echo $row['term']  ?></td>
                                                    <td><?php if ($row['userlevel_m'] == 1) {
                                                            echo "นักศึกษาสหกิจ";
                                                        } elseif ($row['userlevel_m'] == 2) {
                                                            echo "อาจารย์ปรึกษา";
                                                        } elseif ($row['userlevel_m'] == 3) {
                                                            echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                        } elseif ($row['userlevel_m'] == 4) {
                                                            echo "อาจารย์ประสานงาน";
                                                        } elseif ($row['userlevel_m'] == 5) {
                                                            echo "ผู้ดูแลระบบ";
                                                        }  ?></td>

                                                <?php } else { ?>
                                                    <td colspan="7"></td>
                                                <?php } ?>
                                                        <td colspan="7">
                                                           <?php
                                                             $student_id = $row['student_id'];
                                                            $formatted_student_id = substr($student_id, 0, 11) . '-' . substr($student_id, 11);
                                                            echo $formatted_student_id . '<br>' . $row['firstname'] . ' ' . $row['lastname'];
                                                            ?>
                                                         </td>
                                            </tr>
                                </tbody>
                            <?php } ?>
                            </table>
                        </div>


                    <?php } else {
                                        echo '<td class="fs-5 text-center" colspan="12">ไม่พบข้อมูล</td>';
                                    } ?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php require_once "../design/footer.php"; ?>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    </body>

    </html>