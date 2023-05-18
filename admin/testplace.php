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
  </>";
    // header("refresh:2; url=../home.php");
    session_destroy();
    header("location: ../home.php");
} else {

    if (isset($_GET['editplace']) ? $id = $_GET['editplace'] : $id = ""); {
        // $sql = "SELECT * FROM tb_place WHERE id = $id";
        // $result = mysqli_query($conn,$sql);
        // $row = mysqli_fetch_assoc($result);

    }


    if (isset($_POST['btnsubmit'])) {
        isset($_FILES['imge']) ? $imge = $_FILES['imge'] : $imge = "";
        $company_name = $_POST['company_name'];
        $orgorcom = $_POST['orgorcom'];
        $address = $_POST['address'];
        $county = $_POST['county'];
        $district = $_POST['district'];
        $postcode = $_POST['postcode'];
        $url = $_POST['url'];
        // $imge = $_POST['imge'];

        $temp = explode(".", $imge['name']);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $file_ext = strtolower(end($temp));

        $allowed_extensions = array("jpg", "jpeg", "png");
        move_uploaded_file($imge['tmp_name'], "../admin/place/" . $newfilename);

        $sql = "INSERT INTO tb_place( company_name, orgorcom, address, county, district, postcode, imge, url)
          VALUE ('$company_name', '$orgorcom', '$address', '$county', '$district', '$postcode', '$newfilename', '$url')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire( {
                        title : 'บันทึกข้อมูลเรียบร้อย',
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
                text : 'มีปัญหาในการนำเข้าข้อมูล ลองใหม่อีกครั้ง!',
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
        $orgorcom = $_POST['orgorcom'];
        $address = $_POST['address'];
        $county = $_POST['county'];
        $district = $_POST['district'];
        $postcode = $_POST['postcode'];
        $url = $_POST['url'];
        $img = $_FILES['imge'];

        isset($_POST['img2']) ? $img2 = $_POST['img2'] : $img2 = "";
        // $img2 = $_POST['img2'];
        $upload = $_FILES['imge']['name'];

        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = 'place/' . $fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    move_uploaded_file($img['tmp_name'], $filePath);
                }
            }
        } else {
            $fileNew = $img2;
        }

        $sql = "UPDATE tb_place set orgorcom = '$orgorcom',
    address = '$address',
    county = '$county',
    district = '$district',
    postcode = '$postcode',
    url = '$url',
    imge = '$fileNew' 
    WHERE id = '$id' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>
      $(document).ready(function() {
      Swal.fire( {
          title : 'อัพเดตเรียบร้อย',
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
          text : 'แก้ไขข้อมูลไม่สำเร็จ!',
          icon : 'warning',
          timer : 2000
          });
  });
  </script>";
        }
    }

?>


    </script>
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
                        <li><a href="index.php" class="nav-link px-2 link-light">&nbsp;&nbsp;<i class="fa-regular fa-message"></i>&nbsp;กระทู้</a></li>
                        <li><a href="place.php" class="nav-link px-2 link-secondary"><i class="fa-solid fa-gears"></i>&nbsp;การจัดการแอดมิน</a></li>
                    </ul>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle"> -->
                            <p class="fs-6 fw-bold text-light p-2 text-center badge bg-danger text-wrap">แอดมิน</p>
                            &nbsp;&nbsp;
                            <?php //echo $_SESSION['user_tm']; 
                            ?>&nbsp;&nbsp;<i class="fa-solid fa-user-gear fa-xl">
                            </i>
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="profile_tm.php">โปรไฟล์</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- End nav -->

        <div class="container-fluid">
            <div class="row justify-content-start">
                <div class="col-12 col-md-3 col-sm-12 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="accordion accordion-flush border" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    <i class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูลสมาชิก</button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_register.php" class="text-decoration-none text-dark">เพิ่มนักศึกษาสหกิจศึกษา</a></li>
                                        <li class="list-group-item"><a href="form_register2.php" class="text-decoration-none text-dark ">เพิ่มข้อมูลอาจารย์ที่ปรึกศึกษาหรืออาจารย์ประสานงาน</a></li>
                                        <li class="list-group-item"><a href="form_register3.php" class="text-decoration-none text-dark">เพิ่มข้อมูลพี่เลี้ยงของนักศึกษาสหกิจ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    <i class="fa-solid fa-user-plus"></i>&nbsp;เพิ่มข้อมูลหลายคน</button>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_csv.php" class="text-decoration-none text-dark">เพิ่มนักศึกษาสหกิจศึกษา</a></li>
                                        <li class="list-group-item"><a href="form_csv2.php" class="text-decoration-none text-dark">เพิ่มข้อมูลอาจารย์ที่ปรึกศึกษาหรืออาจารย์ประสานงาน</a></li>
                                        <li class="list-group-item"><a href="form_csv3.php" class="text-decoration-none text-dark">เพิ่มข้อมูลพี่เลี้ยงของนักศึกษาสหกิจ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    <i class="fa-solid fa-file-circle-plus"></i>&nbsp;เพิ่มไฟล์เอกสาร
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="form_file.php" class="text-decoration-none text-dark">เพิ่มไฟล์เอกสาร</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse4" aria-expanded="false" aria-controls="panelsStayOpen-collapse4">
                                    <i class="fa-solid fa-location-dot"></i>&nbsp;เพิ่มสถานที่ฝึกงาน
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse4" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading4">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush h6">
                                        <li class="list-group-item"><a href="place.php" class="text-decoration-none">เพิ่มสถานที่ฝึกงาน</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ul>
                </div>


                <!-- Button trigger modal -->
                <div class="col-12 col-md-9 mb-0 mb-md-0 mb-sm-3 g-0">
                    <div class="mt-3 mt-md-3 mt-sm-3 mx-2 mx-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="container mt-3 text-center">
                                    <button type="button" class="btn btn-primary p-3 w-25 my-3" data-bs-toggle="modal" data-bs-target="#exampleModal" title="เพิ่มสถานที่ฝึกงาน">
                                        <i class="fa-solid fa-plus fa-lg"></i>&nbsp;&nbsp;สถานที่ฝึกงาน</button>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #003366;">
                                            <div class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot fs-3"></i>&nbsp;&nbsp;เพิ่มสถานที่สถานที่ฝึกงาน</div>
                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="background-color: #e5eaef;">

                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row justify-content-center align-items-center g-2 mt-3">
                                                    <div class="col-12 col-md-6 col-sm-12 mt-2 mt-md-0 mt-sm-0">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingInput" name="company_name" placeholder="ชื่อบริษัท" required>
                                                            <label for="floatingInput">ชื่อบริษัท</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-sm-12 mt-3 mt-md-0 mt-sm-3">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" name="orgorcom" aria-label="Floating label select example" required>
                                                                <option selected value="บริษัท">บริษัท</option>
                                                                <option value="องกรณ์">องกรณ์</option>
                                                            </select>
                                                            <label for="floatingSelect">เป็นบริษัทหรือองกรณ์</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center align-items-center mt-3">
                                                    <div class="col-12 col-md-4 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="floatingInput2" name="county" placeholder="จังหวัด" required>
                                                            <label for="floatingInput2">จังหวัด</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="floatingInput3" name="district" placeholder="เขต / อำเภอ" required>
                                                            <label for="floatingInput3">เขต / อำเภอ</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="floatingInput4" name="postcode" placeholder="รหัสไปรษณีย์" maxlength="5" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                            <label for="floatingInput4">รหัสไปรษณีย์</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center align-items-center g-2 ">
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" id="floatingTextarea2" name="address" style="height: 100px" placeholder="รายละเอียดที่อยู่" required></textarea>
                                                        <label for="floatingTextarea2">รายละเอียดที่อยู่</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingInput5" placeholder="เพิ่มลิ้งค์" name="url">
                                                        <label for="floatingInput5">เพิ่มลิ้งค์</label>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label"></label>
                                                        <input class="form-control" type="file" name="imge" id="formFile" accept="image/jpeg, image/png, image/jpg" required>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="btnsubmit"><i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;&nbsp;บันทึก</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="container my-2 fs-5">
                                <form action="testplace.php?load=SUBMIT" method="get">
                                    <p class="form-label text-center mt-3">&nbsp;&nbsp;ค้นหาสถานที่</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-describedby="button-addon2" name="ename">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2" title="ค้นหา"><i class="fa-solid fa-magnifying-glass fa-lg"></i>&nbsp;&nbsp;</button>
                                    </div>
                                    <div class="text-start">
                                        <label class="fs-5 text-muted"><i class="fa-solid fa-thumbtack fa-lg"></i>&nbsp;&nbsp;กด "ค้นหา" ไม่ต้องกรอกข้อมูลจะแสดงข้อมูลทั้งหมด </label>
                                    </div>
                                </form>
                            </div>

                            <?php
                            if (isset($_GET['ename']) ? $name = $_GET['ename'] : $name = ""); {
                                // $sql = "SELECT * FROM tb_place WHERE company_name LIKE '$name%' OR `orgorcom` LIKE '$name%' OR `address` LIKE '$name%' OR provinces LIKE '$name%' OR amphures LIKE '$name%' OR districts LIKE '$name%' OR zip_code LIKE '$name%' ORDER BY id DESC";
                                $sql = "SELECT 
                                tb_place.id,
                                tb_place.company_name,
                                tb_place.orgorcom,	 
                                tb_place.address,
                                tb_place.provinces,
                                provinces.name_th AS provincesname, 
                                tb_place.amphures,
                                amphures.name_th AS amphuresname, 
                                tb_place.districts,
                                districts.name_th AS districtsname, 
                                tb_place.zip_code,
                                tb_place.imge,
                                tb_place.url,
                                tb_place.time
                                FROM tb_place
                                LEFT JOIN provinces
                                ON tb_place.provinces = provinces.id 
                                LEFT JOIN amphures
                                ON tb_place.amphures = amphures.id
                                LEFT JOIN districts
                                ON tb_place.districts = districts.id
                                WHERE 
                                tb_place.company_name LIKE '$name%' OR 
                                tb_place.orgorcom LIKE '$name%' OR 
                                tb_place.address LIKE '$name%' OR 
                                provinces.name_th LIKE '$name%' OR 
                                amphures.name_th LIKE '$name%' OR 
                                districts.name_th LIKE '$name%' OR 
                                tb_place.zip_code LIKE '$name%' ORDER BY tb_place.id DESC ";
                                $result = mysqli_query($conn, $sql);
                            }
                            ?>

                            <div class="container  fs-5">
                                <?php if (mysqli_num_rows($result) > 0) { ?>
                                    <div class="row ">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <div class="col-12 col-md-12 my-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row justify-content-center align-items-center g-2">
                                                            <div class="col">
                                                                <div class="btn-group dropend">
                                                                    <button type="button" class="btn btn-light dropdown-toggle fs-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-map-location-dot fa-lg"></i>&nbsp;&nbsp;<?php echo $row['company_name']; ?>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <?php echo $row['url']; ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col text-end">
                                                                <!-- btn model  -->
                                                                <button type="button" class="btn btn-warning p-3" title="แก้ไขข้อมูล" data-bs-toggle="modal" data-bs-target="#modaledit<?php echo $row['id']; ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i></button>
                                                                <!-- model  -->
                                                                <div class="modal fade" id="modaledit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background-color: #ffd966;">
                                                                                <h5 class="modal-title" id="modalTitleId"><?php echo $row['company_name']; ?></h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body" style="background-color: #ffecb2;">

                                                                                <form method="post" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                    <div class="row justify-content-center align-items-center my-3">
                                                                                        <div class="col-12 col-md-6 col-sm-12">
                                                                                            <div class="form-floating">
                                                                                                <input type="text" class="form-control" id="floatingInput6" name="company_name" placeholder="บริษัท" value="<?php echo $row['company_name']; ?>" required>
                                                                                                <label for="floatingInput6">บริษัท</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php $orgorcom = $row['orgorcom']; ?>
                                                                                        <div class="col-12 col-md-6 col-sm-12">
                                                                                            <div class="form-floating">
                                                                                                <select class="form-select" id="floatingSelect" name="orgorcom" aria-label="Floating label select example" required>
                                                                                                    <option selected value="<?php echo $orgorcom; ?>">
                                                                                                        <?php if ($row['orgorcom'] == "บริษัท") {
                                                                                                            echo "บริษัท";
                                                                                                        } else if ($row['orgorcom'] == "องกรณ์") {
                                                                                                            echo "องกรณ์";
                                                                                                        } ?>
                                                                                                    </option>
                                                                                                    <option value="บริษัท">บริษัท</option>
                                                                                                    <option value="องกรณ์">องกรณ์</option>
                                                                                                </select>
                                                                                                <label for="floatingSelect">เป็นบริษัทหรือองกรณ์</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row justify-content-center align-items-center my-3">
                                                                                        <div class="col-12 col-md-4 col-sm-12">
                                                                                            <div class="form-floating">
                                                                                                <input type="text" class="form-control" id="floatingInput7" name="provinces" placeholder="จังหวัด" value="<?php echo $row['provinces']; ?>" required>
                                                                                                <label for="floatingInput7">จังหวัด</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-12 col-md-4 col-sm-12">
                                                                                            <div class="form-floating">
                                                                                                <input type="text" class="form-control" id="floatingInput8" name="district" placeholder="เขต / อำเภอ" value="<?php echo $row['district']; ?>" required>
                                                                                                <label for="floatingInput8">เขต / อำเภอ</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-12 col-md-4 col-sm-12">
                                                                                            <div class="form-floating">
                                                                                                <input type="text" class="form-control" id="floatingInput8" name="postcode" placeholder="รหัสไปรษรีย์" value="<?php echo $row['postcode']; ?>" maxlength="5" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                                                                <label for="floatingInput8">รหัสไปรษรีย์</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text" class="form-control" id="floatingInput10" name="address" placeholder="รายละเอียดที่อยู่" value="<?php echo $row['address']; ?>" required>
                                                                                        <label for="floatingInput10">รายละเอียดที่อยู่</label>
                                                                                    </div>
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text" class="form-control" id="floatingInput9" name="url" placeholder="รายละเอียดที่อยู่" required>
                                                                                        <label for="floatingInput9">เพิ่มลิ้งค์</label>
                                                                                    </div>
                                                                                    <div class="input-group mb-3">
                                                                                        <label class="input-group-text" for="inputGroupFile01">รูปภาพ</label>
                                                                                        <input type="file" name="imge" class="form-control" id="inputGroupFile01" accept="image/*" value="<?php echo $row['imge']; ?>" required>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer" style="background-color: #fffbef;">
                                                                                <button type="submit" name="btnupdate" class="btn btn-warning">อัพเดต</button>
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End model -->

                                                                <a href="del_place.php?delplace=<?php echo $row["id"]; ?>" class="btn btn-danger p-3" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')" title="ลบ"><i class="fa-solid fa-trash-can"></i></a>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row justify-content-center align-items-center g-2">
                                                            <div class="col-12 col-md-6 col-sm-12 text-center">
                                                                <img src="place/<?php echo $row["imge"]; ?>" class="img-fluid rounded my-2" style="max-height:  400px; max-width: 90%;">
                                                            </div>
                                                            <div class="col-12 col-md-6 col-sm-12">
                                                                <p><?php echo $row['orgorcom']; ?></p>
                                                                <p><?php echo $row['address']; ?></p>
                                                                <p><?php echo $row['provincesname']; ?></p>
                                                                <p><?php echo $row['amphuresname']; ?></p>
                                                                <p><?php echo $row['districtsname']; ?></p>
                                                                <p><?php echo $row['zip_code']; ?></p>
                                                                <p><?php echo $row['time']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                            </div>
                        <?php } else {
                                    echo '<div class="container text-center"><div class="card bg-dark text-light p-5 my-3">' . "ไม่มีข้อมูลลองค้นหาข้อมูลอีกครั้ง" . '</div></div>';
                                } ?>
                        </div>
                    </div>
                </div>
                <?php require_once '../design/footer.php'; ?>
            <?php } ?>
    </body>

    </html>