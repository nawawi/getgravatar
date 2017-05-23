<?php
if ( !defined('INDEX_PATH') ) define('INDEX_PATH', dirname(realpath(__FILE__)) . '/' );
include_once(INDEX_PATH.'/getgravatar.php');

$uagent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36";
$email = "nawawi@rutweb.com";

if ( isset($_SERVER['argv'][1]) ) {
    $email = $_SERVER['argv'][1];
}

$blob = _get_gravatar($email, $uagent, 80);
if ( $blob ) {
    if ( file_put_contents(INDEX_PATH."/gravatar-{$email}.jpg", $blob, LOCK_EX) ) {
        echo "File Saved\n";
        exit(0);
    }
}

echo "Failed\n";
exit(1);
