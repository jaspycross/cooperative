<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require '../dbconnect.php';

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm'] || !$_GET['update']) {
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

    <?php
    if (isset($_GET['update']) ? $id = $_GET['update'] : $id = ""); {

        $sql = "SELECT * FROM tb_teacher_admin WHERE id_tm = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['btnedit'])) {

        $prefix_tm = $_POST['prefix_tm'];
        $firstname_tm = $_POST['firstname_tm'];
        $lastname_tm = $_POST['lastname_tm'];
        $gender_tm = $_POST['gender_tm'];
        $faculty_tm = $_POST['faculty_tm'];
        $branch_tm = $_POST['branch_tm'];
        $status_tm = $_POST['status_tm'];
        $userlevel_tm = $_POST['userlevel_tm'];
        $email_tm = $_POST['email_tm'];
        // $password_tm = $_POST['password_tm'];
        // $passwordenc = md5($password_tm);

        $sql = "UPDATE tb_teacher_admin SET prefix_tm='$prefix_tm',
                        firstname_tm='$firstname_tm' , 
                        lastname_tm='$lastname_tm' ,
                        gender_tm='$gender_tm',
                        faculty_tm='$faculty_tm', 
                        branch_tm='$branch_tm',
                        status_tm='$status_tm',
                        userlevel_tm='$userlevel_tm',
                        email_tm='$email_tm' 
                        -- password_tm='$passwordenc'
                        WHERE id_tm=$id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                            title : 'บันทึกเรียบร้อย',
                            text : 'โปรดรอสักครู่..',
                            icon : 'success',
                            timer : 2000,
                            showConfirmButton : false
                            }).then(function() {
                                window.location.href = 'profile_tm.php';
                            });
                        });
                    </script>";
        } else {
            echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'แก้ไขข้อมูลไม่สำเร็จ!',
                            icon : 'error',
                            timer : 2000,
                            showConfirmButton : false
                        });
                    </script>";
        }
    }
    ?>

    <script>
        function goBack() {
            window.history.back()
        }
    </script>

    <!DOCTYPE html>
    <html lang="en">
    <?php include '../design/head.php'; ?>

    <body>

        <!-- nav -->
        <header class="bg-dark p-4 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
                    <div class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <img src="../Logo.png" width="40" height="64">&nbsp;&nbsp;
                        <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Logo"><use xlink:href="#Logo"></use></svg> -->
                    </div>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                        <li><a href="index.php" class="nav-link px-2 link-light">หน้าหลัก</a></li>
                        <li><a href="place.php" class="nav-link px-2 link-light">สถานที่ฝึกงาน</a></li>
                        <li><a href="form_file.php" class="nav-link px-2 link-light">เอกสารแบบฟอร์ม</a></li>
                        <li><a href="form_register.php" class="nav-link px-2 link-light">เพิ่มสมาชิก</a></li>
                        <li><a href="form_csv.php" class="nav-link px-2 link-light">เพิ่มสมาชิกหลายคน</a></li>
                        <li><a href="showss01.php" class="nav-link px-2 link-light">แบบฟอร์มที่ได้รับ</a></li>
                        <li><a href="profile_tm.php" class="nav-link px-2 link-secondary">โปรไฟล์</a></li>
                    </ul>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle"> -->
                            <p class="fs-6 fw-bold text-light p-2 text-center badge bg-danger text-wrap">แอดมิน</p>
                            &nbsp;&nbsp;
                            <?php echo $_SESSION['user_tm']; ?>&nbsp;&nbsp;<i class="fa-solid fa-user-gear fa-xl"></i>
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="profile_tm.php">โปรไฟล์</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

        <div class="container">
            <form action=" " method="post">
                <input type="hidden" type="number" value="<?php echo $row["id_tm"]; ?>" name="id">

                <p class="mt-5 fs-3 text-center">แก้ไขข้อมูลโปรไฟล์</p>

                <?php $id_tm = $_SESSION['userid_tm'];  ?>
                <?php $sql = "SELECT * FROM `tb_teacher_admin` WHERE `id_tm` =  $id_tm";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result)) { ?>
                        <p class="text-center text-muted">ถ้าต้องการเปลี่ยนรหัสผ่าน&nbsp;&nbsp;<a href="change_password.php?changpass=<?php echo $row1['id_tm']; ?>" class="text-decoration-none">คลิกที่นี่</a></p>
                <?php }
                } ?>

                <?php $prefix_tm = $row['prefix_tm']; ?>
                <p class="text-start mt-3 fs-5">คำนำหน้า</p>
                <select class="form-select mt-3" name="prefix_tm" required>
                    <option selected value="<?php echo $prefix_tm; ?>">
                        <?php if ($row['prefix_tm'] == "นาย") {
                            echo "นาย";
                        } else if ($row['prefix_tm'] == "นางสาว") {
                            echo "นางสาว";
                        } ?>
                    </option>
                    <option value="นาย">นาย</option>
                    <option value="นางสาว">นางสาว</option>
                </select>

                <div class="row justify-content-star mb-3">
                    <div class="col">
                        <p class="text-start mt-3 fs-5">ชื่อ</p>
                        <input class="form-control" name="firstname_tm" type="text" value="<?php echo $row['firstname_tm']; ?>">
                    </div>
                    <div class="col">
                        <p class="text-start mt-3 fs-5">นามสกุล</p>
                        <input class="form-control" name="lastname_tm" type="text" value="<?php echo $row['lastname_tm']; ?>">
                    </div>
                </div>

                <!-- select แบบที่ถูกต้อง -->
                <?php $gender_tm = $row['gender_tm']; ?>
                <p class="text-start mt-3 fs-5">เพศ </p>
                <select class="form-select mt-3" name="gender_tm">
                    <option selected value="<?php echo $gender_tm; ?>">
                        <?php if ($row['gender_tm'] == "1") {
                            echo "ชาย";
                        } else if ($row['gender_tm'] == "2") {
                            echo "หญิง";
                        } ?>
                    </option>
                    <option value="1">ชาย</option>
                    <option value="2">หญิง</option>
                </select>
                <!-- select แบบที่ถูกต้อง -->

                <div class="row justify-content-star mb-3">
                    <div class="col">
                        <p class="text-start mt-3 fs-5">คณะ</p>
                        <input class="form-control" name="faculty_tm" type="text" value="<?php echo $row['faculty_tm']; ?>" readonly>
                    </div>
                    <?php $branch_tm = $row['branch_tm']; ?>
                    <div class="col">
                        <p class="text-start mt-3 fs-5">สาขาวิชา</p>
                        <select class="form-select" name="branch_tm">
                            <option selected value="<?php echo $branch_tm; ?>">
                                <?php if ($row["branch_tm"] == "1") {
                                    echo "การเงินและนวัตกรรมทางการเงิน";
                                } else if ($row['branch_tm'] == "2") {
                                    echo "การจัดการธุรกิจสมัยใหม่";
                                } else if ($row['branch_tm'] == "3") {
                                    echo "การตลาด";
                                } else if ($row['branch_tm'] == "4") {
                                    echo "การบัญชี";
                                } else if ($row['branch_tm'] == "5") {
                                    echo "การประเมินราคาทรัพย์สิน";
                                } else if ($row['branch_tm'] == "6") {
                                    echo "การสื่อสารธุรกิจระหว่างประเทศ";
                                } else if ($row['branch_tm'] == "7") {
                                    echo "เทคโนโลยีสารสนเทศและธุรกิจดิจิทัล";
                                }
                                ?></option>
                            <option value="1">การเงินและนวัตกรรมทางการเงิน</option>
                            <option value="2">การจัดการธุรกิจสมัยใหม่</option>
                            <option value="3">การตลาด</option>
                            <option value="4">การบัญชี</option>
                            <option value="5">การประเมินราคาทรัพย์สิน</option>
                            <option value="6">การสื่อสารธุรกิจระหว่างประเทศ</option>
                            <option value="7">เทคโนโลยีสารสนเทศและธุรกิจดิจิทัล</option>
                        </select>
                    </div>
                </div>

                <?php $status_tm = $row['status_tm']; ?>
                <p class="text-start mt-3 fs-5">สถานะ</p>
                <select class="form-select my-3" name="status_tm">
                    <option selected value="<?php echo $status_tm; ?>">
                        <?php if ($row['status_tm'] == "1") {
                            echo "นักศึกษาฝึกงาน";
                        } else if ($row["status_tm"] == "2") {
                            echo "อาจารย์ที่ปรึกษา";
                        } else if ($row["status_tm"] == "3") {
                            echo "พี่เลี้ยงของนักศึกษาสหกิจ";
                        } else if ($row["status_tm"] == "4") {
                            echo "อาจารย์ประสานงาน";
                        } ?>
                    </option>
                    <option value="1" disabled>นักศึกษาฝึกงาน</option>
                    <option value="2">อาจารย์ที่ปรึกษา</option>
                    <option value="3" disabled>พี่เลี้ยงของนักศึกษาสหกิจ</option>
                    <option value="4">อาจารย์ประสานงาน</option>
                </select>

                <?php $userlevel_tm = $row['userlevel_tm']; ?>
                <p class="text-start fs-5">ระดับของสมาชิก</p>
                <select class="form-select mt-3" name="userlevel_tm">
                    <option selected value="<?php echo $userlevel_tm; ?>">
                        <?php if ($row["userlevel_tm"] == "4") {
                            echo "อาจารย์ประสานงาน";
                        } else if ($row["userlevel_tm"] == "3") {
                            echo "พี่เลี้ยงของนักศึกษาสหกิจ";
                        } else if ($row["userlevel_tm"] == "2") {
                            echo "อาจารย์ที่ปรึกษา";
                        } else if ($row["userlevel_tm"] == "1") {
                            echo "นักศึกษาฝึกงาน";
                        } ?>
                    </option>
                    <option value="1" disabled>นักศึกษาฝึกงาน</option>
                    <option value="2">อาจารย์ที่ปรึกษา</option>
                    <option value="3" disabled>พี่เลี้ยงของนักศึกษาสหกิจ</option>
                    <option value="4">อาจารย์ประสานงาน</option>
                </select>

                <p class="text-start mt-3 fs-5">อีเมล</p>
                <input class="form-control" name="email_tm" type="email" value="<?php echo $row['email_tm']; ?>">

                <div class="row mt-3 mb-4">
                    <div class="col d-grid">
                        <input class="btn btn-success mt-3 btn-lg" name="btnedit" type="submit" value="บันทึก">
                    </div>
                    <div class="col d-grid">
                        <input type="button" class="btn btn-danger mt-3 btn-lg" onclick="goBack()" value="ปิด">
                    </div>
                </div>
            </form>
        </div>


        <?php include '../design/footer.php'; ?>
    <?php } ?>
    </body>

    </html>