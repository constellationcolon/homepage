<?php

//load database
require_once('scripts/query.php');
//database parameters
$servername = "dev.kovits.com";
$username = "acmcu";
$password = "koi2104";
$db_name = "acmcu";
$port = 3306;
$table = "events";

$db = new Query($servername, $username, $password, $db_name, $port);
$images = $db->select("allImages");

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Gallery Tester</title>
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/gallery_test.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row gallery-wrapper col-md-10 col-md-offset-1">
            <h1>GALLERY</h1>
            <div id="gallery-carousel" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php
                    foreach($images as $image) {

                    }
                    ?>
                    <!--                    <div class="item active">-->
                    <!--                        <img src="assets/events/event_sample_1.jpeg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_2.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_3.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_4.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_5.jpeg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_6.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_7.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_8.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_9.jpeg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_10.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_11.jpg">-->
                    <!--                    </div>-->
                    <!--                    <div class="item">-->
                    <!--                        <img src="assets/events/event_sample_12.jpg">-->
                    <!--                    </div>-->
                </div>
                <!-- Right controls -->
                <a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="gallery-small">
                <div class="gallery-img-sm img1"></div>
                <div class="gallery-img-sm img2"></div>
                <div class="gallery-img-sm img3"></div>
                <div class="gallery-img-sm img4"></div>
                <div class="gallery-img-sm img5"></div>
                <div class="gallery-img-sm img6"></div>
                <div class="gallery-img-sm img7"></div>
                <div class="gallery-img-sm img8"></div>
                <div class="gallery-img-sm img9"></div>
                <div class="gallery-img-sm img10"></div>
                <div class="gallery-img-sm img11"></div>
                <div class="gallery-img-sm img12"></div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $('.gallery-img-sm').click(function () {
            $('.carousel').carousel('pause');
            var file = $(this).css('background-image').split('/');
            file = file[file.length - 1].replace(')', '');
            $('.active').removeClass('active');
            $('.item').children().each(function () {
                var src = $(this).attr('src').split('/');
                src = src[src.length - 1];
                if (src === file) {
                    $(this).parent().addClass('active');
                }
            })
        })
    </script>
</body>
</html>