<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
<?php
session_start();
require '../dbconnect.php';

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
    // header("refresh:2; url=../home.php");
    session_unset();
    session_destroy();
    header("location: ../home.php");
} else {

    (isset($_GET['edituser']) ? $id = $_GET['edituser'] : $id = "");

    if (isset($_POST['btnupdate'])) {
        $id = $_POST['id'];
        $company_name = $_POST['company_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $province_id = $_POST['province_id'];
        $district_id = $_POST['district_id'];
        $subdistrict_id = $_POST['subdistrict_id'];
        $zipcode = $_POST['zipcode'];
        $url = $_POST['url'];

        // check if a new image was uploaded
        if (!empty($_FILES['imge']['name'])) {
            $imge = $_FILES['imge'];
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $imge['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'place/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($imge['size'] > 0 && $imge['error'] == 0) {
                    // delete the old image if it exists
                    $sql = "SELECT imge FROM tb_place WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'place/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        if (is_file($oldFilePath)) { // เพิ่มเงื่อนไขนี้
                            unlink($oldFilePath);
                        }
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);

                    $sql = "UPDATE tb_place 
    SET company_name = '$company_name',
    address = '$address',
    email = '$email',
    phonenumber = '$phonenumber',
    province_id = '$province_id',
    district_id = '$district_id',
    subdistrict_id = '$subdistrict_id',
    zipcode = '$zipcode',
    url = '$url',
    imge = '$fileNew' 
    WHERE id = '$id'";
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
                              window.location.href = 'place.php';
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
    }).then(function() {
        window.location.href = 'place.php';
      });
});
</script>";
                    }
                }
            }
        } else {
            // no new image was uploaded, just update the other fields
            $sql = "UPDATE tb_place 
            SET company_name = '$company_name',
            address = '$address',
            email = '$email',
            phonenumber = '$phonenumber',
            province_id = '$province_id',
            district_id = '$district_id',
            subdistrict_id = '$subdistrict_id',
            zipcode = '$zipcode',
            url = '$url'
            WHERE id = '$id'";
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
        timer : 2000
    }).then(function() {
        window.location.href = 'place.php';
        });
        });
        </script>";
            }
        }
    }
}
