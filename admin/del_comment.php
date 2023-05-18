<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once("../dbconnect.php");

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm'] || !$_GET['delcomment']) {
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

    isset($_GET['delcomment']) ? $id = $_GET['delcomment'] : $id = "";

    $sql = "SELECT * FROM `tb_comment` WHERE `id` = $id ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $id_post = $row['id_post'];

    $id_recomment_post = $row['id_recomment_post'];
    $userid_tm = $_SESSION['userid_tm'];

    if ($id_recomment_post == $_SESSION['userid_tm']) {
        if ($row['headding'] == $_SESSION['userlevel_tm']) {
            $sql = "DELETE FROM `tb_comment` WHERE `id` = $id ";
            $result = mysqli_query($conn, $sql);

            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'ลบความคิดเห็นสำเร็จ',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location = 'form_comment.php?comment=$id_post';
                        });
                    });
                </script>";
        } else {
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'แจ้งเตือน',
                            text: 'ลบไม่ได้ไม่ใช่ข้อความของคุณ',
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location = 'index.php';
                        });
                    });
                </script>";
        }
    } else {
        echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                        icon: 'warning',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location = 'index.php';
                    });
                });
            </script>";
    }
}

?>