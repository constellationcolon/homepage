<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//load database
require_once('scripts/query.php');
//database parameters
$servername = "dev.kovits.com";
$username = "acmcu";
$password = "koi2104";
$db_name = "acmcu";
$port = 3306;
$table = "events";

$THUMBNAIL_QUANTITY = 16;
$path = "assets/events/";

$query = new Query($servername, $username, $password, $db_name, $port);
$upcoming = $query->select("upcoming");
$passed = $query->select("passed");

$evts = array();
$i = 0;
$index = 3;
$passed_index = count($passed);
$upcoming_index = count($upcoming);
if ($upcoming_index + $passed_index < 3) {
    $index = ($upcoming_index + $passed_index);
}
while ($i < $index) {
    ($upcoming_index > 0) ? array_push($evts, $upcoming[--$upcoming_index]) : array_push($evts, $passed[--$passed_index]);
    $i++;
}
$events = array_reverse($evts);
$images = $query->select("allImages");

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
                <a class="navbar-brand" href="#billboard-wrap">ACMCU HOME</a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#events-wrap">EVENTS</a>
                    </li>
                    <li><a href="#about-wrap">ABOUT US</a>
                    </li>
                    <li><a href="#resources-wrap">RESOURCES</a>
                    </li>
                    <li><a href="#gallery-wrap">GALLERY</a>
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
                <!-- <img id="landing-logo" src="assets/CCPSS_Logo_White.png"> -->
                <p id="landing-name">COLUMBIA UNIVERSITY ASSOCIATION FOR COMPUTING MACHINERY</p>
                <!-- <img class="site-logo" src="assets/white-logo.png"> -->
            </div>
        </div>
        <div class="row" id="events-wrap">
            <!-- <div class="col-xs-12" id="events-title"> -->
            <div class="col-xs-12">
                <h1>EVENTS</h1>
            </div>
            <div class="events-container col-xs-12 col-sm-12 col-md-offset-1 col-md-10">
                <?php
                for ($i = 0; $i < (count($events)); $i++) {
                    $date = date_create($events[$i]["start_datetime"]);
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
                    $evnt .= '<h3><a href="events.php?call=' . $events[$i]["event_id"] . '" target="_self">' . $events[$i]["name"] . '</a></h3>';
                    $evnt .= '</div>';
                    $evnt .= '<div class="event-description">';
                    $evnt .= '<p>' . $events[$i]["description"] . '</p>';
                    $evnt .= '</div>';
                    // $evnt .= '<a href="events.php?call=' . $events[$i]["event_id"] . '" target="_self"><button type="button" class="event-btn btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12">More</button></a>';
                    $evnt .= '</div>';
                    echo $evnt;
                }
                ?>
            </div>
            <button type="button" class="btn btn-block btn-lg btn-info btn-open collapsed" data-toggle="collapse" aria-expanded="false" data-target="#events-all">
                <span class="past-btn">SEE PAST EVENTS</span>
                <span class="past-btn-pressed">CLOSE</span>
            </button>
            <div id="events-all" class="collapse">
                <div class="events-all-wrapper">
                    <div class="events-search col-xs-6">
                        <div class="input-group input-group-lg">
                            <input type="text" id="search" class="form-control search-text" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="events-list col-xs-6">
                        <ul>
                            <?php
                            $past = $query->select("passed");
                            for ($i = 0; $i < count($past); $i++) {
                                $date = date_create($past[$i]["start_datetime"]);
                                $item = '<h3><a href="events.php?call=' . $past[$i]["event_id"] . '"target="_self"><li class="events-list-item">';
                                // $item .= '<div class="past-date-wrap">';
                                // $item .= '<div class="past-date">';
                                // $item .= '<div class="past-date-month">' . strtoupper($date->format('M')) . '</div>';
                                // $item .= '<div class="past-date-day">' . $date->format('j') . '</div>';
                                // $item .= '</div>';
                                // $item .= '</div>';
                                $item .= '' . $past[$i]["name"] . '</li></a></h3>';
                                echo $item;
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="about-wrap">
            <div id="about-overlay">
                <div class="col-xs-12" id="about-title">
                <!-- <div class="col-xs-12"> -->
                    <h1>ABOUT</h1>
                </div>
                <div class="col-xs-12" id="about-container">
                    <div class="col-xs-12 col-sm-4" id="about-short">
                        <h3>The Columbia Computer Science Preprofessional Society works to bring a broad range of
                            career-related programming to Columbia students.</h3>
                    </div>
                    <div class="col-xs-12 col-sm-8" id="about-long">
                        <p>The Columbia Computer Science Preprofessional Society works to bring a broad range of
                            career-related programming to Columbia students. We want to make it easier for students to get
                            introduced to and explore the different CS-related career trajectories available to them, across
                            several disciplines and roles. Ultimately, we want to be a go-to resource for CS students,
                            whether they're interested in core tech jobs or in interdisciplinary academia.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row resources-color" id="resources-wrap">
            <div id="resources-overlay">
                <div class="col-xs-12" id="resources-title">
                <!-- <div class="col-xs-12"> -->
                    <h1>RESOURCES</h1>
                </div>
                <div class="input-group input-group-lg" id="resources-bar">
                    <input type="text" id="resources-text" class="form-control search-text" placeholder="Search our resources...">
                    <div class="input-group-btn dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                        <ul class="dropdown-menu">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="gallery-wrap">
            <div class="gallery-wrapper col-sm-10 col-sm-offset-1">
                <h1>GALLERY</h1>
                <div id="gallery-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php
                        for ($i = 0; $i < $THUMBNAIL_QUANTITY; $i++) {
                            echo '<div class="item ' . ($i == 0 ? 'active' : '') . '" style="background: url(\'' . $path . $images[$i]["img_filename"] . '\') no-repeat center; background-size: cover;"></div>';
                        }
                        ?>
                    </div>
                    <div class="gallery-small">
                        <?php
                        for ($i = 0; $i < $THUMBNAIL_QUANTITY; $i++) {
                            echo '<div class="gallery-img-sm" style="background: url(\'' . $path . $images[$i]["img_filename"] . '\') no-repeat center; background-size: cover;"></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="contact-wrap">
            <div id="contact-overlay">
                <div class="col-xs-12" id="contact-title">
                <!-- <div class="col-xs-12"> -->
                    <h1>CONTACT US</h1>
                </div>
                <div class="col-xs-12" id="contact-form-wrap">
                    <form role="form" action="scripts/send.php">
                        <div id="contact-form-fields" class="col-xs-12">
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                            </div>
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="form-group col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                                <textarea class="form-control" rows="8" id="message" name="message" placeholder="Enter Message"></textarea>
                            </div>
                        </div>
                        <div id="contact-btn-wrap">
                            <button type="submit" class="btn btn-default" id="contact-btn">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/clamp.min.js"></script>
        <script type="text/javascript">
            var elems = $('.event-description > p');
            for (var i = 0; i < elems.length; i++) {
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
                var navbar = $('.navbar');
                if ($(this).scrollTop() > 10) {
                    // navbar.css('background-color', 'rgba(68, 40, 26, 0.7)');
                    navbar.css('background-color', 'rgba(196, 216, 226, 0.8)');
                    navbar.css('-webkit-box-shadow', '0 2px 2px 0 rgba(0, 0, 0, 0.1)');
                    // navbar.css('box-shadow', '0 1px 1px 0 rgba(0, 0, 0, 0.2)');
                    // $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').hover(
                    //     function () {
                    //         $(this).css('color', '#A8CEE2');
                    //     },
                    //     function () {
                    //         $(this).css('color', '#A8CEE2');
                    //     }
                    // );
                    $('.navbar-default .navbar-brand').css('color', 'white');

                } else {
                    navbar.css('background-color', 'transparent');
                    navbar.css('-webkit-box-shadow', 'none');
                    navbar.css('box-shadow', 'none');
                    // $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').css('color', '#44281A');
                    // $('.navbar-default .navbar-nav>li>a').hover(
                    //     function () {
                    //         $(this).css('color', '#7A787D');
                    //     },
                    //     function () {
                    //         $(this).css('color', '#44281A');
                    //     }
                    // );
                    // $('.navbar-default .navbar-brand').hover(
                    //     function () {
                    //         $(this).css('color', '#D7D3D0');
                    //     },
                    //     function () {
                    //         $(this).css('color', '#44281A');
                    //     }
                    // );
                }
            });
            $('.navbar-default .navbar-nav>li>a').hover(
                function () {
                    $(this).css('color', 'white');
                },
                function () {
                    $(this).css('color', 'black');
                }
            );
            $('.navbar-default .navbar-brand').hover(
                function () {
                    $(this).css('color', '#A8CEE2');
                },
                function () {
                    $(this).css('color', 'white');
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
                    error: function () {
                        alert("Please Complete all Sections");
                    }
                })
            });

            //make :contains case insensitive
            $.expr[":"].contains = $.expr.createPseudo(function (arg) {
                return function (elem) {
                    return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });

            //show only active search results
            $('#search').keyup(function () {
                $('p').parent().hide();
                var text = $('#search').val();
                $("p:contains('" + text + "')").parent().show();
            });

            //gallery thumbnails correspond to image on display on click
            $('.gallery-img-sm').click(function () {
                $('.carousel').carousel($(this).index());
            });

            function resize_thumbnails() {
                var width = $('.gallery-small').width();
                if (width > 700) {
                    var THUMBNAILS_PER_ROW = 8;
                    var IND_SPACING = 10;
                    var TOTAL_SPACING = ((THUMBNAILS_PER_ROW - 1) * IND_SPACING);
                    var tn_width = ((width - TOTAL_SPACING) / THUMBNAILS_PER_ROW);
                    var tn_height = (tn_width * (5 / 7));
                    $('.gallery-img-sm').css({
                        'width': tn_width,
                        'height': tn_height
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

            function populate_resources() {
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    Accept: 'application/vnd.github.v3+json',
                    url: 'https://api.github.com/repos/acmcu/resources/git/trees/master',
                    success: function (data) {
                        var dropdown = $('.dropdown-menu');
                        var tree = data["tree"];
                        var query = document.getElementById('resources-text').value;
                        dropdown.empty();
                        for (var i = 0; i < tree.length; i++) {
                            var item = tree[i]["path"];
                            if ((item != 'LICENSE') && (item != 'README.md')) {
                                if (item.toLowerCase().indexOf(query) >= 0) {
                                    dropdown.append('<li class="resource-link"><a href="https://github.com/acmcu/resources/tree/master/' + item + '">' + item + '</li>');
                                }
                            }
                        }
                    }
                })
            }

            //initially populate resources dropdown menu
            $(document).ready(function () {
                populate_resources();
            });

            //update resources dropdown menu
            $('#resources-text').keyup(function () {
                populate_resources();
            });

        </script>
</body>

</html>
