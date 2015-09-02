<?php
# Include the Autoloader (see "Libraries" for install instructions)
require '../vendor/autoload.php';
use Mailgun\Mailgun;

$apiKey = 'key-c04a162cc2427ac6d7d88a9d5d99f49f';
$name = $_POST["name"];
$fromAddr = $_POST["email"];
$toAddr = 'koi2104@columbia.edu';
$subj = "ACMCU: CONTACT";
$body = $_POST["message"];

if ((!$name) || (!$fromAddr) || (!$body)) {
    return http_response_code(403);
}

# Instantiate the client.
$mgClient = new Mailgun($apiKey);
$domain = 'acmcu.com';


# Make the call to the client.
try {
    $result = $mgClient->sendMessage($domain, array(
        'from' => $fromAddr,
        'to' => $toAddr,
        'subject' => $subj,
        'text' => $body));
} catch (Exception $e) {
    echo $e;
    http_response_code(400);
}