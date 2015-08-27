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

//returns array of 3 events in proper display order (or less)
function sortEvents($database) {
    $evts = array();
    $upcoming = $database->select("upcoming");
    $passed = $database->select("passed");
    $i = 0;
    $index = 3;
    $passed_index = (count($passed));
    $upcoming_index = (count($upcoming));
    if ($upcoming_index + $passed_index < 3) {
        $index = ($upcoming_index + $passed_index);
    }
    while ($i < $index) {
        ($upcoming_index > 0) ? array_push($evts, $upcoming[--$upcoming_index])
            : array_push($evts, $passed[--$passed_index]);
        $i++;
    }
    return array_reverse($evts);
}

$db = new Query($servername, $username, $password, $db_name, $port);
$events = sortEvents($db);
$images = $db->select("allImages");

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
                    $evnt .= '<h3>' . $events[$i]["name"] . '</h3>';
                    $evnt .= '</div>';
                    $evnt .= '<div class="event-description">';
                    $evnt .= '<p>' . $events[$i]["description"] . '</p>';
                    $evnt .= '</div>';
                    $evnt .= '<a href="events.php?call=' . $events[$i]["event_id"] . '" target="_self"><button type="button" class="event-btn btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12">More</button></a>';
                    $evnt .= '</div>';
                    echo $evnt;
                }
                ?>
            </div>
            <button type="button" class="btn btn-block btn-lg btn-info btn-open collapsed" data-toggle="collapse" data-target="#events-all">
                <span class="past-btn">SEE PAST EVENTS <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></span>
                <span class="past-btn-pressed">CLOSE <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></span>
            </button>
            <div id="events-all" class="collapse">
                <div class="row events-all-wrapper col-xs-12">
                    <div class="row events-search col-xs-6">
                        <div class="input-group input-group-lg">
                            <input type="text" id="search" class="form-control search-text" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="row events-list col-xs-6">
                        <ul>
                            <?php
                            $past = $db->select("passed");
                            for ($i = 0; $i < count($past); $i++) {
                                $date = date_create($past[$i]["start_datetime"]);
                                $item = '<a href="events.php?call=' . $past[$i]["event_id"] . '"target="_self"><li>';
                                $item .= '<div class="past-date-wrap">';
                                $item .= '<div class="past-date">';
                                $item .= '<div class="past-date-month">' . strtoupper($date->format('M')) . '</div>';
                                $item .= '<div class="past-date-day">' . $date->format('j') . '</div>';
                                $item .= '</div>';
                                $item .= '<div class="past-year">';
                                $item .= '<h3>' . $date->format('Y') . '</h3>';
                                $item .= '</div></div>';
                                $item .= '<p>' . $past[$i]["name"] . '</p></li><div class="line"></div></a>';
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
        <div class="row" id="resources-wrap">
            <div id="resources-overlay">
                <div class="col-xs-12" id="resources-title">
                    <h1>RESOURCES</h1>
                </div>
                <div class="input-group input-group-lg" id="resources-bar">
                    <input type="text" id="resources-text" class="form-control search-text" placeholder="Search our resources...">
                    <span class="input-group-btn dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <!--                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>-->
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                        </ul>
                    </span>
                </div>
            </div>
        </div>
        <div class="row" id="gallery-wrap">
            <div class="gallery-wrapper col-sm-10 col-sm-offset-1">
                <h1>GALLERY</h1>
                <div id="gallery-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $THUMBNAIL_QUANTITY = 16;
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
                        for ($i = 1; $i < $THUMBNAIL_QUANTITY; $i++) {
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
                        $controls = '<a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next" ><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
                        $thumbnails .= '</div>';
                        echo $gallery;
                        echo $controls;
                        echo $thumbnails;
                        ?>
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

                function resize_thumbnails() {
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

                // Enable Carousel Controls
                $(".right").click(function () {
                    $("#gallery-carousel").carousel("next");
                });

                function populate_resources() {
                    $.ajax({
                        method: 'GET',
                        dataType: 'json',
                        Accept: 'application/vnd.github.v3+json',
                        url: 'https://api.github.com/repos/acmcu/resources/git/trees/master',
                        success: function (returndata) {
                            var dropdown = $('.dropdown-menu');
                            var tree = returndata["tree"];
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

                //initially populate resources drodown menu
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
