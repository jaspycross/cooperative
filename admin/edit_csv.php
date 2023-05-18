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

    (isset($_GET['edituser']) ? $id = $_GET['edituser'] : $id = "");




    if (isset($_POST['btnedit'])) {
        $id = $_POST['id'];
        $year = $_POST['year'];
        $term = $_POST['term'];
        $student_id = $_POST['student_id'];
        $prefix = $_POST['prefix'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $faculty = $_POST['faculty'];
        $branch = $_POST['branch'];
        $status = $_POST['status'];
        $userlevel = $_POST['userlevel'];

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
                    $sql = "SELECT imge FROM tb_user WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'profile/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);


                    $sql = "UPDATE tb_user SET 
                        imge = '$fileNew',
                        year='$year',
                        term='$term',
                        student_id='$student_id',
                        prefix='$prefix',
                        firstname='$firstname' , 
                        lastname='$lastname' ,
                        email='$email' ,
                        gender='$gender',
                        faculty='$faculty', 
                        branch='$branch',
                        status='$status',
                        userlevel='$userlevel'
                        WHERE id=$id";

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
                                window.location.href = 'form_csv.php';
                            });
                        });
                    </script>";
                    } else {
                        echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
                            icon : 'warning'
                            });
                    });
                    </script>";
                    }
                }
            }
        } else {
            // no new image was uploaded, just update the other fields
            $sql = "UPDATE tb_user SET 
            year='$year',
            term='$term',
            student_id='$student_id',
            prefix='$prefix',
            firstname='$firstname' , 
            lastname='$lastname' ,
            email='$email' ,
            gender='$gender',
            faculty='$faculty', 
            branch='$branch',
            status='$status',
            userlevel='$userlevel'
            WHERE id=$id";
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
            window.location.href = 'form_csv.php';
          });
        });
        </script>";
            } else {
                echo "<script>
        $(document).ready(function() {
        Swal.fire( {
        title : 'แจ้งเตือน',
        text : 'แก้ไขข้อมูลไม่สำเร็จ',
        icon : 'warning'
        });
        });
        </script>";
            }
        }
    }

    if (isset($_POST['btndelimage'])) {
        $id = $_POST['id'];
        $query = "SELECT imge FROM tb_user WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $imageFilePath = 'profile/' . $row["imge"];
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // ลบไฟล์รูปภาพ
        }

        $query = "UPDATE tb_user SET imge='0' WHERE id='$id'";
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
                        window.location.href = 'form_csv.php';
                    });
                });
                </script>";
        } else {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
                        icon: 'warning'
                        showConfirmButton: false
                    });
                });
                </script>";
        }
    }

    if (isset($_POST['btnpass'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $passwordenc = md5($password);

        if (!empty($_POST['password'])) {
            $sql = "UPDATE tb_user SET password = '$passwordenc' WHERE id = '$id'";
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
                    window.location.href = 'form_csv.php';
                });
                });
                </script>";
            } else {
                echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                    title : 'แจ้งเตือน',
                    text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
                    icon : 'warning'
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
                window.location.href = 'form_csv.php';
            });
            });
            </script>";
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">
    <?php require_once "../design/head.php"; ?>

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
                        <li><a href="place.php" class="nav-link px-2 link-light"><i class="fa-solid fa-map-location-dot"></i>&nbsp;สถานที่</a></li>
                        <li><a href="insertss05_1.php" class="nav-link px-2 link-secondary"><i class="fa-regular fa-folder-open"></i>&nbsp;เอกสารแบบฟอร์ม</a></li>
                    </ul>

                    <div class="text-end">
                    <p class="fs-6 fw-bold text-light p-2 text-center badge bg-danger text-wrap"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

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
                    <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                    <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                    <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                </div>
                </ul>
            </div>

            <?php $sql = "SELECT 
        tb_user.id,
        tb_user.imge,
        tb_user.year,
        tb_year.year AS tbyear,
        tb_user.term,
        tb_term.term AS tbterm, 
        tb_user.student_id,
        tb_user.prefix,
        tb_user.firstname,
        tb_user.lastname,
        tb_user.email,
        tb_user.gender,
        tb_user.faculty,
        tb_user.branch,
        tb_branch.branch AS tbbranch,
        tb_user.status,
        tb_user.userlevel,
        tb_user.onoof,
        tb_user.password
        FROM tb_user 
        LEFT JOIN tb_year ON tb_user.year = tb_year.id_year
        LEFT JOIN tb_term ON tb_user.term = tb_term.id_term
        LEFT JOIN tb_branch ON tb_user.branch = tb_branch.idbranch
    WHERE id = $id";
            $resul = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($resul); ?>

            <div class="col-12 col-md-9 col-sm-12 pb-3 g-0" style="background-color: #f2f2f2;">
                <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            $imageFileName = $row["imge"];
                            $imageFilePath = 'profile/' . $imageFileName;
                            ?>

                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <?php if (isset($row["imge"]) && (strpos($row["imge"], ".png") !== false || strpos($row["imge"], ".jpeg") !== false || strpos($row["imge"], ".jpg") !== false)) { ?>
                                    <div class="row align-items-center">
                                        <div class="col text-end">
                                            <button type="submit" class="btn btn-sm btn-danger" name="btndelimage"><i class="fa-solid fa-trash-can"></i>&nbsp;ลบรูปภาพ</button>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <span></span>
                                <?php } ?>
                            </form>

                            <form method="post" enctype="multipart/form-data">

                                <input type="hidden" value="<?php echo $id ?>" name="id">

                                <?php if (!empty($imageFileName) && file_exists($imageFilePath)) { ?>
                                    <div class="col-12 text-center">
                                        <img src="<?= $imageFilePath ?>" class="img-fluid rounded mb-3" style="max-height: 300px;">
                                    </div>
                                <?php } ?>

                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupFile02"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                    <input type="file" class="form-control" id="inputGroupFile02" name="imge" accept="image/jpeg, image/png, image/jpg" value="<?php echo $imageFileName; ?>">
                                </div>


                                <div class="row justify-content-star mb-3">
                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-2 mt-md-0 mt-sm-2 fs-5">ปีการศึกษา</p>
                                        <?php
                                        echo '<select class="form-select" name="year">';
                                        $year = $row['year'];
                                        $tbyear = $row['tbyear'];

                                        $tb_year = mysqli_query($conn, "SELECT * FROM tb_year");

                                        while ($table2_row = mysqli_fetch_assoc($tb_year)) {
                                            $table2_id_year = $table2_row['id_year'];
                                            $table2_year = $table2_row['year'];

                                            if ($table2_id_year == $year || $table2_id_year == $year - 1) {
                                                $selected = ($year == $table2_id_year) ? 'selected' : '';
                                                echo "<option value='$table2_id_year' $selected>$table2_year</option>";
                                            }
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-2 mt-md-0 mt-sm-2 fs-5">เทอม</p>
                                        <select class="form-select" name="term">
                                            <?php
                                            $tbterm = $row['tbterm'];
                                            $tb_term = mysqli_query($conn, "SELECT * FROM tb_term");
                                            while ($table2_row = mysqli_fetch_assoc($tb_term)) {
                                                $selected = ($table2_row['id_term'] == $tbterm) ? 'selected' : ''; ?>
                                                <option value="<?php echo $table2_row['id_term']; ?>" <?php echo $selected; ?>><?php echo $table2_row['term']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <p class="text-start mt-3 fs-5">เลขประจำตัวนักศึกษา</p>
                                <input class="form-control" name="student_id" type="number" value="<?php echo $row['student_id']; ?>" maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                                <?php $prefix = $row['prefix']; ?>
                                <p class="text-start mt-3 fs-5">คำนำหน้า</p>
                                <select class="form-select" name="prefix" required>
                                    <option value="นาย" <?php echo $prefix == "นาย" ? "selected" : ""; ?>>นาย</option>
                                    <option value="นางสาว" <?php echo $prefix == "นางสาว" ? "selected" : ""; ?>>นางสาว</option>
                                </select>

                                <div class="row justify-content-star mb-3">
                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-3 fs-5">ชื่อ</p>
                                        <input class="form-control" name="firstname" type="text" value="<?php echo $row['firstname']; ?>">
                                    </div>
                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-3 fs-5">นามสกุล</p>
                                        <input class="form-control" name="lastname" type="text" value="<?php echo $row['lastname']; ?>">
                                    </div>
                                </div>

                                <p class="text-start mt-3 fs-5">อีเมล</p>
                                <input class="form-control" name="email" type="email" value="<?php echo $row['email']; ?>">

                                <?php $gender = $row['gender']; ?>
                                <p class="text-start mt-3 fs-5">เพศ</p>
                                <select class="form-select" name="gender">
                                    <option value="1" <?php echo $gender == "1" ? "selected" : ""; ?>>ชาย</option>
                                    <option value="2" <?php echo $gender == "2" ? "selected" : ""; ?>>หญิง</option>
                                </select>

                                <div class="row justify-content-star mb-3">
                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-3 fs-5">คณะ</p>
                                        <input class="form-control" name="faculty" type="text" value="<?php echo $row['faculty']; ?>" readonly>
                                    </div>

                                    <div class="col-12 col-md-6 col-sm-12">
                                        <p class="text-start mt-3 fs-5">สาขาวิชา</p>
                                        <select class="form-select" name="branch">
                                            <?php
                                            $tbbranch = $row['branch'];
                                            $tb_branch = mysqli_query($conn, "SELECT * FROM `tb_branch` WHERE `status_branch` = 1");
                                            while ($table2_row = mysqli_fetch_assoc($tb_branch)) {
                                                $selected = ($table2_row['idbranch'] == $tbbranch) ? 'selected' : ''; ?>
                                                <option value="<?php echo $table2_row['idbranch']; ?>" <?php echo $selected; ?>><?php echo $table2_row['branch']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php $status = $row['status']; ?>
                                <p class="text-start mt-3 fs-5">สถานะ</p>
                                <select class="form-select" name="status">
                                    <option value="1" <?php echo $status == "1" ? "selected" : ""; ?>>นักศึกษาสหกิจ</option>
                                    <option value="2" <?php echo $status == "2" ? "selected" : ""; ?>disabled>อาจารย์ที่ปรึกษา</option>
                                    <option value="3" <?php echo $status == "3" ? "selected" : ""; ?>disabled>พี่เลี้ยงนักศึกษาสหกิจ</option>
                                    <option value="4" <?php echo $status == "4" ? "selected" : ""; ?>disabled>อาจารย์ประสานงาน</option>
                                </select>

                                <?php $userlevel = $row["userlevel"]; ?>
                                <p class="text-start mt-3 fs-5">ระดับของสมาชิก</p>
                                <select class="form-select " name="userlevel">
                                    <option value="1" <?php echo $userlevel == "1" ? "selected" : ""; ?>>นักศึกษาสหกิจ</option>
                                    <option value="2" <?php echo $userlevel == "2" ? "selected" : ""; ?>disabled>อาจารย์ที่ปรึกษา</option>
                                    <option value="3" <?php echo $userlevel == "3" ? "selected" : ""; ?>disabled>พี่เลี้ยงนักศึกษาสหกิจ</option>
                                    <option value="4" <?php echo $userlevel == "4" ? "selected" : ""; ?>disabled>อาจารย์ประสานงาน</option>
                                </select>

                                <p class="text-start mt-3 fs-5">เปลี่ยนรหัสผ่าน <i class="fa-regular fa-eye-slash" id="togglePasswordConfirmIcon"></i>
                                </p>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="password" id="passwordConfirmInput" class="form-control" name="password" minlength="5" maxlength="20" aria-describedby="button-addon2">
                                            <button class="btn btn-dark" type="submit" id="button-addon2" name="btnpass"><i class="fa-regular fa-floppy-disk"></i></button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-success" type="submit" name="btnedit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                            <a class="btn btn-outline-danger" href="form_csv.php" role="button">ยกเลิก</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php require_once "../design/footer.php"; ?>
        <?php } ?>
    </body>

    </html>