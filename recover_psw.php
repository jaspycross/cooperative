<?php session_start() ?>
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<!doctype html>
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


    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-8 col-sm-8 col-md-8">
                <div class="card my-5">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="true" href="recover_psw.php">นักศึกษาสหกิจ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="recover_psw1.php">อาจารย์ที่ปรึกษาหรืออาจารย์ประสานงาน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="recover_psw2.php">พี่เลี้ยงนักศึกษาสหกิจ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="text-center mt-5 my-3 fs-5">ลืมรหัสผ่าน ?</div>
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-end">อีเมล</label>
                                <div class="col-md-6">
                                    <input type="email" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input class="btn btn-dark mt-3" type="submit" value="ยันยืน" name="recover">
                                <a class="btn btn-danger mt-3" href="home.php" onclick="return confirm('ต้องการยกเลิกการส่งข้อมูลหรือไม่')"> ยกเลิก</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </main>

    <?php require_once 'design/footer.php'; ?>
</body>

</html>

<?php
if (isset($_POST["recover"])) {
    require_once 'dbconnect.php';
    $email = $_POST["email"];

    $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
    $query = mysqli_num_rows($sql);
    $fetch = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) <= 0) {
?>
        <?php
        echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'ไม่มีอีเมลในระบบ!!!',
                icon : 'error'
            }).then(function() {
                window.location.href = 'recover_psw.php';
            });
        });
        </script>";
        ?>
    <?php
    } else if ($fetch["userlevel"] != 1) {
    ?>
        <?php
        echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'กรุณาสมัครสมาชิกก่อน!!!',
                icon : 'warning'
            }).then(function() {
                window.location.href = 'recover_psw.php';
            });
        });
        </script>";
        ?>
        <?php
    } else {
        // generate token by binaryhexa 
        $token = bin2hex(random_bytes(50));

        //session_start ();

        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;


        require "Mail/phpmailer/PHPMailerAutoload.php";
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
        //$mail->addReplyTo('lamkaizhe16@gmail.com');

        // HTML body
        $mail->isHTML(true);
        $mail->Subject = "รีเซ็ตรหัสผ่าน";
        $mail->CharSet = 'UTF-8'; // กำหนด charset เป็น UTF-8
        $mail->Encoding = 'base64'; // กำหนดวิธีการเข้ารหัสเป็น base64
        $mail->Body = "
         
            <p>กรุณาคลิกที่ลิงค์ด้านล่างเพื่อรีเซ็ตรหัสผ่านของคุณ</p>
            http://localhost/project1/reset_psw.php
            ";

        if (!$mail->send()) {
        ?>
            <?php
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
            ?>
        <?php
        } else {
        ?>

            <?php
            echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                title : 'ส่งอีเมลสำเร็จ',
                text : 'กรุณาเช็คที่อีเมลของคุณ',
                icon : 'success'
                });
                });
                </script>";
            ?>
            <!-- <script>
                        window.location.replace("notification.html");
                    </script> -->
<?php
        }
    }
}

?>