<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once '../dbconnect.php';

if ($_SESSION['userlevel_tm'] != '5' || !$_SESSION['userlevel_tm'] || !$_GET['del']) {
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
  </>";
    // header("refresh:2; url=../home.php");
    session_destroy();
    header("location: ../home.php");
} else {
    isset($_GET['del']) ? $id = $_GET['del'] : $id = "";

    if ($_GET['del']) {

        $query = "SELECT imge FROM tb_place WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $imageFilePath = 'place/' . $row["imge"];
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // ลบไฟล์รูปภาพ
        }

        $query = "UPDATE tb_place SET imge='0' WHERE id='$id'";
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
            window.location.href = 'place.php';
        });
    });
</script>";
        } else {
            echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'แจ้งเตือน',
            text: 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง',
            icon: 'warning',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>";
        }
    }
}
