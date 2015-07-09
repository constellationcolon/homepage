<?php

# Include the Autoloader (see "Libraries" for install instructions)
require '../vendor/autoload.php';
use Mailgun\Mailgun;

//parse incoming data string
$message = array();
parse_str($_POST, $message);

$apiKey = 'key-daa6e41a5053492a6c0442b32abccbfc';
$name = $_POST["name"];
$fromAddr = $_POST["email"];
$toAddr = 'mlhaigh80@gmail.com';
$subj = "Mailgun Form Submission";
$body = $_POST["message"];

if ((!$name) || (!$fromAddr) || (!$body)){
    return http_response_code(403);
}

// submission data
$ipaddress = $_SERVER['REMOTE_ADDR'];
$date = date('d/m/Y');
$time = date('H:i:s');

# Instantiate the client.
$mgClient = new Mailgun($apiKey);
$domain = 'mg.haighr.com';

# Make the call to the client.
try {
    $result = $mgClient->sendMessage($domain, array(
'from' => "USER <".$fromAddr.">",
'to' => 'Matt Haigh <mlhaigh80@gmail.com>',
'subject' => $subj,
'text' => "New Mailgun Message\nSent: " . $date . " At: " . $time . "\nFrom: " . $name . "\nAt IP: " .
$ipaddress . ": \n" . $body));
} catch (Exception $e) {
http_response_code(400);
}

?>