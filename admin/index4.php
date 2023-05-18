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
    // header("refresh:2; url=../home.php");
    session_unset();
    session_destroy();
    header("location: ../home.php");
} else {

    if (isset($_POST['buttona'])) {
        if (isset($_POST['textmes']) || isset($_POST['imge'])) {

            isset($_FILES['imge']) ? $imge = $_FILES['imge'] : $imge = "";
            $textmes = $_POST['textmes'];
            $headding = $_POST['headding'];
            $userpost = $_POST['userpost'];
            $id_userpost = $_POST['id_userpost'];
            $textmes = str_replace(array("ควย", "เหี้ย", "โง่", "สัด", "อีดอก", "อิดอก", "fuck", "สัส",  "ตอแหล", "อีควาย", "อิควาย", "ระยำ", "ช้างเย็ด", "พ่อมึงตาย", "พ่อมืงตาย", "พ่อมิงตาย", "แม่มึงตาย", "แม่มิงตาย", "แม่มืงตาย", "อีกระหรี่", "ลูกกระหรี่", "ช้างลากเย็ด", "อีร้อยควย", "Asshole", "pussy", "dick", "bobo", "Son of a bitch", "Bastard", "สาด", "อีห่า", "หี", "แตด", "ขยะ", "ขยะสังคม", "สวะ", "สถุน", "ไอ้จน", "ไอจน", "กู", "กุ",  "มึง", "มิง", "มืง", "เย็ด", "แม่เย็ด",), "***", $textmes);
            $temp = explode(".", $imge['name']);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $file_ext = strtolower(end($temp));

            $allowed_extensions = array("jpg", "jpeg", "png");
            move_uploaded_file($imge['tmp_name'], "uploads/" . $newfilename);

            $query  =   "INSERT INTO tb_postmessage (id_userpost, textmes, imge, headding, userpost) 
                    VALUES ('$id_userpost', '$textmes', '$newfilename', '$headding', '$userpost')";
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
                            window.location.href = 'index4.php';
                        });
                    });
                    </script>";
            } else {
                echo "<script>
            $(document).ready(function() {
                Swal.fire( {
                    title : 'แจ้งเตือน',
                    text : 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                    icon : 'warning',
                    timer : 2000,
                    showConfirmButton : false
                });
            });
            </script>";
            }
        }
    }

    if (isset($_POST['btnupdate'])) {
        $id = $_POST['id'];
        $textmes = $_POST['textmes'];
        $textmes = str_replace(array("ควย", "เหี้ย", "โง่", "สัด", "อีดอก", "อิดอก", "fuck", "สัส",  "ตอแหล", "อีควาย", "อิควาย", "ระยำ", "ช้างเย็ด", "พ่อมึงตาย", "พ่อมืงตาย", "พ่อมิงตาย", "แม่มึงตาย", "แม่มิงตาย", "แม่มืงตาย", "อีกระหรี่", "ลูกกระหรี่", "ช้างลากเย็ด", "อีร้อยควย", "Asshole", "pussy", "dick", "bobo", "Son of a bitch", "Bastard", "สาด", "อีห่า", "หี", "แตด", "ขยะ", "ขยะสังคม", "สวะ", "สถุน", "ไอ้จน", "ไอจน", "กู", "กุ",  "มึง", "มิง", "มืง", "เย็ด", "แม่เย็ด",), "***", $textmes);
        $headding = $_POST['headding'];
        $id_userpost = $_POST['id_userpost'];

        // check if a new image was uploaded
        if (!empty($_FILES['imge']['name'])) {
            $imge = $_FILES['imge'];
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $imge['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'uploads/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($imge['size'] > 0 && $imge['error'] == 0) {
                    // delete the old image if it exists
                    $sql = "SELECT imge FROM tb_postmessage WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $oldFilePath = 'uploads/' . $row['imge'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }

                    // upload the new image
                    move_uploaded_file($imge['tmp_name'], $filePath);

                    // update the database with the new image filename
                    $sql = "UPDATE tb_postmessage 
                    SET imge = '$fileNew',
                    textmes = '$textmes',
                    headding = '$headding',
                    id_userpost = '$id_userpost'
                    WHERE id = '$id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                        title : 'แก้ไขข้อมูลสำเร็จ',
                        icon : 'success',
                        timer : 2000,
                        showConfirmButton : false
                        }).then(function() {
                            window.location.href = 'index4.php';
                          });
                        });
                        </script>";
                    } else {
                        echo "<script>
                        $(document).ready(function() {
                        Swal.fire( {
                        title : 'แจ้งเตือน',
                        text : 'แก้ไขข้อมูลไม่สำเร็จ!',
                        icon : 'warning',
                        timer : 2000
                        });
                        });
                        </script>";
                    }
                }
            }
        } else {
            // no new image was uploaded, just update the other fields
            $sql = "UPDATE tb_postmessage 
            SET textmes = '$textmes',
            headding = '$headding',
            id_userpost = '$id_userpost'
            WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                title : 'แก้ไขข้อมูลสำเร็จ',
                icon : 'success',
                timer : 2000,
                showConfirmButton : false
                }).then(function() {
                    window.location.href = 'index4.php';
                  });
                });
                </script>";
            } else {
                echo "<script>
                $(document).ready(function() {
                Swal.fire( {
                title : 'แจ้งเตือน',
                text : 'แก้ไขข้อมูลไม่สำเร็จ!',
                icon : 'warning',
                timer : 2000
                });
                });
                </script>";
            }
        }
    }

    if (isset($_POST['btndelimage'])) {
        $id = $_POST['id'];
        $query = "SELECT imge FROM tb_postmessage WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $imageFilePath = 'uploads/' . $row["imge"];
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // ลบไฟล์รูปภาพ
        }

        $query = "UPDATE tb_postmessage SET imge='0' WHERE id='$id'";
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
                        window.location.href = 'index4.php';
                    });
                });
                </script>";
        } else {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: 'ระบบมีปัญหาโปรดลองใหม่อีกครั้ง!',
                        icon: 'warning',
                        timer: 2000,
                        showConfirmButton: false
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

        <!-- nav -->
        <header class="bg-dark p-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
                    <div class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <a class="navbar-brand" href="index.php"><img src="../Logo.png" width="40" height="64"></a>
                    </div>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                        <li><a href="index.php" class="nav-link px-2 link-secondary">&nbsp;&nbsp;<i class="fa-regular fa-message"></i>&nbsp;กระทู้</a></li>
                        <li><a href="form_register.php" class="nav-link px-2 link-light"><i class="fa-solid fa-gears"></i>&nbsp;การจัดการผู้ดูแลระบบ</a></li>
                    </ul>

                    <div class="text-end">
                        <p class="fs-6 text-light p-2 mb-2 justify-content-center badge bg-danger text-wrap"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</p>
                        &nbsp;<a class="btn btn-light p-1" href="../logout.php" role="button"><i class="fa-solid fa-right-from-bracket  text-danger"></i>&nbsp;ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

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

        <!-- ประกาศแจ้งเตือน -->
        <div class="container text-center ">
            <div class="row">
                <div class="col-12 my-3">
                    <span class="badge text-bg-warning w-100 fs-6 p-3 "><i class="fa-regular fa-bell fa-lg "></i>&nbsp;&nbsp;กรุณาออกจากระบบทุกครั้งเมื่อใช้งานเสร็จสิ้น</span>
                </div>
            </div>
        </div>
        <!-- End ประกาศแจ้งเตือน -->

        <div class="container text-center ">
            <div class="row">
                <div class="col-12 col-md-3 col-sm-12 mb-3">
                    <!-- ซ้าย -->
                    <div class="card text-start">
                        <div class="card-header text-start bg-dark text-light fs-5">
                            เอกสาร
                        </div>
                        <div class="card-body bg-light">
                            <?php

                            $result1 = mysqli_query($conn, "SELECT name_file FROM document_file ORDER BY id DESC");
                            if (mysqli_num_rows($result1) > 0) {
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    $name_file = $row["name_file"];
                            ?>

                                    <div class="container text-center">
                                        <div class="row mt-2">
                                            <div class="col col-sm-6 col-md-6 text-start">
                                                <?php echo $row["name_file"]; ?>
                                            </div>
                                            <div class="col col-sm-6 col-md-6 align-self-center">
                                                <a href="download_file.php?filename=<?php echo $name_file; ?>" type="button" class="fa-solid fa-download btn btn-warning" title="คลิกดาวน์โหลด"></a>
                                            </div>
                                        </div>
                                    </div><?php
                                        }
                                    } else {
                                        echo "ไม่มีเอกสาร";
                                    }
                                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9 col-sm-12">
                    <!-- ขวา -->
                    <div class="card text-center mb-3">
                        <div class="card-body bg-light">

                            <form class="row" action="" method="post" enctype="multipart/form-data">
                                <div class="col-12 col-sm-12 col-md-12">

                                    <input type="hidden" name="id_userpost" value="<?php echo $_SESSION['userid_tm']; ?>">

                                    <p><input class="form-control" type="hidden" name="userpost" value="<?php echo $_SESSION['user_tm']; ?>"></p>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupFile01"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                        <input type="file" class="form-control" id="inputGroupFile01" name="imge" accept="image/jpeg, image/png, image/jpg">
                                    </div>

                                    <div class="form-floating">
                                        <input type="hidden" name="headding" class="form-control" id="floatingInput" value="<?php echo $_SESSION['userlevel_tm']; ?>">
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control" type="text" name="textmes" placeholder="ใส่ข้อความ" id="floatingTextarea" style="height: 80px" required></textarea>
                                        <label for="floatingTextarea">ใส่ข้อความ</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-dark form-control mt-3" type="submit" name="buttona" value="โพสต์">
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->

                    <div class="row">
                        <div class="col mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="container text-center">
                                        <div class="row row-cols-5">
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-outline-primary w-100" href="index.php" role="button"><i class="fa-solid fa-users"></i>&nbsp;ทั้งหมด</a>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-outline-primary w-100" href="index1.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;นักศึกษาสหกิจ</a>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-outline-primary w-100" href="index2.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;อาจารย์ที่ปรึกษา</a>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-outline-primary w-100" href="index3.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;พี่เลี้ยงนักศึกษาสหกิจ</a>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-primary w-100" href="index4.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;อาจารย์ประสานงาน</a>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <a class="btn btn btn-outline-primary w-100" href="index5.php" role="button"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- loop โฟสต์ข้อความ -->

                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM `tb_postmessage` WHERE `headding` LIKE '4' ORDER BY `id` DESC");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $a = $row['id'];
                    ?>
                            <div class="card bg-light mb-3">
                                <div class="card-header ">
                                    <div class="row">
                                        <div class="col text-start">
                                            <span class="fs-5"><?php if ($row['headding'] == "1") {
                                                                    echo "นักศึกษาฝึกงาน";
                                                                } else if ($row['headding'] == "2") {
                                                                    echo "อาจารย์ที่ปรึกษา";
                                                                } else if ($row['headding'] == "3") {
                                                                    echo "พี่เลี้ยงของนักศึกษาสหกิจ";
                                                                } else if ($row['headding'] == "4") {
                                                                    echo "อาจารย์ประสานงาน";
                                                                } else if ($row['headding'] == "5") {
                                                                    echo "ผู้ดูแลระบบ";
                                                                } ?>
                                            </span>
                                        </div>

                                        <div class="col text-end">
                                            <?php
                                            $imageFileName = $row["imge"];
                                            $imageFilePath = 'uploads/' . $imageFileName;
                                            $name_comment = $_SESSION['userid_tm'];
                                            ?>

                                            <a href="delmes4.php?delmes4=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" title="ลบข้อมูล">
                                                <i class="fa-solid fa-trash-can" name="del"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (file_exists($imageFilePath)) { ?>
                                            <div class="col-12 text-center">
                                                <img src="<?= $imageFilePath ?>" class="img-fluid rounded mb-3" style="max-height: 300px;">
                                            </div>
                                        <?php } ?>
                                        <div class="col-12 text-start">
                                            <p class="fs-5">
                                                <i class="fa-solid fa-circle-user fa-lg"></i>&nbsp;&nbsp;<?php echo $row["userpost"]; ?>
                                            </p>
                                            <p class="fs-5"><?php echo $row["textmes"]; ?></p>
                                            <div class="text-muted fs-6"><?php
                                                                            setlocale(LC_TIME, "th_TH.UTF-8"); // เลือก locale ภาษาไทย
                                                                            $thai_month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"); // อาเรย์ชื่อเดือนภาษาไทย
                                                                            echo date('d', strtotime($row['date'])) . ' ' . $thai_month[date('m', strtotime($row['date'])) - 1] . ' ' . (date('Y', strtotime($row['date'])) + 543) . ' ' . date('H:i:s', strtotime($row['date'])); // แสดงวันที่ ด้วยเดือนภาษาไทยและปี พ.ศ. และเวลา
                                                                            ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-start">

                                    <a href="form_comment.php?comment=<?php echo $row["id"]; ?>" class="btn"><i class="fa-regular fa-message">&nbsp;&nbsp;แสดงความคิดเห็น</i></a>

                                    <?php $result1 = mysqli_query($conn, "SELECT * FROM `tb_comment` WHERE `id_post` = $a ORDER BY `id` DESC LIMIT 1");
                                    if (mysqli_num_rows($result1) > 0) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $datetime = date_create($row1['time']); // convert date and time format
                                            $thai_year = (int) date_format($datetime, 'Y') + 543; // convert the year to Thai year
                                            $thai_month = [
                                                'January' => 'มกราคม',
                                                'February' => 'กุมภาพันธ์',
                                                'March' => 'มีนาคม',
                                                'April' => 'เมษายน',
                                                'May' => 'พฤษภาคม',
                                                'June' => 'มิถุนายน',
                                                'July' => 'กรกฎาคม',
                                                'August' => 'สิงหาคม',
                                                'September' => 'กันยายน',
                                                'October' => 'ตุลาคม',
                                                'November' => 'พฤศจิกายน',
                                                'December' => 'ธันวาคม',
                                            ];
                                            $month = date_format($datetime, 'F'); // get the month from the datetime string
                                            $thai_month = $thai_month[$month]; // get the Thai month from the array
                                            $datetime = date_format($datetime, 'd ' . $thai_month . ' Y H:i:s'); // format the datetime string with Thai month and year
                                    ?>
                                            <div class="col-10 col-sm-10 mb-2">
                                                <span class="text-muted"><?php echo $datetime; ?></span>
                                                <span><?php echo $row1['recomment_post']; ?></span>
                                                &nbsp;:&nbsp;<span><?php echo $row1['text']; ?></span>
                                            </div>
                                    <?php }
                                    } else {
                                        echo "<p class='mt-2'>ไม่มีการแสดงความคิดเห็น</p>";
                                    }  ?>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "ไม่มีการโพสข้อมูล";
                    }
                    ?>
                    <!-- End loop โฟสต์ข้อความ -->
                </div><!-- col-12 col-md-9 col-sm-12 -->
            </div><!-- row -->
        </div><!-- container -->

        <?php require_once '../design/footer.php'; ?>
    <?php } ?>
    </body>

    </html>