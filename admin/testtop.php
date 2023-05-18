<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css" /> <!-- สำคั -->
    <?php require_once "../design/head.php"; ?>
</head>

<body class="fs-2">
    <!-- Your HTML content goes here -->

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
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam unde
        cupiditate nobis incidunt molestias rem aliquam nisi, nihil non eius
        blanditiis eveniet veritatis, quam architecto cum quod maiores facere
        atque, alias neque minus hic asperiores! Qui, harum iste, optio nam
        dolorum molestias impedit ipsum quos non magnam quaerat error
        necessitatibus, officiis nostrum minus maiores iusto accusantium sint
        atque pariatur. Recusandae facere facilis ab cupiditate reiciendis. Ut
        reiciendis iusto non eligendi saepe iure, itaque, odio facere laboriosam
        qui voluptatibus id assumenda totam fugit, numquam temporibus ad sint
        voluptatum tenetur unde illo. Pariatur nesciunt, perspiciatis rerum
        voluptates voluptatum consequuntur placeat autem deserunt.
    </p>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam sed
        perspiciatis rerum ea quia nostrum, quod sit dolorem, illum officia
        inventore, maiores ipsum voluptas aut facere? Quos, autem odit nostrum
        ipsam recusandae nulla, labore assumenda voluptatibus quas quisquam
        adipisci eveniet illo voluptatem nisi porro, deserunt nemo! Sit reiciendis
        unde ab, consequatur excepturi expedita vel tempora mollitia quibusdam
        velit earum exercitationem placeat praesentium quo quisquam ipsa voluptate
        eum, tempore aperiam corporis. Exercitationem, amet. Amet cum nulla
        accusantium modi molestias nesciunt sint soluta, fuga alias doloribus odit
        dolor ipsa libero corporis neque adipisci aspernatur quisquam, sit,
        officia id harum tenetur ullam beatae!
    </p>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit est in
        minima quos accusamus, id assumenda laborum libero culpa autem corrupti
        repellendus voluptatem saepe odit maxime, aut ab fugit voluptas omnis
        dolorem voluptate rem velit. Alias quod hic ullam necessitatibus! Tempore
        nesciunt tenetur omnis perferendis id beatae non cum porro. Pariatur
        facere nesciunt deleniti, laudantium praesentium facilis, minus quo magni
        dolorem similique, mollitia quisquam ad voluptatibus iure ullam magnam!
        Blanditiis, harum? Eveniet architecto eum velit, quia molestiae accusamus
        voluptatem non quis accusantium aspernatur cumque id modi! Aliquam ab
        expedita ipsum, libero in quod, sunt mollitia voluptatibus sapiente, dolor
        sit delectus?
    </p>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit molestias
        dolorum dolore amet tenetur! At sed nulla sapiente dolorum hic, facere
        accusamus officiis placeat commodi molestias, velit dolor ab quibusdam
        nostrum numquam optio asperiores impedit perspiciatis consequuntur iusto
        laborum deserunt quisquam doloribus! Ducimus explicabo aspernatur sed
        dolores perspiciatis, vero tenetur consequuntur culpa dicta numquam facere
        labore, deleniti maiores. Fuga id saepe aliquid adipisci iste, beatae
        pariatur ullam voluptas accusantium dolor voluptatibus numquam consectetur
        asperiores eaque reprehenderit! Maiores, ex consequuntur! Consequuntur
        nulla voluptate quaerat accusantium et optio reiciendis id repellendus
        possimus, minus dolore? Perferendis labore doloribus iusto nostrum
        nesciunt vero commodi cupiditate optio at. Perspiciatis atque inventore,
        dolorum iste deserunt, accusantium magnam cum temporibus quae placeat
        magni debitis blanditiis reprehenderit tempore a veniam laborum
        consectetur amet? Animi cumque nisi aspernatur consequuntur, molestias
        vero eaque fuga repellat mollitia assumenda necessitatibus! Suscipit atque
        modi quam ab optio. Eum voluptatem, magni deleniti voluptas autem
        molestias consectetur totam culpa facilis maiores illum dolore aut! Cumque
        quas molestiae dolorem pariatur commodi omnis, ut, iste aliquid illo ipsum
        eum culpa laborum doloribus quod. Ad dicta reprehenderit corrupti, soluta
        sapiente unde officia blanditiis architecto reiciendis magni sequi.
        Repellat ex ab laboriosam, quos error enim ut officiis inventore
        accusamus!
    </p>
    <script src="../script.js"></script>

</body>

</html>