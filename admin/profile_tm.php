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

    if (isset($_POST['btnedit'])) {

        $id = $_POST['id_tm'];
        $prefix_tm = $_POST['prefix_tm'];
        $firstname_tm = $_POST['firstname_tm'];
        $lastname_tm = $_POST['lastname_tm'];
        $gender_tm = $_POST['gender_tm'];
        $faculty_tm = $_POST['faculty_tm'];
        $branch_tm = $_POST['branch_tm'];
        $status_tm = $_POST['status_tm'];
        $userlevel_tm = $_POST['userlevel_tm'];
        $email_tm = $_POST['email_tm'];

        // check if a new image was uploaded
        if (!empty($_FILES['imge']['name'])) {
            $imge = $_FILES['imge'];
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $imge['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'profile/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($imge['size'] > 0 && $imge['error'] == 0) {
                    // delete the old image if it exists
                    $sql = "SELECT imge FROM tb_teacher_admin WHERE id_tm = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'profile/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        if (is_file($oldFilePath)) { // เพิ่มเงื่อนไขนี้
                            unlink($oldFilePath);
                        }
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);

                    $sql = "UPDATE tb_teacher_admin SET imge = '$fileNew',
                        prefix_tm='$prefix_tm',
                        firstname_tm='$firstname_tm' , 
                        lastname_tm='$lastname_tm' ,
                        gender_tm='$gender_tm',
                        faculty_tm='$faculty_tm', 
                        branch_tm='$branch_tm',
                        status_tm='$status_tm',
                        userlevel_tm='$userlevel_tm',
                        email_tm='$email_tm' 
                        WHERE id_tm=$id";
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
                window.location.href = 'profile_tm.php';
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
            $sql = "UPDATE tb_teacher_admin 
            SET prefix_tm='$prefix_tm',
            firstname_tm='$firstname_tm', 
            lastname_tm='$lastname_tm' ,
            gender_tm='$gender_tm',
            faculty_tm='$faculty_tm', 
            branch_tm='$branch_tm',
            status_tm='$status_tm',
            userlevel_tm='$userlevel_tm',
            email_tm='$email_tm' 
            WHERE id_tm=$id";
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
                    window.location.href = 'profile_tm.php';
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

    if (isset($_POST['btndelimage'])) {
        $id = $_POST['id_tm'];
        $query = "SELECT imge FROM tb_teacher_admin WHERE id_tm = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $imageFilePath = 'profile/' . $row["imge"];
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // ลบไฟล์รูปภาพ
        }

        $query = "UPDATE tb_teacher_admin SET imge='' WHERE id_tm='$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'ลบรูปภาพสำเร็จ',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = 'profile_tm.php';
                    });
                });
                </script>";
        } else {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: 'มีปัญหาในการลบข้อมูล ลองใหม่อีกครั้ง',
                        icon: 'warning',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
                </script>";
        }
    }

    if (isset($_POST['btnpass'])) {
        $id = $_POST['id_tm'];
        $password_tm = $_POST['password_tm'];
        $passwordenc = md5($password_tm);

        if (!empty($_POST['password_tm'])) {
            $sql = "UPDATE tb_teacher_admin SET password_tm = '$passwordenc' WHERE id_tm = '$id'";
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
                    window.location.href = 'profile_tm.php';
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
        } else {
            // show error message if password field is empty
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'กรุณากรอกข้อมูลรหัสผ่าน',
                icon : 'warning'
            }).then(function() {
                window.location.href = 'profile_tm.php';
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
            <div class="row justify-content-start ">
                <div class="col-12 col-md-3 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="accordion accordion-flush border" id="accordionPanelsStayOpenExample">
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0 text-primary" href="profile_tm.php" role="button"><i class="fa-solid fa-user-gear"></i>&nbsp;ข้อมูลส่วนตัว</a>
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
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                    </ul>
                </div>

                <?php
                $result = mysqli_query($conn, "SELECT * FROM tb_teacher_admin WHERE id_tm = '" . $_SESSION['userid_tm'] . "' ");
                if (mysqli_num_rows($result) > 0) {
                ?>

                    <div class="col-12 col-md-9 pb-3 g-0" style="background-color: #f2f2f2;">
                        <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                            <div class="card">
                                <div class="card-header bg-primary fs-3">
                                    <div class="row justify-content-center align-items-center g-2">
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="col-12  text-light">
                                                ข้อมูลส่วนตัว
                                            </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row justify-content-center align-items-center g-2">
                                            <?php if (isset($row["imge"]) && (strpos($row["imge"], ".png") !== false || strpos($row["imge"], ".jpeg") !== false || strpos($row["imge"], ".jpg") !== false)) { ?>
                                                <div class="row align-items-center">
                                                    <div class="col text-end mb-2">
                                                        <button type="submit" class="btn btn-sm btn-danger" name="btndelimage" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')"><i class="fa-solid fa-trash-can"></i>&nbsp;ลบรูปภาพ</button>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <span></span>
                                            <?php } ?>

                                            <?php
                                            $imageFileName = $row["imge"];
                                            $imageFilePath = 'profile/' . $imageFileName;

                                            if (!empty($imageFileName) && file_exists($imageFilePath)) { ?>
                                                <div class="col-12 text-center">
                                                    <img src="<?= $imageFilePath ?>" class="img-fluid rounded" style="max-width: 400px; max-height: 400px;">
                                                </div>
                                            <?php } else { ?>
                                                <img src="no_image.jpg" class="img-fluid rounded" style="max-width: 400px; max-height: 400px;">
                                            <?php } ?>

                                            <input type="hidden" name="id_tm" value="<?php echo $row['id_tm']; ?>">
                                            <div class="input-group my-3">
                                                <label class="input-group-text" for="inputGroupFile01"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                                <input type="file" class="form-control" id="inputGroupFile01" name="imge" accept="image/jpeg, image/png, image/jpg" value="<?php echo $imageFileName; ?>">
                                            </div>

                                            <?php $prefix_tm = $row['prefix_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">คำนำหน้า</div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="prefix_tm" required>
                                                        <?php
                                                        $tb_prefix = mysqli_query($conn, "SELECT * FROM tb_prefix");
                                                        while ($table2_row = mysqli_fetch_assoc($tb_prefix)) {
                                                            $selected = ($table2_row['id'] == $prefix_tm) ? 'selected' : ''; ?>
                                                            <option value="<?php echo $table2_row['id']; ?>" <?php echo $selected; ?>><?php echo $table2_row['nameprefix']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php $firstname_tm = $row['firstname_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">ชื่อ</div>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" type="text" name="firstname_tm" value="<?php echo $firstname_tm; ?>">
                                                </div>
                                            </div>

                                            <?php $lastname_tm = $row['lastname_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">นามสกุล</div>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" type="text" name="lastname_tm" value="<?php echo $lastname_tm; ?>">
                                                </div>
                                            </div>

                                            <?php $gender_tm = $row['gender_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">เพศ</div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="gender_tm">
                                                        <option value="1" <?php echo $gender_tm == "1" ? "selected" : ""; ?>>ชาย</option>
                                                        <option value="2" <?php echo $gender_tm == "2" ? "selected" : ""; ?>>หญิง</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">คณะ</div>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" name="faculty_tm" type="text" value="<?php echo $row['faculty_tm']; ?>" readonly>
                                                </div>
                                            </div>

                                            <?php $branch_tm = $row['branch_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">สาขาวิชา</div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="branch_tm">
                                                        <?php
                                                        $tbbranch = $row['branch_tm'];
                                                        $tb_branch = mysqli_query($conn, "SELECT * FROM tb_branch");
                                                        while ($table2_row = mysqli_fetch_assoc($tb_branch)) {
                                                            $selected = ($table2_row['idbranch'] == $tbbranch) ? 'selected' : ''; ?>
                                                            <option value="<?php echo $table2_row['idbranch']; ?>" <?php echo $selected; ?>><?php echo $table2_row['branch']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php $status_tm = $row['status_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">สถานะ</div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="status_tm">
                                                        <option value="5" <?php echo $status_tm == "5" ? "selected" : ""; ?>>ผู้ดูแลระบบ</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <?php $userlevel_tm = $row['userlevel_tm']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">ระดับของสมาชิก</div>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="userlevel_tm">
                                                  
                                                        <option value="5" <?php echo $userlevel_tm == "5" ? "selected" : ""; ?>>ผู้ดูแลระบบ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">อีเมล</div>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" name="email_tm" type="email" value="<?php echo $row['email_tm']; ?>">
                                                </div>
                                            </div>

                                            <!-- <?php $token1 = $row['token1']; ?>
                                            <div class="row justify-content-center align-items-center my-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4"><i class="fa-brands fa-line text-success fa-lg"></i>&nbsp;เพิ่มโทเคน</div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="token1" value="<?php echo $token1; ?>" aria-describedby="button-addon3">
                                                        <button class="btn btn-success" type="submit" name="btntoken" id="button-addon3"><i class="fa-regular fa-floppy-disk"></i></button>
                                                    </div>
                                                </div>
                                            </div> -->


                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-12 col-md-6">
                                                    <div class="fs-4">รหัสผ่าน</div>
                                                </div>
                                                <div class="col-12 col-md-1 col-sm-1">
                                                    <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                                                </div>
                                                <div class="col-12 col-md-5 col-sm-11">
                                                    <div class="input-group">
                                                        <input type="password" id="password" class="form-control" name="password_tm" minlength="5" maxlength="20" aria-describedby="button-addon2">
                                                        <button class="btn btn-dark" type="submit" id="button-addon2" name="btnpass"><i class="fa-regular fa-floppy-disk"></i></button>
                                                    </div>
                                                </div>
                                                <script>
                                                    const toggle = document.getElementById('togglePassword');
                                                    const password = document.getElementById('password');

                                                    toggle.addEventListener('click', function() {
                                                        if (password.type === "password") {
                                                            password.type = 'text';
                                                        } else {
                                                            password.type = 'password';
                                                        }
                                                        this.classList.toggle('fa-eye');
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer text-end bg-primary">
                                    <button class="btn btn-light" type="submit" name="btnedit"><i class="fa-regular fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                </div>
                                </form>
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

        <?php require_once '../design/footer.php'; ?>
    <?php } ?>
    </body>

    </html>