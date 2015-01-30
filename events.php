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
                    <li><a href="index.php#">RESOURCES</a>
                    </li>
                    <li><a href="index.php#">GALLERY</a>
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
                <div class="col-xs-12" id="event-details">
                    <div class="col-xs-12" id="event-name">
                        <h3>CORE Startup Social</h3>
                    </div>
                    <div class="col-xs-12" id="event-description">
                        <p>Join CORE and a special VC guest at the first Startup Social of the semester! CORE’s Startup Social is an informal social event series that revolves around building the community of the entrepreneurially-minded members of Columbia University. We invite students and entrepreneurs from across Columbia University and New York, and encourage experienced entrepreneurs to help mentor aspiring and developing entrepreneurs on campus.</p>
                    </div>
                    <div class="col-xs-12" id="event-date">
                        <h5><i class="hidden-xs icon-calendar"></i>February 2, 2015</h5>
                    </div>
                    <div class="col-xs-12" id="event-time">
                        <h5><i class="hidden-xs icon-clock"></i>7:30pm - 9:00pm</h5>
                    </div>
                    <div class="col-xs-12" id="event-location">
                        <h5><i class="hidden-xs icon-location"></i>Broadway Room, Lerner Hall</h5>
                    </div>
                    <div class="col-xs-12" id="event-links">
                        <a class="event-links" href="#"><i class="icon-facebook"></i></a>
                        <a class="event-links" href="#"><i class="icon-link"></i></a>
                    </div>
                </div>
                <div class="col-xs-12" id="event-speakers">
                    <div class="profile col-xs-6">
                        <div class="profile-frame">
                            <div class="profile-glass"></div>
                        </div>
                        <h5 class="profile-name">Konstantin Itskov</h5>
                        <h6 class="profile-company">Microsoft</h6>
                    </div>
                    <div class="profile col-xs-6">
                        <div class="profile-frame">
                            <div class="profile-glass"></div>
                        </div>
                        <h5 class="profile-name">Konstantin Itskov</h5>
                        <h6 class="profile-company">Microsoft</h6>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6" id="register-form-wrap">
                    <form role="form">
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
        $(window).scroll(function() {
            if ($(this).scrollTop() > 10) {
                $('.navbar').css('background-color', 'rgba(68, 40, 26, 0.6)');
                $('.navbar').css('-webkit-box-shadow', '0 1px 1px 0 rgba(0, 0, 0, 0.6)');
                $('.navbar').css('box-shadow', '0 1px 1px 0 rgba(0, 0, 0, 0.6)');
                $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').css('color', '#D7D3D0');
            } else {
                $('.navbar').css('background-color', 'transparent');
                $('.navbar').css('-webkit-box-shadow', 'none');
                $('.navbar').css('box-shadow', 'none');
                $('.navbar-default .navbar-nav>li>a, .navbar-default .navbar-brand').css('color', '#44281A');
            }
        });
    </script>
</body>

</html>
