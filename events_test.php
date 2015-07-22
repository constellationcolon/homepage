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
$events = $db->select("passed");

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
    <link href="css/events_test.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container-fluid">
        <div class="row events-all-wrapper col-md-12">
            <div class="row events-search col-md-6">
                <div class="input-group input-group-lg">
                    <input type="text" id="search" class="form-control search-text" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="row events-list col-md-6">
                <ul>
                    <?php
                    for ($i=0; $i<count($events); $i++) {
                        $date = date_create($events[$i]["start_datetime"]);
                        $item = '<li><time datetime="' . $date->format('y/m/d') . '"class="icon">';
                        $item .= '<em>' . $date->format('F') . '</em>';
                        $item .= '<strong>' . $date->format('Y') . '</strong>';
                        $item .= '<span>' . $date->format('d') . '</span></time>';
                        $item .= '<p>' . $events[$i]["name"] . '</p></li>';
                        echo $item;
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

        //make :contains case insensitive
        $.expr[":"].contains = $.expr.createPseudo(function(arg) {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });

        //show only active search results
        $('#search').keyup(function() {
            $('p').parent().hide();
            var text = $('#search').val();
            $("p:contains('" + text + "')").parent().show();
        })

    </script>
</body>