<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
    extract($_REQUEST);
    require_once '../dbconnect.php';

    $sql=mysqli_query($conn,"SELECT * FROM document_file WHERE id='$del'");
    $row=mysqli_fetch_array($sql);

    unlink("files/$row[name_file]");

    mysqli_query($conn,"DELETE FROM document_file WHERE id='$del'");

    echo "<script>
        $(document).ready(function() {
          Swal.fire( {
              title : 'ลบเอกสารสำเร็จ',
              icon : 'error',
              timer : 2000,
              showConfirmButton : false
            }).then(function() {
              window.location.href = 'form_file.php';
            });
        });
      </script>";

?>