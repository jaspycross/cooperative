<!DOCTYPE html>
<html lang="en">
<?php require_once '../design/head.php'; ?>

<script>
    function updateSelect2() {
        var select1Value = $("#select1").val();
        $.ajax({
            url: "fetch_data.php",
            type: "POST",
            data: {
                select1Value: select1Value
            },
            success: function(data) {
                $("#select2").html(data);
            }
        });
    }
</script>


<body>

    <select id="select1" onchange="updateSelect2()">
        <option value="">--- เลือก ---</option>
        <!-- ตัวเลือกสำหรับ select 1 -->
        <option value="1">ภาควิชาการบัญชีและการเงิน</option>
        <option value="2">ภาควิชาการตลาดและการจัดการ </option>
    </select>
    <select id="select2">
        <option value="">เลือกตัวเลือก 2</option>
        <!-- ตัวเลือกสำหรับ select 2 จะถูกเปลี่ยนโดย JavaScript -->
    </select>


    <?php require_once '../design/footer.php'; ?>
</body>

</html>