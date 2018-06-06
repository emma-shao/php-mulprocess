<?php

$file = fopen('/tmp/share.txt', 'a');

$pid = pcntl_fork();
if ($pid) { // 父进程
    sleep(1);
    fwrite($file, "father({$pid})\n");
} else {
    fwrite($file, "child " . posix_getpid() . "\n");
}
fclose($file);