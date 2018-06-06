<?php
umask(0);
$pid = pcntl_fork();
if (-1 == $pid) {
    // 出错退出
    exit("Daemonize fail, can not fork");
} 
elseif ($pid > 0) {
    // 父进程，退出
    exit(0);
}
if (-1 == posix_setsid()) {
    exit('Daemonize fail, setsid fail');
}