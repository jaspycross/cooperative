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
        text : 'คุณไม่สามารถเข้าหน้านี้ได้!',
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
        $company_name  = $_POST['company_name'];
        $address  = $_POST['address'];
        $prefix_m  = $_POST['prefix_m'];
        $firstname_m  = $_POST['firstname_m'];
        $lastname_m  = $_POST['lastname_m'];
        $gender_m  = $_POST['gender_m'];
        $status_m  = $_POST['status_m'];
        $userlevel_m  = $_POST['userlevel_m'];
        $email_m  = $_POST['email_m'];
        $password_m  = $_POST['password_m'];
        $imge = $_FILES['imge'];
        $position = $_POST['position'];
        $phonenumber = $_POST['phonenumber'];
        $onoof_m = $_POST['onoof_m'];

        $user_check = "SELECT * FROM tb_mentor WHERE email_m = '$email_m' LIMIT 1";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if ($email_tm == $user['email_tm']) {
                echo "<script>
            $(document).ready(function() {
              Swal.fire( {
              
                text : 'อีเมลถูกใช้ไปแล้ว',
                icon : 'info'
                }).then(function() {
                    window.location.href = 'form_register3.php';
                });
              });
            </script>";
            }
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

            $passwordenc = md5($password_m);

            $query  =   "INSERT INTO tb_mentor (imge, company_name, address, prefix_m, firstname_m, lastname_m, gender_m, position, phonenumber, status_m, userlevel_m, email_m, password_m,onoof_m)        
                        VALUE ('$newfilename', '$company_name', '$address', '$prefix_m', '$firstname_m', '$lastname_m', '$gender_m', '$position', '$phonenumber', '$status_m', '$userlevel_m', '$email_m', '$passwordenc','$onoof_m')";
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
                                    window.location.href = 'form_register3.php';
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
        $id = $_POST['id_m'];
        $company_name  = $_POST['company_name'];
        $address  = $_POST['address'];
        $prefix_m  = $_POST['prefix_m'];
        $firstname_m  = $_POST['firstname_m'];
        $lastname_m  = $_POST['lastname_m'];
        $gender_m  = $_POST['gender_m'];
        $status_m  = $_POST['status_m'];
        $userlevel_m  = $_POST['userlevel_m'];
        $email_m  = $_POST['email_m'];
        $password_m  = $_POST['password_m'];
        $position = $_POST['position'];
        $phonenumber = $_POST['phonenumber'];

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
                    $sql = "SELECT imge FROM tb_mentor WHERE id_m = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'profile/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);

                    $sql = "UPDATE tb_mentor 
                    SET imge = '$fileNew',
                    company_name='$company_name',
                    address='$address',
                    prefix_m='$prefix_m',
                    firstname_m='$firstname_m' , 
                    lastname_m='$lastname_m' ,
                    gender_m='$gender_m',
                    status_m='$status_m',
                    userlevel_m='$userlevel_m',
                    position= '$position',
                    phonenumber='$phonenumber',
                    email_m='$email_m' 
                    WHERE id_m=$id";
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
                    window.location.href = 'form_register3.php';
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
                    window.location.href = 'form_register3.php';
                });
        });
        </script>";
                    }
                }
            }
        } else { // no new image was uploaded, just update the other fields
            $sql = "UPDATE tb_mentor 
                    SET company_name='$company_name',
                    address='$address',
                    prefix_m='$prefix_m',
                    firstname_m='$firstname_m' , 
                    lastname_m='$lastname_m' ,
                    gender_m='$gender_m',
                    status_m='$status_m',
                    userlevel_m='$userlevel_m',
                    position= '$position',
                    phonenumber='$phonenumber',
                    email_m='$email_m' 
                    WHERE id_m=$id";
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
                        window.location.href = 'form_register3.php';
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
                        window.location.href = 'form_register3.php';
                    });
            });
            </script>";
            }
        }
    }

    if (isset($_POST['btndelimage'])) {
        $id = $_POST['id_m'];
        $query = "SELECT imge FROM tb_mentor WHERE id_m = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $imageFilePath = 'profile/' . $row["imge"];
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // ลบไฟล์รูปภาพ
        }

        $query = "UPDATE tb_mentor SET imge='0' WHERE id_m='$id'";
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
                        window.location.href = 'form_register3.php';
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
        $id = $_POST['id_m'];
        $password = $_POST['password_m'];
        $passwordenc = md5($password);

        if (!empty($_POST['password_m'])) {
            $sql = "UPDATE tb_mentor SET password_m = '$passwordenc' WHERE id_m = '$id'";
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
                    window.location.href = 'form_register3.php';
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
                window.location.href = 'form_register3.php';
            });
            });
            </script>";
        }
    }

    if (isset($_POST['btnoof'])) {
        $id = $_POST['id_m'];
        $onoof_m = $_POST['onoof_m'];

        $sql = "UPDATE tb_mentor SET onoof_m = '$onoof_m' WHERE id_m = '$id'";
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
                    window.location.href = 'form_register3.php';
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
        $id = $_POST['id_m'];
        $onoof_m = $_POST['onoof_m'];

        $sql = "UPDATE tb_mentor SET onoof_m = '$onoof_m' WHERE id_m = '$id'";
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
                    window.location.href = 'form_register3.php';
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
                                        <li class="list-group-item"><a href="form_register.php" class="text-decoration-none text-dark">เพิ่มข้อมูลนักศึกษาสหกิจ</a></li>
                                        <li class="list-group-item"><a href="form_register2.php" class="text-decoration-none text-dark ">เพิ่มข้อมูลอาจารย์ที่ปรึกษาหรืออาจารย์ประสานงาน</a></li>
                                        <li class="list-group-item"><a href="form_register3.php" class="text-decoration-none">เพิ่มข้อมูลพี่เลี้ยงนักศึกษาสหกิจ</a></li>
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
                    </ul>
                </div>

                <div class="col-12 col-md-9 col-sm-12 pb-3 g-0" style="background-color: #f2f2f2;">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="fs-4 mt-3 text-center">ค้นหาข้อมูล</div>
                                <form action="form_register3.php?load=SUBMIT" method="get">
                                    <div class="input-group my-3">
                                        <input type="text" class="form-control form-control-lg" name="ename" placeholder="ชื่อ นามสกุล">
                                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>
                                        &nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด</label>
                                </form>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <!-- Button เพิ่มข้อมูล -->
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                            <i class="fa-solid fa-user-plus"></i>&nbsp;เพิ่มข้อมูลพี่เลี้ยงนักศึกษาสหกิจ
                                        </button>
                                        <!-- End Button เพิ่มข้อมูล -->
                                    </div>
                                </div>

                                <!-- Model Add 3 -->
                                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-3" id="exampleModalLabel">แบบฟอร์มข้อมูลพี่เลี้ยงนักศึกษาสหกิจ</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <form action="" method="post" enctype="multipart/form-data">

                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text" for="inputGroupFile01"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                                            <input type="file" class="form-control" id="inputGroupFile01" name="imge" accept="image/jpeg, image/png, image/jpg">
                                                        </div>

                                                        <div class="row justify-content-star mb-3">
                                                            <div class="col-12">
                                                                <p class="text-start mt-3 fs-5">ชื่อของบริษัท</p>
                                                                <input class="form-control" name="company_name" type="text" required>
                                                            </div>
                                                        </div>

                                                        <p class="text-start mt-3 fs-5 ">ที่อยู่</p>
                                                        <input class="form-control mb-3" name="address" type="text" required>

                                                        <p class="text-start fs-5">คำนำหน้า</p>
                                                        <select class="form-select mt-3" name="prefix_m" required>
                                                            <option selected value="">-- เลือก --</option>
                                                            <option value="1">นาย</option>
                                                            <option value="2">นางสาว</option>
                                                        </select>

                                                        <div class="row justify-content-star mb-3">
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">ชื่อ</p>
                                                                <input class="form-control" name="firstname_m" type="text" required>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p class="text-start mt-3 fs-5">นามสกุล</p>
                                                                <input class="form-control" name="lastname_m" type="text" required>
                                                            </div>
                                                        </div>

                                                        <p class="text-start mt-3 fs-5">เพศ</p>
                                                        <select class="form-select mt-3" name="gender_m" required>
                                                            <option selected value="">-- เลือก --</option>
                                                            <option value="1">ชาย</option>
                                                            <option value="2">หญิง</option>
                                                        </select>

                                                        <p class="text-start mt-3 fs-5">ตำแหน่ง</p>
                                                        <input class="form-control" name="position" type="text" required>

                                                        <p class="text-start mt-3 fs-5">สถานะ</p>
                                                        <select class="form-select my-3" name="status_m" readonly required>
                                                            <option selected value="3">พี่เลี้ยงนักศึกษาสหกิจ</option>
                                                        </select>

                                                        <select class="form-select mt-3" name="userlevel_m" hidden required>
                                                            <option selected value="3">พี่เลี้ยงนักศึกษาสหกิจ</option>
                                                        </select>

                                                        <p class="text-start mt-3 fs-5">เบอร์โทรศัพท์</p>

                                                        <input type="number" class="form-control mb-3" name="phonenumber" value="0" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                                        <p class="text-start mt-3 fs-5 ">อีเมล</p>
                                                        <input class="form-control mb-3" name="email_m" type="email" required>

                                                        <p class="text-start mt-3 fs-5">รหัสผ่าน <i class="fa-regular fa-eye-slash" id="togglePasswordIcon"></i></p>
                                                        <input class="form-control" name="password_m" id="passwordInput" type="password" minlength="5" maxlength="20" required>
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
                                <!-- End Model Add 3 -->

                                <?php if (isset($_GET['ename']) ? $name = $_GET['ename'] : $name = "");
                                $sql = "SELECT * FROM tb_mentor WHERE firstname_m LIKE '%$name%' OR lastname_m LIKE '%$name%' ORDER BY id_m DESC";
                                $result = mysqli_query($conn, $sql);
                                ?>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered text-center mt-3 align-middle">
                                        <caption>ข้อมูลทั้งหมด</caption>
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
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
                                                        <td><?php echo $row["firstname_m"]; ?></td>
                                                        <td><?php echo $row["lastname_m"]; ?></td>
                                                        <td><?php echo $row["email_m"]; ?></td>
                                                        <td><?php if ($row['status_m'] == "") {
                                                                echo "ไม่มีข้อมูล";
                                                            } else if ($row['status_m'] == "1") {
                                                                echo "นักศึกษาฝึกงาน";
                                                            } else if ($row["status_m"] == "2") {
                                                                echo "อาจารย์ที่ปรึกษา";
                                                            } else if ($row["status_m"] == "3") {
                                                                echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                            } else if ($row["status_m"] == "4") {
                                                                echo "อาจารย์ประสานงาน";
                                                            } ?>
                                                            <br>
                                                            <?php if ($row['onoof_m'] == "0") {
                                                                echo "( ยกเลิกการใช้งาน )";
                                                            } else if ($row['onoof_m'] == "1") {
                                                                echo "( ปกติ )";
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $imageFileName = $row["imge"];
                                                            $imageFilePath = 'profile/' . $imageFileName;
                                                            ?>

                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-warning w-100" title="แก้ไขข้อมูล" data-bs-toggle="modal" data-bs-target="#modalId<?php echo $row["id_m"]; ?>">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modalId<?php echo $row['id_m'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalTitleId"><?php echo $row['prefix_m'] . $row['firstname_m'] . " " . $row['lastname_m'] ?></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container-fluid">
                                                                                <form method="post" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="id_m" value="<?php echo $row['id_m']; ?>">
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

                                                                                <form action="" method="post" enctype="multipart/form-data">

                                                                                    <input type="hidden" type="number" value="<?php echo $row["id_m"]; ?>" name="id_m">

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
                                                                                        <div class="col-12">
                                                                                            <p class="text-start mt-3 fs-5">ชื่อของบริษัท</p>
                                                                                            <input class="form-control" name="company_name" type="text" value="<?php echo $row['company_name']; ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <p class="text-start mt-3 fs-5 ">ที่อยู่</p>
                                                                                    <input class="form-control mb-3" name="address" type="text" value="<?php echo $row['address']; ?>">

                                                                                    <?php $prefix_m = $row['prefix_m']; ?>
                                                                                    <p class="text-start mt-3 fs-5">คำนำหน้า</p>
                                                                                    <select class="form-select" name="prefix_m">
                                                                                        <option value="1" <?php echo $prefix_m == "1" ? "selected" : ""; ?>>นาย</option>
                                                                                        <option value="2" <?php echo $prefix_m == "2" ? "selected" : ""; ?>>นางสาว</option>
                                                                                    </select>

                                                                                    <div class="row justify-content-star mb-3">
                                                                                        <div class="col-12 col-md-6 col-sm-12">
                                                                                            <p class="text-start mt-3 fs-5">ชื่อ</p>
                                                                                            <input class="form-control" name="firstname_m" type="text" value="<?php echo $row['firstname_m']; ?>">
                                                                                        </div>
                                                                                        <div class="col-12 col-md-6 col-sm-12">
                                                                                            <p class="text-start mt-3 fs-5">นามสกุล</p>
                                                                                            <input class="form-control" name="lastname_m" type="text" value="<?php echo $row['lastname_m']; ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <?php $gender_m = $row['gender_m']; ?>
                                                                                    <p class="text-start mt-3 fs-5">เพศ</p>
                                                                                    <select class="form-select mt-3" name="gender_m">
                                                                                        <option value="1" <?php echo $gender_m == "1" ? "selected" : ""; ?>>ชาย</option>
                                                                                        <option value="2" <?php echo $gender_m == "2" ? "selected" : ""; ?>>หญิง</option>
                                                                                    </select>

                                                                                    <?php $position = $row['position']; ?>
                                                                                    <p class="text-start mt-3 fs-5">ตำแหน่ง</p>
                                                                                    <input class="form-control" name="position" type="text" value="<?php echo $position; ?>" required>

                                                                                    <?php $status_m = $row['status_m']; ?>
                                                                                    <p class="text-start mt-3 fs-5">สถานะ</p>
                                                                                    <select class="form-select my-3" name="status_m">
                                                                                        <option value="1" <?php echo $status_m == "1" ? "selected" : ""; ?>disabled>นักศึกษาสหกิจ</option>
                                                                                        <option value="2" <?php echo $status_m == "2" ? "selected" : ""; ?>disabled>อาจารย์ที่ปรึกษา</option>
                                                                                        <option value="3" <?php echo $status_m == "3" ? "selected" : ""; ?>>พี่เลี้ยงนักศึกษาสหกิจ</option>
                                                                                        <option value="4" <?php echo $status_m == "4" ? "selected" : ""; ?>disabled>อาจารย์ประสานงาน</option>
                                                                                    </select>

                                                                                    <?php $userlevel_m = $row['userlevel_m']; ?>
                                                                                    <p class="text-start fs-5">ระดับของสมาชิก</p>
                                                                                    <select class="form-select mt-3" name="userlevel_m">
                                                                                        <option value="1" <?php echo $userlevel_m == "1" ? "selected" : ""; ?>disabled>นักศึกษาสหกิจ</option>
                                                                                        <option value="2" <?php echo $userlevel_m == "2" ? "selected" : ""; ?>disabled>อาจารย์ที่ปรึกษา</option>
                                                                                        <option value="3" <?php echo $userlevel_m == "3" ? "selected" : ""; ?>>พี่เลี้ยงนักศึกษาสหกิจ</option>
                                                                                        <option value="4" <?php echo $userlevel_m == "4" ? "selected" : ""; ?>disabled>อาจารย์ประสานงาน</option>
                                                                                    </select>

                                                                                    <p class="text-start mt-3 fs-5">เบอร์โทรศัพท์</p>
                                                                                    <input type="number" class="form-control" name="phonenumber" value="<?php echo $row['phonenumber']; ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                                                                                    <p class="text-start mt-3 fs-5">อีเมล</p>
                                                                                    <input class="form-control" name="email_m" type="email" value="<?php echo $row['email_m']; ?>">

                                                                                    <p class="text-start mt-3 fs-5">เปลี่ยนรหัสผ่าน <i class="fa-regular fa-eye-slash" id="togglePasswordConfirmIcon"></i>
                                                                                    </p>
                                                                                    <div class="row justify-content-center align-items-center">
                                                                                        <div class="col-12">
                                                                                            <div class="input-group">
                                                                                                <input type="password" id="passwordConfirmInput" class="form-control" name="password_m" minlength="5" maxlength="20" aria-describedby="button-addon2">
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
                                                            </div>

                                                            <?php if ($row['onoof_m'] == 1) { ?>
                                                                <input type="hidden" name="id_m" value="<?php echo $row['id_m']; ?>">
                                                                <input type="hidden" name="onoof_m" value="0">
                                                                <button class="btn btn-outline-danger mt-2 w-100" name="btnoof" type="submit"><i class="fa-solid fa-toggle-off"></i> ยกเลิกการใช้งาน</button>
                                                            <?php } else { ?>
                                                                <input type="hidden" name="id_m" value="<?php echo $row['id_m']; ?>">
                                                                <input type="hidden" name="onoof_m" value="1">
                                                                <button class="btn btn-outline-success mt-2 w-100" name="btnon" type="submit" value="1"><i class="fa-solid fa-toggle-on"></i> ปกติ</button>
                                                            <?php } ?>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else {
                                                echo '<td class="fs-5" colspan="6">' . "ไม่มีข้อมูลลองค้นหาข้อมูลอีกครั้ง" . '</td>';
                                            } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php require_once '../design/footer.php'; ?>
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