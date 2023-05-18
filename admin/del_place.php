<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once("../dbconnect.php");

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm'] || !$_GET['delplace']) {
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

    isset($_GET['delplace']) ? $id = $_GET['delplace'] : $id = "";

    if ($_GET['delplace']) {

        $sql = "DELETE FROM tb_place WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                            title : 'ลบข้อมูลสำเร็จ',
                            icon : 'error',
                            timer : 2000,
                            showConfirmButton : false
                            }).then(function() {
                                window.location.href = 'place.php';
                            });
                        });
                    </script>";
        } else {
            echo "<script>
            $(document).ready(function() {
            Swal.fire( {
                title : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
                icon : 'warning',
                timer : 2000,
                showConfirmButton : false
                }).then(function() {
                    window.location.href = 'place.php';
                });
        });
        </script>";
        }
    }
}
?>