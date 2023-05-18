<?php
include 'connect.php';
$user_id = $_GET['id'];
$sql = "SELECT * FROM tb_place where id='$user_id'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($query);
$sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
$query_province = mysqli_query($conn, $sql_province);
$sql_district = "SELECT * FROM th_district where province_id = '" . $data['province_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
$query_district = mysqli_query($conn, $sql_district);
$sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '" . $data['district_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
$query_subdistrict = mysqli_query($conn, $sql_subdistrict);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5 text-center mb-3">
                <h3>ระบบ CRUD + Dependent dropdown(จังหวัด อำเภอ ตำบล รหัสไปรษณีย์)</h3>
            </div>
            <div class="col-md-6 mx-auto">
                <form action="update.php?user_id=<?php echo $user_id; ?>" method="post" autocomplete="off">
                    <div class="form-group">
                        <label>ชื่อ</label>
                        <input type="text" class="form-control" placeholder="ชื่อ" name="user_firstname" value="<?php echo $data['user_firstname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" class="form-control" placeholder="นามสกุล" name="user_lastname" value="<?php echo $data['user_lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>รายละเอียดที่อยู่</label>
                        <input type="text" class="form-control" placeholder="รายละเอียดที่อยู่" name="address" value="<?php echo $data['address']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>จังหวัด</label>
                        <select class="form-control" id="province_id" name="province_id" required>
                            <option value="">เลือกจังหวัด</option>
                            <?php while ($province = mysqli_fetch_array($query_province)) { ?>
                                <option <?= ($data['province_id'] == $province['province_id']) ? 'selected' : ''; ?> value="<?php echo $province['province_id'] ?>"><?php echo $province['name_th']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>อำเภอ</label>
                        <select class="form-control" id="district_id" name="district_id" required>
                            <option value="">เลือกอำเภอ</option>
                            <?php while ($district = mysqli_fetch_array($query_district)) { ?>
                                <option <?= ($data['district_id'] == $district['district_id']) ? 'selected' : ''; ?> value="<?php echo $district['district_id'] ?>"><?php echo $district['name_th']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ตำบล</label>
                        <select class="form-control" id="subdistrict_id" name="subdistrict_id" required>
                            <option value="">เลือกตำบล</option>
                            <?php while ($subdistrict = mysqli_fetch_array($query_subdistrict)) { ?>
                                <option <?= ($data['subdistrict_id'] == $subdistrict['subdistrict_id']) ? 'selected' : ''; ?> value="<?php echo $subdistrict['subdistrict_id'] ?>"><?php echo $subdistrict['name_th']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>รหัสไปรษณีย์</label>
                        <input type="text" class="form-control" value="<?php echo $data['zipcode']; ?>" name="zipcode" id="zipcode" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-success">แก้ไขข้อมูล</button>
                            <a href="index.php" class="btn btn-danger">ย้อนกลับ</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js" charset="utf-8"></script>

</body>

</html>