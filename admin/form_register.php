<!-- เสร็จสมบรูณ์ -->
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
        text : 'คุณไม่สามารถเข้าหน้านี้ได้',
        icon : 'warning',
        timer : 3000,
        showConfirmButton : false
      });
  });
</script>";
    session_unset();
    session_destroy();
    header("location: ../home.php");
} else {

    if (isset($_POST['submit'])) {

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
        $password = $_POST['password'];
        $onoof = $_POST['onoof'];
        $imge = $_FILES['imge'];

        $user_check = "SELECT * FROM tb_user WHERE student_id = '$student_id' LIMIT 1";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $student_id == $user['student_id'];
            $email == $user['email'];
            echo "<script>
            $(document).ready(function() {
              Swal.fire( {
                text : 'เลขประจำตัวนักศึกษาหรืออีเมลถูกใช้ไปแล้ว',
                icon : 'info'
                }).then(function() {
                    window.location.href = 'form_register.php';
                });
              });
            </script>";
        } else {

            // Image upload logic
            if ($imge != "") {
                $temp = explode(".", $imge['name']);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $file_ext = strtolower(end($temp));
                $allowed_extensions = array("jpg", "jpeg", "png");
                if (in_array($file_ext, $allowed_extensions)) {
                    move_uploaded_file($imge['tmp_name'], "profile/" . $newfilename);
                } else {
                    $newfilename = "0";
                }
            } else {
                $newfilename = "0";
            }

            $passwordenc = md5($password);

            $query  =   "INSERT INTO tb_user ( imge, year, term, student_id, prefix, firstname, lastname, email, gender, faculty, branch, status, userlevel, password ,onoof)
                        VALUE ('$newfilename', '$year', '$term', '$student_id', '$prefix', '$firstname', '$lastname', '$email', '$gender', '$faculty', '$branch', '$status', '$userlevel', '$passwordenc', '$onoof')";
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
                                    window.location.href = 'form_register.php';
                                });
                            });
                            </script>";
            } else {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
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
                                window.location.href = 'form_register.php';
                            });
                        });
                    </script>";
                    } else {
                        echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                            title : 'แจ้งเตือน',
                            text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
                            icon : 'warning',
                            timer : 2000,
                            showConfirmButton : false
                            }).then(function() {
                                window.location.href = 'form_register.php';
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
            window.location.href = 'form_register.php';
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
                        window.location.href = 'form_register.php';
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
                    window.location.href = 'form_register.php';
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
                window.location.href = 'form_register.php';
            });
            });
            </script>";
        }
    }


    if (isset($_POST['btnoof'])) {
        $id = $_POST['id'];
        $onoof = $_POST['onoof'];

        $sql = "UPDATE tb_user SET onoof = '$onoof' WHERE id = '$id'";
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
                    window.location.href = 'form_register.php';
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

    if (isset($_POST['btnon'])) {
        $id = $_POST['id'];
        $onoof = $_POST['onoof'];

        $sql = "UPDATE tb_user SET onoof = '$onoof' WHERE id = '$id'";
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
                    window.location.href = 'form_register.php';
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
?>
    <!doctype html>
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
                    </ul>

                    <div class="text-end">
                        <p class="fs-6 fw-bold text-light p-2 text-center badge bg-danger text-wrap"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

        <div class="container-fluid">
            <div class="row justify-content-start">
                <div class="col-12 col-md-3 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="accordion accordion-flush border" id="accordionPanelsStayOpenExample">
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="profile_tm.php" role="button"><i class="fa-solid fa-user-gear"></i>&nbsp;ข้อมูลส่วนตัว</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="work_history.php" role="button"><i class="fa-solid fa-business-time"></i>&nbsp;ประวัติการทำงาน</a>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    <i class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูลสมาชิก</button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_register.php" class="text-decoration-none">เพิ่มข้อมูลนักศึกษาสหกิจ</a></li>
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
                        <a class="btn w-100 p-3 text-start  border-bottom rounded-0" href="place.php" role="button"><i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกสหกิจศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother3.php" role="button"><i class="fa-regular fa-address-card"></i>&nbsp;เพิ่มคำนำหน้าชื่อ</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother.php" role="button"><i class="fa-regular fa-calendar-plus"></i>&nbsp;เพิ่มปีการศึกษา</a>
                        <a class="btn w-100 p-3 text-start border-bottom rounded-0" href="addother2.php" role="button"><i class="fa-solid fa-user-graduate"></i>&nbsp;เพิ่มสาขาวิชา</a>
                        <a class="btn w-100 p-3 text-start border-bottom" href="dashboard.php" role="button"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเข้าใช้งาน</a>
                        <a class="btn w-100 p-3 text-start rounded-0" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                </div>

                <div class="col-12 col-md-9 col-sm-12 pb-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-body">

                                <div class="fs-4 mt-3 text-center">ค้นหาข้อมูล</div>
                                <form action="form_register.php?load=SUBMIT" method="get">
                                    <div class="input-group my-3">
                                        <input type="text" class="form-control form-control-lg" name="ename" placeholder="ชื่อ นามสกุล รหัสประจำตัวนักศึกษา">
                                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>&nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด </label>
                                </form>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <!-- Button เพิ่มข้อมูล -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูลนักศึกษาสหกิจ
                                        </button>&nbsp;
                                        <!-- End Button เพิ่มข้อมูล -->
                                    </div>
                                </div>

                                <!-- Model Add -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-3" id="exampleModalLabel">แบบฟอร์มข้อมูลนักศึกษาสหกิจ</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="onoof" value="1">
                                                        <div class="row justify-content-star mb-3">

                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="inputGroupFile01"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                                                <input type="file" class="form-control" id="inputGroupFile01" name="imge" accept="image/jpeg, image/png, image/jpg">
                                                            </div>

                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <?php
                                                                $current_year = date("Y"); // ปีปัจจุบัน (ค.ศ.)
                                                                $current_buddhist_year = $current_year + 543; // ปีปัจจุบัน (พ.ศ.)
                                                                $previous_buddhist_year = $current_buddhist_year - 1; // ปีก่อนหน้า (พ.ศ.)

                                                                $query = "SELECT id_year, year FROM tb_year WHERE year IN ($previous_buddhist_year, $current_buddhist_year) ORDER BY tb_year.id_year DESC"; // เรียกข้อมูล id_year และ year จากฐานข้อมูล
                                                                $result = mysqli_query($conn, $query);

                                                                $options = [];
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id_year = $row['id_year'];
                                                                    $year = $row['year']; // ปีในฐานข้อมูลเป็น พ.ศ.
                                                                    $options[$year] = $id_year;
                                                                }

                                                                // Check if both years are present in the database, if not, set their id_year to NULL
                                                                $options += [
                                                                    $previous_buddhist_year => NULL,
                                                                    $current_buddhist_year => NULL
                                                                ];
                                                                ?>
                                                                <p class="text-start fs-5">ปีการศึกษา</p>
                                                                <select class='form-select' id="year" name="year">
                                                                    <?php
                                                                    foreach ($options as $year => $id_year) {
                                                                        $selected = ($year == $current_buddhist_year) ? "selected" : ""; // เช็คว่าเป็นปีปัจจุบันหรือไม่
                                                                        echo "<option value='{$id_year}' {$selected}>{$year}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start fs-5">ภาคการศึกษา</p>
                                                                <select class="form-select mb-0 mb-md-0 mb-sm-3" name="term" required>
                                                                    <option selected value="">-- เลือก --</option>
                                                                    <?php
                                                                    $query = "SELECT id_term, term FROM tb_term"; // เรียกข้อมูล id_term และ term จากฐานข้อมูล
                                                                    $result = mysqli_query($conn, $query);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $id_term = $row['id_term'];
                                                                        $term = $row['term'];
                                                                        echo "<option value='$id_term'>$term</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <p class="text-start fs-5">เลขประจำตัวนักศึกษา</p>
                                                        <input class="form-control mb-3" name="student_id" type="number" minlength="12" maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                                        <p class="text-start fs-5">คำนำหน้า</p>
                                                        <select class="form-select mt-3" name="prefix" required>
                                                            <option selected value="">-- เลือก --</option>
                                                            <option value="นาย">นาย</option>
                                                            <option value="นางสาว">นางสาว</option>
                                                        </select>

                                                        <div class="row justify-content-star mb-3">
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">ชื่อ</p>
                                                                <input class="form-control" name="firstname" type="text" required>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">นามสกุล</p>
                                                                <input class="form-control" name="lastname" type="text" required>
                                                            </div>
                                                        </div>

                                                        <p class="text-start mt-3 fs-5">อีเมล</p>
                                                        <input class="form-control" name="email" type="email" required>

                                                        <p class="text-start mt-3 fs-5">เพศ</p>
                                                        <select class="form-select mt-3" name="gender" required>
                                                            <option selected value="">-- เลือก --</option>
                                                            <option value="1">ชาย</option>
                                                            <option value="2">หญิง</option>
                                                        </select>

                                                        <div class="row justify-content-star mb-3">
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">คณะ</p>
                                                                <input class="form-control" name="faculty" type="text" value="บริหารธุรกิจ" readonly required>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">สาขาวิชา</p>
                                                                <select class="form-select" name="branch" required>
                                                                    <option selected value="">-- เลือก --</option>
                                                                    <?php
                                                                    $query = "SELECT * FROM `tb_branch` WHERE `status_branch` = 1"; // เรียกข้อมูล id_term และ term จากฐานข้อมูล
                                                                    $result = mysqli_query($conn, $query);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $idbranch = $row['idbranch'];
                                                                        $branch = $row['branch'];
                                                                        echo "<option value='$idbranch'>$branch</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <p class="text-start mt-3 fs-5">สถานะ</p>
                                                        <select class="form-select my-3" name="status" readonly required>
                                                            <option selected value="1">นักศึกษาสหกิจ</option>
                                                        </select>

                                                        <select class="form-select mt-3" name="userlevel" hidden required>
                                                            <option selected value="1"></option>
                                                        </select>

                                                        <p class="text-start mt-3 fs-5">รหัสผ่าน <i class="fa-regular fa-eye-slash" id="togglePasswordIcon"></i></p>
                                                        <input class="form-control" name="password" id="passwordInput" type="password" minlength="5" maxlength="20" required>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success" type="submit" name="submit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Model Add -->
                                <?php if (isset($_GET['ename']) ? $name = $_GET['ename'] : $name = "");
                                $sql = "SELECT 
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
                                    WHERE
                                    tb_user.firstname LIKE '%$name%' OR 
                                    tb_user.lastname LIKE '%$name%' OR 
                                    tb_user.student_id LIKE '%$name%' OR
                                    tb_branch.branch LIKE '%$name%' ORDER BY id DESC";
                                $result = mysqli_query($conn, $sql);
                                ?>

                                <!-- table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered text-center mt-3 align-middle" style="width: max-content;">
                                        <caption>ข้อมูลทั้งหมด</caption>
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสประจำตัวนักศึกษา</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
                                                <th>สาขา</th>
                                                <th>อีเมล</th>
                                                <th>สถานะ</th>
                                                <th><i class="fa-solid fa-sliders"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i = 1; ?>
                                            <?php if (mysqli_num_rows($result) > 0) { ?>
                                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td scope="row"><?php echo substr($row['student_id'], 0, 11) . '-' . substr($row['student_id'], 11); ?></td>
                                                        <td><?php echo $row["firstname"]; ?></td>
                                                        <td><?php echo $row["lastname"]; ?></td>
                                                        <td><?php echo $row["tbbranch"]; ?></td>
                                                        <td><?php echo $row["email"]; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == "") {
                                                                echo "ไม่มีข้อมูล";
                                                            } else if ($row['status'] == "1") {
                                                                echo "นักศึกษาสหกิจ";
                                                            } else if ($row["status"] == "2") {
                                                                echo "อาจารย์ที่ปรึกษา";
                                                            } else if ($row["status"] == "3") {
                                                                echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                            } else if ($row["status"] == "4") {
                                                                echo "อาจารย์ประสานงาน";
                                                            }
                                                            ?>
                                                            <br>
                                                            <?php if ($row['onoof'] == "0") {
                                                                echo "( ยกเลิกการใช้งาน )";
                                                            } else if ($row['onoof'] == "1") {
                                                                echo "( ปกติ )";
                                                            } ?>
                                                        </td>

                                                        <td>

                                                            <?php
                                                            $imageFileName = $row["imge"];
                                                            $imageFilePath = 'profile/' . $imageFileName;
                                                            ?>
                                                            <!-- เเก้ไขข้อมูล -->
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-warning w-100" title="แก้ไขข้อมูล" data-bs-toggle="modal" data-bs-target="#modalId<?php echo $row["id"]; ?>">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modalId<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalTitleId"><?php echo $row['prefix'] . $row['firstname'] . " " . $row['lastname'] ?></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container-fluid">
                                                                                <form method="post" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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

                                                                                    <input type="hidden" type="number" value="<?php echo $row["id"]; ?>" name="id">

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
                                                                                            <p class="text-start mt-2 mt-md-0 mt-sm-2 fs-5">ภาคการศึกษา</p>
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
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-success" type="submit" name="btnedit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- end modal -->
                                                            <?php if ($row['onoof'] == 1) { ?>
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <input type="hidden" name="onoof" value="0">
                                                                <button class="btn btn-outline-danger mt-2 w-100" name="btnoof" type="submit"><i class="fa-solid fa-toggle-off"></i> ยกเลิกการใช้งาน</button>
                                                            <?php } else { ?>
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <input type="hidden" name="onoof" value="1">
                                                                <button class="btn btn-outline-success mt-2 w-100" name="btnon" type="submit" value="1"><i class="fa-solid fa-toggle-on"></i> ปกติ</button>
                                                            <?php } ?>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else {
                                                echo '<td class="fs-5" colspan="8">' . "ไม่มีข้อมูลลองค้นหาข้อมูลอีกครั้ง" . '</td>';
                                            } ?>
                                </div><!-- table -->
                            </div><!-- card-body -->
                        </div>
                    </div>
                </div><!-- container -->
            <?php } ?>
            <?php require_once "../design/footer.php"; ?>
    </body>
    <script>
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
        const togglePasswordConfirmIcon = document.getElementById('togglePasswordConfirmIcon');
        const passwordInput = document.getElementById('passwordInput');
        const passwordConfirmInput = document.getElementById('passwordConfirmInput');

        togglePasswordIcon.addEventListener('click', function() {
            if (passwordInput.type === "password") {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
            this.classList.toggle('fa-eye');
        });

        togglePasswordConfirmIcon.addEventListener('click', function() {
            if (passwordConfirmInput.type === "password") {
                passwordConfirmInput.type = 'text';
            } else {
                passwordConfirmInput.type = 'password';
            }
            this.classList.toggle('fa-eye');
        });
    </script>

    </html>