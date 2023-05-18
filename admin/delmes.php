<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once("../dbconnect.php");

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm'] || !$_GET['delmes']) {
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

    isset($_GET['delmes']) ? $id = $_GET['delmes'] : $id = "";

    if ($_GET['delmes']) {

        $sql = "DELETE FROM tb_postmessage WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            $sql = "DELETE FROM tb_comment WHERE id_post = $id";
            $result = mysqli_query($conn, $sql);

            echo "<script>
                            $(document).ready(function() {
                            Swal.fire( {
                                title : 'ลบข้อมูลสำเร็จ',
                                icon : 'success',
                                timer : 2000,
                                showConfirmButton : false
                                }).then(function() {
                                    window.location.href = 'index.php';
                                });
                            });
                        </script>";
        } else {
            echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                    title : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                    icon : 'warning',
                    timer : 2000,
                    showConfirmButton : false
                    }).then(function() {
                        window.location.href = 'index.php';
                    });
            });
            </script>";
        }
    }
}
?>