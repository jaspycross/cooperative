<!-- เสร็จสมบรูณ์ -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>

<?php
session_start();
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css" />
<?php require_once 'design/head.php'; ?>

<body>

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

    <!-- nav -->
    <header class="bg-dark p-4 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start ">
                <div class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <img src="Logo.png" width="40" height="64">&nbsp;&nbsp;
                    <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Logo"><use xlink:href="#Logo"></use></svg> -->
                </div>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center fs-5 mb-md-0">
                    <li><a href="indexmes.php" class="nav-link px-2 link-secondary"><i class="fa-regular fa-message"></i>&nbsp;&nbsp;กระทู้</a></li>
                    <li><a href="index2.php" class="nav-link px-2 link-light"><i class="fa-solid fa-map-location-dot"></i>&nbsp;&nbsp;สถานที่ฝึกสหกิจศึกษา</a></li>
                </ul>
                <a class="btn btn btn-outline-light" href="home.php" role="button"><i class="fa-solid fa-lock"></i>&nbsp;เข้าสู่ระบบ</a>
            </div>
        </div>
    </header>
    <!-- End nav -->

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
                <div class="row">
                    <div class="col mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="container text-center">
                                    <div class="row row-cols-5">
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-outline-primary w-100" href="indexmes.php" role="button"><i class="fa-solid fa-users"></i>&nbsp;ทั้งหมด</a>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-outline-primary w-100" href="indexmes1.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;นักศึกษาสหกิจ</a>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-outline-primary w-100" href="indexmes2.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;อาจารย์ที่ปรึกษา</a>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-outline-primary w-100" href="indexmes3.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;พี่เลี้ยงนักศึกษาสหกิจ</a>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-outline-primary w-100" href="indexmes4.php" role="button"><i class="fa-solid fa-user"></i>&nbsp;อาจารย์ประสานงาน</a>
                                        </div>
                                        <div class="col-12 col-sm-4 mb-2">
                                            <a class="btn btn btn-primary w-100" href="indexmes5.php" role="button"><i class="fa-solid fa-user-shield"></i>&nbsp;ผู้ดูแลระบบ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- loop โฟสต์ข้อความ -->
                <?php
                $result = mysqli_query($conn, "SELECT * FROM `tb_postmessage` WHERE `headding` LIKE '5' ORDER BY `id` DESC");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $a = $row['id'];
                ?>
                        <div class="card bg-light mb-3">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col text-start">
                                        <span class="fs-5"><?php if ($row['headding'] == "1") {
                                                                echo "นักศึกษาสหกิจ";
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
                                </div>
                            </div>
                            <?php
                            $imageFileName = $row["imge"];
                            $imageFilePath = 'admin/uploads/' . $imageFileName;
                            ?>
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
                                <button type="button" class="btn border border-0 disabled" name="btnindexmes"><i class="fa-regular fa-message">&nbsp;&nbsp;แสดงความคิดเห็น</i></button>
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

    <?php require_once 'design/footer.php'; ?>
</body>

</html>