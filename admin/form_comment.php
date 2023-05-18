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

    if (isset($_GET['comment']) ? $id = $_GET['comment'] : $id = ""); {
    }

    if (isset($_POST['btncom'])) {

        $id_recomment_post = $_POST['id_recomment_post'];
        $id_post = $_POST['id_post'];
        $recomment_post = $_POST['recomment_post'];
        $text = $_POST['text'];
        $text = str_replace(array("ควย",  "เหี้ย", "โง่", "สัด", "อีดอก", "อิดอก", "fuck", "สัส",  "ตอแหล", "อีควาย", "อิควาย", "ระยำ", "ช้างเย็ด", "พ่อมึงตาย", "พ่อมืงตาย", "พ่อมิงตาย", "แม่มึงตาย", "แม่มิงตาย", "แม่มืงตาย", "อีกระหรี่", "ลูกกระหรี่", "ช้างลากเย็ด", "อีร้อยควย", "Asshole", "pussy", "dick", "bobo", "Son of a bitch", "Bastard", "สาด", "อีห่า", "หี", "แตด", "ขยะ", "ขยะสังคม", "สวะ", "สถุน", "ไอ้จน", "ไอจน", "กู", "กุ",  "มึง", "มิง", "มืง", "เย็ด", "แม่เย็ด",), "***", $text);
        $headding = $_POST['headding'];

        $sql =  "INSERT INTO  tb_comment (id_post, id_recomment_post, recomment_post, text, headding)
                    VALUES ('$id_post', '$id_recomment_post', '$recomment_post', '$text', '$headding')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                                $(document).ready(function() {
                                    Swal.fire( {
                                        title : 'แสดงความคิดเห็นสำเร็จ',
                                        icon : 'success',
                                        timer : 2000,
                                        showConfirmButton : false
                                    }).then(function() {
                                        window.location.href = 'form_comment.php?comment=$id';
                                    });
                                });
                                </script>";
            header("refresh:1;");
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
                            window.location.href = 'form_comment.php?comment=$id';
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
                    window.location.href = 'form_comment.php?comment=$id';
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
                        window.location.href = 'form_comment.php?comment=$id';
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
        <?php $result = mysqli_query($conn, "SELECT * FROM `tb_postmessage` WHERE `id` = '$id' ");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $a = $row['id'];
                $imageFileName = $row["imge"];
                $imageFilePath = '../admin/uploads/' . $imageFileName;
                $name_comment = $_SESSION['userid_tm'];
                $nameuser = $_SESSION['user_tm'];
        ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col text-start">
                                            <span class="fs-5"><?php if ($row['headding'] == "1") {
                                                                    echo "นักศึกษาสหกิจ";
                                                                } else if ($row['headding'] == "2") {
                                                                    echo "อาจารย์ที่ปรึกษา";
                                                                } else if ($row['headding'] == "3") {
                                                                    echo "พี่เลี้ยงนักศึกษาสหกิจ";
                                                                } else if ($row['headding'] == "4") {
                                                                    echo "อาจารย์ประสานงาน";
                                                                } else if ($row['headding'] == "5") {
                                                                    echo "ผู้ดูแลระบบ";
                                                                } ?>
                                            </span>
                                        </div>

                                        <div class="col text-end">

                                            <?php if ($row['id_userpost'] == $_SESSION['userid_tm']) { ?>
                                                <?php if ($row['headding'] == $_SESSION['userlevel_tm']) { ?>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalId<?php echo $a; ?>">
                                                        <i class="fa-solid fa-pen-to-square" title="แก้ไข"></i>
                                                    </button>
                                                <?php }
                                            } else { ?>
                                                <span></span>
                                            <?php } ?>

                                            <!-- Modal Body -->
                                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                            <div class="modal fade" id="modalId<?php echo $a; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #ffd966;">
                                                            <div class="fs-5">
                                                                <i class="fa-solid fa-circle-user fa-lg"></i>&nbsp;&nbsp;<?php echo $row["userpost"]; ?>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $a; ?>">
                                                                <?php if (isset($row["imge"]) && (strpos($row["imge"], ".png") !== false || strpos($row["imge"], ".jpeg") !== false || strpos($row["imge"], ".jpg") !== false)) { ?>
                                                                    <div class="row align-items-center">
                                                                        <div class="col text-end">
                                                                            <button type="submit" class="btn btn-sm btn-danger" name="btndelimage"><i class="fa-solid fa-trash-can"></i>&nbsp;ลบรูปภาพ</button>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <span></span>
                                                                <?php } ?>
                                                            </form>
                                                            <form method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $a; ?>">
                                                                <?php if (!empty($imageFileName) && file_exists($imageFilePath)) { ?>
                                                                    <div class="col-12 text-center">
                                                                        <img src="<?= $imageFilePath ?>" class="img-fluid rounded mb-3" style="max-height: 300px;">
                                                                    </div>
                                                                <?php } ?>
                                                                <input type="hidden" name="headding" class="form-control" id="floatingInput" value="<?php echo $_SESSION['userlevel_tm']; ?>">
                                                                <input type="hidden" name="id_userpost" value="<?php echo $_SESSION['userid_tm']; ?>">

                                                                <div class="input-group mb-3">
                                                                    <label class="input-group-text" for="inputGroupFile02"><i class="fa-regular fa-image"></i>&nbsp;รูปภาพ</label>
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="imge" accept="image/jpeg, image/png, image/jpg" value="<?php echo $imageFileName; ?>">
                                                                </div>
                                                                <div class="form-floating mb-2">
                                                                    <textarea class="form-control" id="floatingTextarea2" name="textmes" style="height: 100px"><?php echo $row["textmes"]; ?></textarea>
                                                                    <label for="floatingTextarea2">ใส่ข้อความ</label>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer" style="background-color: #ffd966;">
                                                            <button type="submit" class="btn btn-success" name="btnupdate"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="delmes.php?delmes=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" title="ลบข้อมูล">
                                                <i class="fa-solid fa-trash-can" name="del"></i></a>

                                        </div>
                                    </div>
                                </div>
                                <!-- แสดงโพสต์ -->
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
                                <div class="card-footer">
                                    <form method="post">
                                        <p class="mt-3 fs-6">&nbsp;&nbsp;<i class="fa-solid fa-circle-user fa-lg mr-auto"></i>&nbsp;&nbsp;<?php echo $_SESSION['user_tm']; ?>
                                        </p>
                                        <div class="input-group ">
                                            <input type="hidden" name="id_post" value="<?php echo $a; ?>">
                                            <input type="hidden" name="headding" value="<?php echo $_SESSION['userlevel_tm']; ?>">
                                            <input type="hidden" name="recomment_post" value="<?php echo $nameuser; ?>">
                                            <input type="hidden" name="id_recomment_post" value="<?php echo $name_comment; ?>">
                                            <input type="text" class="form-control" placeholder="แสดงความคิดเห็น" aria-describedby="button-addon2" name="text">
                                            <input class="btn btn-primary" type="submit" id="button-addon2" name="btncom" value="ส่ง">
                                        </div>
                                    </form>

                                    <?php
                                    $result2 = mysqli_query($conn, "SELECT * FROM `tb_comment` WHERE `id_post` = '$a'  ORDER BY `id` DESC ");
                                    if (mysqli_num_rows($result2) > 0) {
                                        while ($row = mysqli_fetch_array($result2)) {
                                            $datetime = date_create($row['time']); // convert date and time format
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
                                            $datetime = date_format($datetime, 'd ' . $thai_month . ' Y H:i:s');
                                    ?>
                                            <div class="row align-items-center">
                                                <div class="col-10 col-sm-10 my-2 fs-5">
                                                    <div class="mb-2"><?php echo $row['recomment_post']; ?></div>
                                                    <div class="badge rounded-pill text-bg-light"><?php echo $row['text']; ?></div>
                                                </div>


                                                <?php if ($row['id_recomment_post'] == $_SESSION['userid_tm'] && $row['headding'] == $_SESSION['userlevel_tm']) {
                                                    // แสดงปุ่มลบคอมเม้นเมื่อ id_recomment_post และ headding เท่ากับค่าในฐานข้อมูล
                                                    echo '<div class="col-2 col-sm-2 text-end mt-2 fs-5">
                                                                    <a href="del_comment.php?delcomment=' . $row['id'] . '" class="btn" onclick="return confirm(\'คุณต้องการลบข้อมูลหรือไม่\')" title="ลบคอมเม้น"><i class="fa-solid fa-trash-can" name="del"></i></a>
                                                                </div>';
                                                } else {
                                                } ?>

                                                <span class="text-muted "><?php echo $datetime; ?></span>

                                            </div>
                                    <?php }
                                    } else {
                                        echo "<p class='mt-2'>ไม่มีการแสดงความคิดเห็น</p>";
                                    }  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "ไม่มีการโพสต์ข้อความ";
        }
        ?>


        <?php require_once '../design/footer.php'; ?>
    <?php } ?>
    </body>

    </html>