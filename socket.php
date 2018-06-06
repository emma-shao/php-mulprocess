<?php
if (!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Couldn't create socket: [$errorcode] $errormsg");
}
echo "Socket created\n";
if (!socket_connect($sock, '220.181.57.216', 80)) {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Counld not connect: [$errorcode] $errormsg\n");
}

echo "Connection established\n";