<?php
require_once '../dbconnect.php';
$action = $_POST['action'];
if ($action == 'get_district') {
    $sql = "SELECT * FROM th_district where province_id = '" . $_POST['province_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
    $query = mysqli_query($conn, $sql);
    $district_data = "";
    $district_data .= "<option value=''>เลือกอำเภอ</option>";
    while ($district = mysqli_fetch_array($query)) {
        $district_data .= "<option value='" . $district['district_id'] . "'>" . $district['name_th'] . "</option>";
    }
    echo json_encode($district_data);
    exit();
}
if ($action == 'get_subdistrict') {
    $sql = "SELECT * FROM th_subdistrict where district_id = '" . $_POST['district_id'] . "' order by CONVERT( name_th USING tis620 ) ASC";
    $query = mysqli_query($conn, $sql);
    $subdistrict_data = "";
    $subdistrict_data .= "<option value=''>เลือกตำบล</option>";
    while ($subdistrict = mysqli_fetch_array($query)) {
        $subdistrict_data .= "<option value='" . $subdistrict['subdistrict_id'] . "'>" . $subdistrict['name_th'] . "</option>";
    }
    echo json_encode($subdistrict_data);
    exit();
}
if ($action == 'get_zipcode') {
    $sql = "SELECT * FROM th_subdistrict where subdistrict_id = '" . $_POST['subdistrict_id'] . "'";
    $query = mysqli_query($conn, $sql);
    $subdistrict = mysqli_fetch_array($query);
    $zipcode_data = $subdistrict['zipcode'];
    echo json_encode($zipcode_data);
    exit();
}
