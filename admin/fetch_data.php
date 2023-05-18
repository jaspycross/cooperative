<?php
require_once "../dbconnect.php";

// รับค่าจาก JavaScript
$select1Value = $_POST['select1Value'];

// เขียนคำสั่ง SQL สำหรับดึงข้อมูลตามค่าที่ได้รับ
$sql = "SELECT 
tb_branch.idbranch,
tb_branch.iddepartment,
tb_branch.branch,
department.namedepartment,
tb_branch.status_branch
FROM tb_branch
LEFT JOIN department ON tb_branch.iddepartment = department.id
WHERE iddepartment = '$select1Value' AND `status_branch` = 1";

// ดำเนินการค้นหาในฐานข้อมูล
$result = mysqli_query($conn, $sql);

// สร้างตัวเลือกสำหรับ select 2 โดยใช้ข้อมูลที่ได้รับ
$options = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row["idbranch"] . "'>" . $row["branch"] . "</option>";
    }
} else {
    $options = "<option value=''>ไม่พบข้อมูล</option>";
}

// ส่งค่ากลับไปยัง JavaScript
echo $options;
