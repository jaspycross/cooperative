<!-- เสร็จสมบรูณ์แล้ว -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php

session_start();
require_once 'dbconnect.php';

if (isset($_POST['login_stu'])) {

    $student_id = $_POST['student_id'];
    $password = $_POST['password'];
    $passwordenc = md5($password);

    $query = "SELECT * FROM tb_user WHERE student_id = '$student_id' AND password = '$passwordenc'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $_SESSION['userid'] = $row['id'];
        $_SESSION['user'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['userlevel'] = $row['userlevel'];
        $_SESSION['prefixuser'] = $row['prefix'] . $row['firstname'];
        $_SESSION['onoof'] =  $row['onoof'];

        if ($_SESSION['userlevel'] == '1' &&  $_SESSION['onoof'] == '1') {

            $name = $_SESSION['user'];

            $sql = "INSERT INTO log_file (name, status)
                    VALUES ('$name', '1')";
            mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                        title : 'เข้าสู่ระบบสำเร็จ',
                        text : 'คุณกำลังเข้าใช้งานเว็บไซต์เรา',
                        icon : 'success',
                        timer : 3000,
                        showConfirmButton : false
                        });
                    });
                </script>";
            header("refresh:1; url= student/index.php");
        } elseif ($_SESSION['userlevel'] == '1' &&  $_SESSION['onoof'] != '1') {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ไม่สามารถเข้าใช้งานได้',
                text : 'ถูกยกเลิกบัญชีแล้ว',
                icon : 'error'
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
        }
    } else {
        echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'เลขประจำตัวนักศึกษาหรือรหัสผ่านไม่ถูกต้อง',
                icon : 'warning',
                timer : 3000,
                showConfirmButton : false
                });
            });
        </script>";
        header("refresh:1; url=home.php");
    }
}

if (isset($_POST['login_ta'])) {

    $email_tm = $_POST['email_tm'];
    $password_tm = $_POST['password_tm'];
    $passwordenc = md5($password_tm);

    $query = "SELECT * FROM tb_teacher_admin WHERE email_tm = '$email_tm' AND password_tm = '$passwordenc'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $_SESSION['userid_tm'] = $row['id_tm'];
        $_SESSION['user_tm'] = $row['firstname_tm'] . " " . $row['lastname_tm'];
        $_SESSION['user_tmfirstname'] = $row['firstname_tm'];
        $_SESSION['user_tmlastname'] = $row['lastname_tm'];
        $_SESSION['userlevel_tm'] = $row['userlevel_tm'];
        $_SESSION['onoof_tm'] =  $row['onoof_tm'];

        if ($_SESSION['userlevel_tm'] == '2' &&  $_SESSION['onoof_tm'] == '1') {

            $name = $_SESSION['user_tm'];

            $sql = "INSERT INTO log_file (name, status)
                    VALUES ('$name', '1')";
            mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                        title : 'เข้าสู่ระบบสำเร็จ',
                        text : 'คุณกำลังเข้าใช้งานเว็บไซต์เรา',
                        icon : 'success',
                        timer : 3000,
                        showConfirmButton : false
                        }).then(function() {
                            window.location.href = 'teacher/index.php';
                        });
                    });
                </script>";
        } elseif ($_SESSION['userlevel_tm'] == '2' &&  $_SESSION['onoof_tm'] != '1') {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ไม่สามารถเข้าใช้งานได้',
                text : 'ถูกยกเลิกบัญชีแล้ว',
                icon : 'error'
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
        }

        if ($_SESSION['userlevel_tm'] == '4' &&  $_SESSION['onoof_tm'] == '1') {

            $name = $_SESSION['user_tm'];

            $sql = "INSERT INTO log_file (name, status)
                    VALUES ('$name', '1')";
            mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                        title : 'เข้าสู่ระบบสำเร็จ',
                        text : 'คุณกำลังเข้าใช้งานเว็บไซต์เรา',
                        icon : 'success',
                        timer : 3000,
                        showConfirmButton : false
                        }).then(function() {
                            window.location.href = 'co_admin/index.php';
                        });
                    });
                </script>";
        } elseif ($_SESSION['userlevel_tm'] == '4' &&  $_SESSION['onoof_tm'] != '1') {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ไม่สามารถเข้าใช้งานได้',
                text : 'ถูกยกเลิกบัญชีแล้ว',
                icon : 'error'
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
        }
        if ($_SESSION['userlevel_tm'] == '5' &&  $_SESSION['onoof_tm'] == '1') {

            $name = $_SESSION['user_tm'];

            $sql = "INSERT INTO log_file (name, status)
                    VALUES ('$name', '1')";
            mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                        title : 'เข้าสู่ระบบสำเร็จ',
                        text : 'คุณกำลังเข้าใช้งานเว็บไซต์เรา',
                        icon : 'success',
                        timer : 3000,
                        showConfirmButton : false
                        }).then(function() {
                            window.location.href = 'admin/index.php';
                        });
                    });
                </script>";
        } elseif ($_SESSION['userlevel_tm'] == '5' &&  $_SESSION['onoof_tm'] != '1') {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ไม่สามารถเข้าใช้งานได้',
                text : 'ถูกยกเลิกบัญชีแล้ว',
                icon : 'error'
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
        }
    } else {
        echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง',
                icon : 'warning',
                timer : 3000,
                showConfirmButton : false
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
    }
}

if (isset($_POST['login_m'])) {

    $email_m = $_POST['email_m'];
    $password_m = $_POST['password_m'];
    $passwordenc = md5($password_m);

    $query = "SELECT * FROM tb_mentor WHERE email_m = '$email_m' AND password_m = '$passwordenc'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $_SESSION['userid_m'] = $row['id_m'];
        $_SESSION['user_m'] = $row['firstname_m'] . " " . $row['lastname_m'];
        $_SESSION['userlevel_m'] = $row['userlevel_m'];
        $_SESSION['onoof_m'] =  $row['onoof_m'];

        if ($_SESSION['userlevel_m'] == '3' && $_SESSION['onoof_m'] == '1') {

            $name = $_SESSION['user_m'];

            $sql = "INSERT INTO log_file (name, status)
                    VALUES ('$name', '1')";
            mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                    Swal.fire( {
                        title : 'เข้าสู่ระบบสำเร็จ',
                        text : 'คุณกำลังเข้าใช้งานเว็บไซต์เรา',
                        icon : 'success',
                        timer : 3000,
                        showConfirmButton : false
                        });
                    });
                </script>";
            header("refresh:1; url= mentor/index.php");
        } elseif ($_SESSION['userlevel_m'] == '3' &&  $_SESSION['onoof_m'] != '1') {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ไม่สามารถเข้าใช้งานได้',
                text : 'ถูกยกเลิกบัญชีแล้ว',
                icon : 'error'
                }).then(function() {
                    window.location.href = 'home.php';
                });
            });
        </script>";
        }
    } else {
        echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง',
                icon : 'warning',
                timer : 3000,
                showConfirmButton : false
                });
            });
        </script>";
        header("refresh:1; url=home.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<?php require_once 'design/head.php'; ?>

<body>
    <!-- nav -->
    <header class="bg-dark p-4 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
                <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <img src="Logo.png" width="40" height="64">&nbsp;&nbsp;
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                    <li><a href="indexmes.php" class="nav-link px-2 link-light"><i class="fa-regular fa-message"></i>&nbsp;&nbsp;กระทู้</a></a></li>
                    <li><a href="index2.php" class="nav-link px-2 link-light"><i class="fa-solid fa-map-location-dot"></i>&nbsp;&nbsp;สถานที่ฝึกสหกิจศึกษา</a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- End nav -->

    <div class="container text-center">
        <form action="" method="post">

            <p class="fs-2 mb-5 mt-5 text-center"><i class="fa-solid fa-user-lock"></i>&nbsp;&nbsp;เข้าสู่ระบบ</p>

            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-9">
                    <p class="fs-5 text-start"><i class="fa-solid fa-id-card fa-lg"></i>&nbsp;&nbsp;เลขประจำตัวนักศึกษา
                    </p>
                    <input class="form-control shadow p-3 mb-3 bg-body rounded" name="student_id" type="number" placeholder="เลขประจำตัวนักศึกษาไม่ต้องมีขีด (-)" maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-9">
                    <p class="mt-3 fs-5 text-start"><i class="fa-solid fa-key fa-lg"></i>&nbsp;&nbsp;รหัสผ่าน</p>
                    <input class="form-control shadow p-3 mb-5 bg-body rounded" name="password" type="password" placeholder="รหัสผ่าน 5-20 ตัวอักษร" minlength="5" maxlength="20" required>
                </div>
            </div>

            <p><a class="btn btn-lg btn-link text-decoration-none" href="recover_psw.php" role="button">ลืมรหัสผ่าน?</a></p>

            <input class="btn btn-success mb-3 btn-lg w-25" type="submit" name="login_stu" value="ยืนยัน">&nbsp;&nbsp;
            <button class="btn btn-danger mb-3 btn-lg w-25" type="reset">ยกเลิก</button>

        </form>



    </div>

    <div class="container text-center">
        <!-- Button เพิ่มข้อมูล -->
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-user-lock"></i>&nbsp;เข้าสู่ระบบสำหรับอาจารย์ที่ปรึกษาและอาจารย์ประสานงาน
        </button>&nbsp;
        <!-- End Button เพิ่มข้อมูล -->

        <!-- Button เพิ่มข้อมูล -->
        <button type="button" class="btn btn-outline-dark my-3 my-sm-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
            <i class="fa-solid fa-user-lock"></i>&nbsp;เข้าสู่ระบบสำหรับพี่เลี้ยงของนักศึกษาสหกิจ
        </button>&nbsp;
        <!-- End Button เพิ่มข้อมูล -->
    </div>

    <?php require_once 'design/footer.php'; ?>

    <!-- Model Add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fs-3" id="exampleModalLabel">
                        เข้าสู่ระบบสำหรับอาจารย์ที่ปรึกษาและอาจารย์ประสานงาน</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="container">

                            <p class="text-start fs-5">อีเมล</p>
                            <input class="form-control mb-3" name="email_tm" type="email" required>

                            <p class="text-start mt-3 fs-5">รหัสผ่าน</p>
                            <input class="form-control" name="password_tm" type="password" minlength="5" maxlength="20" required>

                            <div class="row mt-3 mb-4">
                                <div class="col d-grid">
                                    <input class="btn btn-success mt-3 btn-lg" type="submit" name="login_ta" value="ยืนยัน">
                                </div>
                                <div class="col d-grid">
                                    <button type="reset" class="btn btn-danger mt-3 btn-lg">ยกเลิก</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Model Add -->

    <!-- Model Add 2 -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fs-3" id="exampleModalLabel">เข้าสู่ระบบสำหรับพี่เลี้ยงของนักศึกษาสหกิจ
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="container">

                            <p class="text-start fs-5">อีเมล</p>
                            <input class="form-control mb-3" name="email_m" type="email" required>

                            <p class="text-start mt-3 fs-5">รหัสผ่าน</p>
                            <input class="form-control" name="password_m" type="password" minlength="5" maxlength="20" required>

                            <div class="row mt-3 mb-4">
                                <div class="col d-grid">
                                    <input class="btn btn-success mt-3 btn-lg" type="submit" name="login_m" value="ยืนยัน">
                                </div>
                                <div class="col d-grid">
                                    <button type="reset" class="btn btn-danger mt-3 btn-lg">ยกเลิก</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Model Add 2 -->

</body>

</html>