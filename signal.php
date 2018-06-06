<?php
$parentPid = posix_getpid();
echo "Parent progress pid: {$parentPid}\n";

// 定义一个信号处理函数
function sighandler($signo) {
    $pid = posix_getpid();
    echo "{$pid} progress, oh no, I'm killed!\n";
    exit(1);
}

$pid = pcntl_fork();

if ($pid == -1) {
    // 创建失败
    exit("fork progress error!\n");
} elseif ($pid == 0) {
    // 子进程执行程序
    // 注册信号处理函数
    declare(ticks=10);
    pcntl_signal(SIGINT, 'sighandler');
    $pid = posix_getpid();
    while(true) {
        echo "{$pid} child progress is running!\n";
        sleep(1);
    }
    exit ("({$pid}) child progress end!\n");
} else {
    // 父进程执行程序
    $childList[$pid] = 1;
    // 5秒后，父进程向子进程发送sigint信号
    sleep(5);
    posix_kill($pid, SIGINT);
    sleep(5);
}
echo "({$parentPid}) main progress end!\n";