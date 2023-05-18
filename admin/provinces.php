<?php
include('../dbconnect.php');
if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM amphures WHERE province_id = '$id' ";
    $query = mysqli_query($conn, $sql);
    echo '<option selected value="">กรุณาเลือกอำเภอ</option>';
    foreach ($query as $value) {
        echo '<option value="' . $value['id'] . '">' . $value['name_th'] . '</option>';
    }
    exit();
}

if (isset($_POST['function']) && $_POST['function'] == 'amphures') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM districts WHERE amphure_id = '$id' ";
    $query = mysqli_query($conn, $sql);
    echo '<option selected value="">กรุณาเลือกตำบล</option>';
    foreach ($query as $value) {
        echo '<option value="' . $value['id'] . '">' . $value['name_th'] . '</option>';
    }
    exit();
}

if (isset($_POST['function']) && $_POST['function'] == 'districts') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM districts WHERE id = '$id' ";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    echo $result['zip_code'];
    exit();
}
