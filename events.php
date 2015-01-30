<?php
    if (isset($_GET["call"])) {
        if (!($event = json_decode(file_get_contents("events/" . $_GET["call"])))) {
            header("HTTP/1.0 404 Bad Request");
            include("errors/404.php");
            exit();
        }
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
                <a class="navbar-brand" href="#">CCSPS</a>
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
                        <h3><?php echo $event->name ?></h3>
                    </div>
                    <div class="col-xs-12" id="event-description">
                        <p><?php echo $event->description ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-5" id="event-details-split">
                        <?php 
                            $start_dt = date_create($event->start_datetime);
                            $end_dt = date_create($event->end_datetime);
                        ?>
                        <div class="col-xs-12" id="event-date">
                            <h5><i class="hidden-xs icon-calendar"></i><?php echo $start_dt->format('F j, Y')?></h5>
                        </div>
                        <div class="col-xs-12" id="event-time">
                            <h5><i class="hidden-xs icon-clock"></i><?php echo $start_dt->format('g:ia') . " - " . $end_dt->format('g:ia')?></h5>
                        </div>
                        <div class="col-xs-12" id="event-location">
                            <h5><i class="hidden-xs icon-location"></i><?php echo $event->location ?></h5>
                        </div>
                        <div class="col-xs-12" id="event-links">
                            <?php
                                foreach ($event->external_links as $key => $link) {
                                    echo '<a class="event-links" href="' . $link . '"><i class="icon-' . $key . '"></i></a>';
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
                            foreach ($event->profiles as $filename) {
                                if (!($profile = json_decode(file_get_contents("profiles/" . $filename)))) {
                                    header("HTTP/1.0 500 Bad Request");
                                    include("errors/500.php");
                                    exit();
                                }
                                echo '<div class="profile">';
                                echo    '<div class="profile-frame">';
                                echo        '<div class="profile-glass" style="background-image: url(\'images/profiles/' . $profile->image . "')\"></div>";
                                echo    '</div>';
                                echo    '<h5 class="profile-name">' . $profile->full_name . '</h5>';
                                echo    '<h6 class="profile-company">' . $profile->company . '</h6>';
                                echo'</div>';
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
    </div>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/clamp.min.js"></script>
    <script type="text/javascript">
    </script>
</body>

</html>