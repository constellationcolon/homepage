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
$event = $db->select($_GET["call"]);

if (isset($_GET["call"])) {
    $servername = "dev.kovits.com";
    $username = "acmcu";
    $password = "koi2104";
    $db_name = "acmcu";
    $port = 3306;
    $table = "events";

    $db = new Query($servername, $username, $password, $db_name, $port);

    $event = $db->select("id", $_GET["call"])[0];
    $images = $db->select("eventImages", $event["event_id"]);

//        if (!($event = json_decode(file_get_contents("events/" . $_GET["call"])))) {
//            header("HTTP/1.0 404 Bad Request");
//            include("errors/404.php");
//            exit();
//        }

} else {
    header("HTTP/1.0 400 Bad Request");
    include("errors/400.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Columbia Computer Science Pre-Professional Society</title>
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontello.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/events.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">CCSPS</a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php#events-wrap">EVENTS</a>
                    </li>
                    <li><a href="index.php#about-wrap">ABOUT US</a>
                    </li>
                    <li><a href="">RESOURCES</a>
                    </li>
                    <li><a href="">GALLERY</a>
                    </li>
                    <li><a href="index.php#contact-wrap">CONTACT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" id="container">
        <div class="row" id="event-container">
            <div class="col-xs-12" id="event-wrap">
                <div class="col-xs-12 col-sm-offset-1 col-sm-push-3 col-sm-7 col-md-push-2 col-md-8 col-lg-7" id="event-details">
                    <div class="col-xs-12" id="event-name">
                        <h3><?php echo $event["name"] ?></h3>
                    </div>
                    <div class="col-xs-12" id="event-description">
                        <p><?php echo $event["description"] ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-5" id="event-details-split">
                        <?php
                        $start_dt = date_create($event["start_datetime"]);
                        $end_dt = date_create($event["end_datetime"]);
                        ?>
                        <div class="col-xs-12" id="event-date">
                            <h5>
                                <i class="hidden-xs icon-calendar"></i><?php echo $start_dt->format('F j, Y') ?>
                            </h5>
                        </div>
                        <div class="col-xs-12" id="event-time">
                            <h5>
                                <i class="hidden-xs icon-clock"></i><?php echo $start_dt->format('g:ia') . " - " . $end_dt->format('g:ia') ?>
                            </h5>
                        </div>
                        <div class="col-xs-12" id="event-location">
                            <h5>
                                <i class="hidden-xs icon-location"></i><?php echo $event["location"] ?>
                            </h5>
                        </div>
                        <div class="col-xs-12" id="event-links">
                            <?php
                            if (isset($event["facebook_link"]) && ($event["facebook_link"] != "0")) {
                                echo '<a class="event-links" href="' . $event["facebook_link"] . '"><i class="icon-facebook"></i></a>';
                            }
                            if (isset($event["instagram_link"]) && $event["instagram_link"] != "0") {
                                echo '<a class="event-links" href="' . $event["instagram_link"] . '"><i class="icon-instagram"></i></a>';
                            }
                            if (isset($event["twitter_link"]) && $event["twitter_link"] != "0") {
                                echo '<a class="event-links" href="' . $event["twitter_link"] . '"><i class="icon-twitter"></i></a>';
                            }
                            if (isset($event["misc_link"]) && $event["misc_link"] != "0") {
                                echo '<a class="event-links" href="' . $event["misc_link"] . '"><i class="icon-link"></i></a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hidden-xs col-xs-12 col-sm-offset-1 col-sm-6" id="register-form">
                        <form role="form" id="register-form-wrap">
                            <div class="col-xs-12" id="register-form-fields">
                                <div class="form-group col-xs-12">
                                    <input type="textarea" class="form-control" id="name" placeholder="Full Name">
                                </div>
                                <div class="form-group col-xs-12">
                                    <input type="email" class="form-control" id="email" placeholder="UNI">
                                </div>
                            </div>
                            <div class="col-xs-12" id="register-btn-wrap">
                                <button type="button" class="col-xs-12 btn btn-default" id="register-btn">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-pull-7 col-sm-2 col-md-pull-8 col-md-2 col-lg-pull-7 col-lg-2" id="event-speakers-wrap">
                    <div id="event-speakers">
                        <?php
                        $profiles = $db->select("attends", $event["event_id"]);
                        foreach ($profiles as $profile) {
//                            if (!($profile = json_decode(file_get_contents("profiles/" . $filename)))) {
//                                header("HTTP/1.0 500 Bad Request");
//                                include("errors/500.php");
//                                exit();
//                            }
                            echo '<div class="profile">';
                            echo '<div class="profile-frame">';
                            echo '<div class="profile-glass" style="background-image: url(\'assets/profiles/' . $profile["image"] . "')\"></div>";
                            echo '</div>';
                            echo '<h5 class="profile-name">' . $profile["full_name"] . '</h5>';
                            echo '<h6 class="profile-company">' . $profile["company"] . '</h6>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="visible-xs col-xs-12" id="register-form">
                    <form role="form" id="register-form-wrap">
                        <div class="col-xs-12" id="register-form-fields">
                            <div class="form-group col-xs-12">
                                <input type="textarea" class="form-control" id="name" placeholder="Full Name">
                            </div>
                            <div class="form-group col-xs-12">
                                <input type="email" class="form-control" id="email" placeholder="UNI">
                            </div>
                        </div>
                        <div class="col-xs-12" id="register-btn-wrap">
                            <button type="button" class="col-xs-12 btn btn-default" id="register-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row" id="gallery-wrap">
            <div class="gallery-wrapper col-xs-10 col-xs-offset-1">
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
                        //fix for missing item in index 1??
                        if (count($images) > 1) {
                            $thumbnails .= <<<EOT
    <div class="gallery-img-sm" style="background-image: url('
EOT;
                            $thumbnails .= $path . $images[1]["img_filename"];
                            $thumbnails .= <<<EOT
    ');"></div>
EOT;
                        }
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
                        $controls = '<a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
                        $thumbnails .= '</div>';
                        echo $gallery;
                        echo $controls;
                        echo $thumbnails;
                        ?>
                    </div>
                </div>
    </div>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/clamp.min.js"></script>
    <script type="text/javascript">
        //gallery thumbnails correspond to image on display on click
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
        });

        function resize_thumbnails () {
            var width = $('.gallery-small').width();
            console.log(width);
            if (width > 700) {
                var THUMBNAILS_PER_ROW = 8;
                var IND_SPACING = 22;
                var THUMBNAIL_BUFFER = 6;
                var TOTAL_SPACING = THUMBNAILS_PER_ROW * IND_SPACING;
                var tn_width = ((width - TOTAL_SPACING - THUMBNAIL_BUFFER) / THUMBNAILS_PER_ROW);
                var tn_height = (tn_width * .75);
                $('.gallery-img-sm').css({
                    'width': tn_width,
                    'height': tn_height,
                    'display': 'inline-block'
                });
            }
            else {
                $('.gallery-img-sm').css('display', 'none');
            }
        }

        //initial size of gallery thumbnails
        $(document).ready(function () {
            resize_thumbnails();
        });

        //resize gallery thumbnails on window resize
        $(window).resize(function () {
            resize_thumbnails();
        });
    </script>
</body>

</html>
