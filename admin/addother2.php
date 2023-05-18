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
    session_destroy();
    header("location: ../home.php");
} else {

    if (isset($_POST['btnsubmit'])) {

        $branch = $_POST['branch'];
        $iddepartment = $_POST['iddepartment'];
        $status_branch = $_POST['status_branch'];

        $user_check = "SELECT branch FROM tb_branch WHERE branch = '$branch' LIMIT 1";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $branch == $user['branch'];
            echo "<script>
            $(document).ready(function() {
              Swal.fire( {
                title : 'มีสาขาวิชาซ้ำไม่สามารถบันทึกได้',
                icon : 'info'
                }).then(function() {
                    window.location.href = 'addother2.php';
                });
              });
            </script>";
        } else {

            $query  = "INSERT INTO tb_branch (branch, iddepartment, status_branch) VALUES ('$branch', '$iddepartment', '$status_branch')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>
                            $(document).ready(function() {
                                Swal.fire( {
                                    title : 'บันทึกข้อมูลสำเร็จ',
                                    icon : 'success',
                                    timer : 2000,
                                    showConfirmButton : false
                                }).then(function() {
                                    window.location.href = 'addother2.php';
                                });
                            });
                            </script>";
            } else {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                            icon : 'warning',
                            timer : 2000,
                            showConfirmButton : false
                        });
                    });
                    </script>";
            }
        }
    }

    if (isset($_POST['btnedit'])) {

        $idbranch = $_POST['idbranch'];
        $branch = $_POST['branch'];
        $iddepartment = $_POST['iddepartment'];
        $status_branch = $_POST['status_branch'];

        $query  = "UPDATE tb_branch SET branch='$branch', iddepartment='$iddepartment', status_branch='$status_branch' WHERE idbranch=$idbranch";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>
                            $(document).ready(function() {
                                Swal.fire( {
                                    title : 'บันทึกข้อมูลสำเร็จ',
                                    icon : 'success',
                                    timer : 2000,
                                    showConfirmButton : false
                                }).then(function() {
                                    window.location.href = 'addother2.php';
                                });
                            });
                            </script>";
        } else {
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                            icon : 'warning',
                            timer : 2000,
                            showConfirmButton : false
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
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="form_file.php" role="button"><i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0 text-primary" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>



                <div class="col-12 col-md-9 pb-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="fs-4 mt-3 text-center">สาขาวิชา</div> -->

                                <div class="d-flex justify-content-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalId">
                                        <i class="fa-solid fa-plus"></i>&nbsp;เพิ่มสาขาวิชา
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitleId">เพิ่มสาขาวิชา</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="status_branch" value="1">

                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" name="iddepartment" required>
                                                                <option selected value="">-- เลือก --</option>
                                                                <?php
                                                                $query = "SELECT * FROM department"; // เรียกข้อมูล id_term และ term จากฐานข้อมูล
                                                                $result = mysqli_query($conn, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $iddepartment = $row['id'];
                                                                    $namedepartment = $row['namedepartment'];
                                                                    echo "<option value='$iddepartment'>$namedepartment</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="floatingSelect">ภาควิชา</label>
                                                        </div>

                                                        <div class="form-floating my-3">
                                                            <input type="text" class="form-control" placeholder=" " name="branch" id="floatingInput" required>
                                                            <label for="floatingInput">สาขาวิชา</label>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success" name="btnsubmit" type="submit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">ปิด</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php $query = "SELECT * FROM tb_branch"; // เรียกข้อมูล id_term และ term จากฐานข้อมูล
                                $result = mysqli_query($conn, $query);
                                ?>

                                <div class="table-responsive mt-3">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                        <table class="table table-light table-bordered text-center">
                                            <thead class="table-dark ">
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">สาขาวิชา</th>
                                                    <th scope="col">สถานะ</th>
                                                    <th scope="col"><i class="fa-solid fa-sliders"></i></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $i = 1;
                                                while ($row = mysqli_fetch_array($result)) {

                                                ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $row['branch'] ?></td>
                                                        <td><?php
                                                            if ($row['status_branch'] == 0) {
                                                                echo '<button type="button" class="btn btn-outline-danger">ยกเลิกการใช้งาน</button>';
                                                            } elseif ($row['status_branch'] == 1) {
                                                                echo '<button type="button" class="btn btn-outline-success">ปกติ</button>';
                                                            } else {
                                                                echo '<button type="button" class="btn btn-outline-dark">' . 'ไม่พบข้อมูล' . '</button>';
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalId1<?php echo $row['idbranch']; ?>">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modalId1<?php echo $row['idbranch']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalTitleId">แก้ไขสาขาวิชา</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container-fluid">
                                                                                <form action="" method="post">

                                                                                    <div class="form-floating mb-3">
                                                                                        <select class="form-select" id="floatingSelect" name="status_branch" aria-label="Floating label select example">
                                                                                            <option value="0" <?php echo $row['status_branch'] == "0" ? "selected" : ""; ?>>ยกเลิกการใช้งาน</option>
                                                                                            <option value="1" <?php echo $row['status_branch'] == "1" ? "selected" : ""; ?>>ปกติ</option>
                                                                                        </select>
                                                                                        <label for="floatingSelect">สถานะ</label>
                                                                                    </div>

                                                                                    <div class="form-floating">
                                                                                        <select class="form-select" id="floatingSelect" name="iddepartment" aria-label="Floating label select example">
                                                                                            <option value="1" <?php echo $row['iddepartment'] == "1" ? "selected" : ""; ?>>ภาควิชาการบัญชีและการเงิน</option>
                                                                                            <option value="2" <?php echo $row['iddepartment'] == "2" ? "selected" : ""; ?>>ภาควิชาการตลาดและการจัดการ</option>
                                                                                        </select>
                                                                                        <label for="floatingSelect">ภาควิชา</label>
                                                                                    </div>

                                                                                    <input type="hidden" name="idbranch" value="<?php echo $row["idbranch"]; ?>">
                                                                                    <div class="form-floating my-3">
                                                                                        <input type="text" class="form-control" name="branch" placeholder=" " value="<?php echo $row['branch']; ?>" id="floatingInput" required>
                                                                                        <label for="floatingInput">สาขาวิชา</label>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-success" name="btnedit" type="submit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">ปิด</button>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <a href="del_addother2.php?del=<?php echo $row["idbranch"]; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" title="ลบ"><i class="fa-solid fa-trash-can" name="del"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                </div>
                            <?php
                                    } else {
                                        echo "ไม่มีข้อมูล";
                                    }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once '../design/footer.php'; ?>
    <?php } ?>
    </body>

    </html>