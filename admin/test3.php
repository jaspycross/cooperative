<?php require_once '../dbconnect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../design/head.php'; ?>

<body>
    <?php
    $sql = "SELECT tb_place.id,
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
    WHERE provinces.name_th LIKE '%อ่างทอง%' ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ?>
    <?php
    echo '<pre>';
    echo print_r($row);
    echo '</pre>';
    ?>
    <?php echo $row['name_th']; ?>
    <?php echo $row['provinces']; ?>
    <?php echo $row['amphures']; ?>
</body>

</html>