<?php session_start();
require_once 'dbconnect.php';
?>
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
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                    <li><a href="home.php" class="nav-link px-2 link-light"><i class="fa-solid fa-chevron-left"></i>&nbsp;กลับ</a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- End nav -->

    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-8 col-md-8 col-sm-8">
                    <div class="card my-5">
                        <div class="card-header">เปลี่ยนรหัสผ่านของคุณ</div>
                        <div class="card-body">
                            <form action="#" method="POST" name="login">

                               
                            <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่านใหม่</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password_m" minlength="5" maxlength="20" required autofocus>
                                        <i class="fa-regular fa-eye-slash mt-3" id="togglePassword"></i>
                                    </div>
                                </div>
                                <p></p>
                                <div class="form-group row">
                                    <label for="password_confirm" class="col-md-4 col-form-label text-md-right">ยันยืนรหัสผ่าน</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password_confirm" class="form-control" name="password_confirm_m"  minlength="5" maxlength="20" required>
                                        <i class="fa-regular fa-eye-slash mt-3" id="togglePasswordConfirm"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <input class="btn btn-dark mt-3" type="submit" value="เปลี่ยนรหัสผ่าน" name="reset">
                                    <input type="button" class="btn btn-danger mt-3" value="ยกเลิก" onclick="window.location.href='home.php'">
                                </div>
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
if (isset($_POST["reset"])) {
    $psw = $_POST["password_m"];
    $psw_confirm = $_POST["password_confirm_m"];
    $token = $_SESSION['token'];
    $Email = $_SESSION['email_m'];

    // $hash = password_hash( $psw , PASSWORD_DEFAULT );

    $sql = mysqli_query($conn, "SELECT * FROM tb_mentor WHERE email_m ='$Email'");
    $query = mysqli_num_rows($sql);
    $fetch = mysqli_fetch_assoc($sql);

    if ($Email) {
        $passwordenc = md5($psw);
        // $new_pass = $hash;
        mysqli_query($conn, "UPDATE tb_mentor SET password_m='$passwordenc' WHERE email_m ='$Email'");
?>
        <?php
        echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                title : 'เปลี่ยนรหัสผ่านสำเร็จ',
                icon : 'success',
                timer : 2000,
                showConfirmButton : false
                }).then(function() {
                window.location.href = 'home.php';
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
                title : 'แจ้งเตือน',
                text : 'รหัสผ่านไม่ถูกต้อง',
                icon : 'warning',
                timer : 2000,
                showConfirmButton : false
                });
            });
            </script>";
        ?>

<?php
    }
}

?>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');

    togglePassword.addEventListener('click', function() {
    if (password.type === "password") {
        password.type = 'text';
    } else {
        password.type = 'password';
    }
    this.classList.toggle('fa-eye');
});

    togglePasswordConfirm.addEventListener('click', function() {
    if (passwordConfirm.type === "password") {
        passwordConfirm.type = 'text';
    } else {
        passwordConfirm.type = 'password';
    }
    this.classList.toggle('fa-eye');
});
</script>