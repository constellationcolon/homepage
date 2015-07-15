<?php

$events = array();
$cmd = "./sort.py events -d";
exec(escapeshellcmd($cmd), $output, $status);
if ($status) {
    echo "exec command failed";
} else {
    foreach ($output as $line) {
        array_push($events, json_decode($line));
    }
}

//load database
require_once('scripts/query.php');
//database parameters
$servername = "dev.kovits.com";
$username = "acmcu";
$password = "koi2104";
$db_name = "acmcu";
$port = 3306;
$table = "events";

function getEvents($svr, $usr, $pwrd, $d, $pt, $tbl)
{
    $db = new Query($svr, $usr, $pwrd, $d, $pt, $tbl);
    sortEvents($db);
}

function sortEvents($database) {
    $eventList = $database->select(); //need to sort in query
    foreach ($eventList as $event) {
      //  if ($event )
    }
    var_dump($eventList);

}

getEvents($servername, $username, $password, $db_name, $port, $table);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Columbia University Association for Computing Machinery</title>
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
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
                    <li><a href="#events-wrap">EVENTS</a>
                    </li>
                    <li><a href="#about-wrap">ABOUT US</a>
                    </li>
                    <li><a href="#">RESOURCES</a>
                    </li>
                    <li><a href="#">GALLERY</a>
                    </li>
                    <li><a href="#contact-wrap">CONTACT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" id="container">
        <div class="row " id="billboard-wrap">
            <div id="billboard-overlay">

            </div>
        </div>
        <div class="row" id="events-wrap">
            <div class="col-xs-12" id="events-title">
                <h1>EVENTS</h1>
            </div>
            <div class="events-container col-xs-12 col-sm-12 col-md-offset-1 col-md-10">
                <?php
                for ($i = 0; $i < count($events); $i++) {
                    $date = date_create($events[$i]->start_datetime);
                    if ($i == 0) {
                        if (count($events) == 3) {
                            $evnt = '<div class="event-wrap col-xs-12 col-sm-4">';
                        } else if (count($events) == 2) {
                            $evnt = '<div class="event-wrap col-xs-12 col-sm-offset-2 col-sm-4">';
                        } else {
                            $evnt = '<div class="event-wrap col-xs-12 col-sm-offset-4 col-sm-4">';
                        }
                    } else {
                        $evnt = '<div class="event-wrap col-xs-12 col-sm-4">';
                    }
                    $evnt .= '<div class="event-date">';
                    $evnt .= '<div class="event-date-month">' . strtoupper($date->format('M')) . '</div>';
                    $evnt .= '<div class="event-date-day">' . $date->format('j') . '</div>';
                    $evnt .= '</div>';
                    $evnt .= '<div class="event-name">';
                    $evnt .= '<h3>' . $events[$i]->name . '</h3>';
                    $evnt .= '</div>';
                    $evnt .= '<div class="event-description">';
                    $evnt .= '<p>' . $events[$i]->description . '</p>';
                    $evnt .= '</div>';
                    $evnt .= '<a href="events.php?call=' . $events[$i]->filename . '" target="_self"><button type="button" class="event-btn btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12">More</button></a>';
                    $evnt .= '</div>';
                    echo $evnt;
                }
                ?>
            </div>
        </div>
        <div class="row" id="about-wrap">
            <div id="about-overlay">
                <div class="col-xs-12" id="about-title">
                    <h1>ABOUT</h1>
                </div>
                <div class="col-xs-12" id="about-container">
                    <div class="col-xs-12 col-sm-4" id="about-short">
                        <h3>The Columbia Computer Science Preprofessional Society works to bring a broad range of career-related programming to Columbia students.</h3>
                    </div>
                    <div class="col-xs-12 col-sm-8" id="about-long">
                        <p>The Columbia Computer Science Preprofessional Society works to bring a broad range of career-related programming to Columbia students. We want to make it easier for students to get introduced to and explore the different CS-related career trajectories available to them, across several disciplines and roles. Ultimately, we want to be a go-to resource for CS students, whether they're interested in core tech jobs or in interdisciplinary academia.</p>
                    </div>
                </div>
                <div class="col-xs-12" id="about-btn-wrap">
                    <button type="button" class="btn btn-default" id="about-btn">Directory</button>
                </div>
            </div>
        </div>
        <div class="row" id="contact-wrap">
            <div id="contact-overlay">
                <div class="col-xs-12" id="contact-title">
                    <h1>CONTACT</h1>
                </div>
                <div class="col-xs-12" id="contact-form-wrap">
                    <form role="form" action="scripts/send.php">
                        <div class="col-xs-12" id="contact-form-fields">
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <input type="textarea" class="form-control" id="name" name="name" placeholder="Full Name">
                            </div>
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <textarea class="form-control" rows="8" id="message" name="message" placeholder="Enter Message"></textarea>
                            </div>
                        </div>
                        <div id="contact-btn-wrap">
                            <button type="submit" class="btn btn-default" id="contact-btn">Submit</button>
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
        var elems = $('.event-description > p')
        for (i = 0; i < elems.length; i++) {
            $clamp(elems[i], {
                clamp: 'auto'
            });
        }
        $('a[href*=#]:not([href=#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 10) {
                $('.navbar').css('background-color', 'rgba(68, 40, 26, 0.7)');
                $('.navbar').css('-webkit-box-shadow', '0 1px 1px 0 rgba(0, 0, 0, 0.6)');
                $('.navbar').css('box-shadow', '0 1px 1px 0 rgba(0, 0, 0, 0.6)');
                $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').css('color', '#D7D3D0');
                $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').hover(
                    function () {
                        $(this).css('color', '#44281A');
                    },
                    function () {
                        $(this).css('color', '#D7D3D0');
                    }
                );

            } else {
                $('.navbar').css('background-color', 'transparent');
                $('.navbar').css('-webkit-box-shadow', 'none');
                $('.navbar').css('box-shadow', 'none');
                $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').css('color', '#44281A');
                $('.navbar-default .navbar-nav>li>a').hover(
                    function () {
                        $(this).css('color', '#7A787D');
                    },
                    function () {
                        $(this).css('color', '#44281A');
                    }
                );
                $('.navbar-default .navbar-brand').hover(
                    function () {
                        $(this).css('color', '#D7D3D0');
                    },
                    function () {
                        $(this).css('color', '#44281A');
                    }
                );
            }
        });
        $('.navbar-default .navbar-nav>li>a').hover(
            function () {
                $(this).css('color', '#7A787D');
            },
            function () {
                $(this).css('color', '#44281A');
            }
        );
        $('.navbar-default .navbar-brand').hover(
            function () {
                $(this).css('color', '#D7D3D0');
            },
            function () {
                $(this).css('color', '#44281A');
            }
        );

        $('form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                cache: false,
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function () {
                    $("#name").val('');
                    $("#email").val('');
                    $("#message").val('');
                    alert("Your Message Has Been Sent");
                },
                error: function (xhr) {
                    alert("Please Complete all Sections");
                },
            })
        })
    </script>
</body>

</html>
