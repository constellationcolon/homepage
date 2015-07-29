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
var_dump($images);
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
                <div class="carousel-inner" role="listbox">
                    <?php
                    $path = "assets/events/";
                    $gallery = '<div class="item active"><img src="' . $path . $images[0]["img_filename"] . '"></div>';
                    $thumbnails = <<<EOT
<div class="gallery-small"><div class="gallery-img-sm" style="background-image: url('
EOT;
                    $thumbnails .= $path . $images[0]["img_filename"];
                    $thumbnails .= <<<EOT
');></div>"
EOT;
                    $thumbnails .= <<<EOT
<div class="gallery-img-sm" style="background-image: url('
EOT;
                    $thumbnails .= $path . $images[1]["img_filename"];
                    $thumbnails .= <<<EOT
');"></div>
EOT;
                    for ($i = 1; $i < count($images); $i++) {
                        $gallery .= '<div class="item"><img src="' . $path . $images[$i]["img_filename"] . '"></div>';
                        $thumbnails .= <<<EOT
<div class="gallery-img-sm" style="background-image: url('
EOT;
                        $thumbnails .= $path . $images[$i]["img_filename"];
                        $thumbnails .= <<<EOT
');"></div>
EOT;
                    }
                    $gallery .= '</div>';
                    $controls = '<a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';
                    $thumbnails .= '</div>';
                    echo $gallery;
                    echo $controls;
                    echo $thumbnails;
                    ?>
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