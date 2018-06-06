<?php

/**
 * 父进程通过pcntl_wait等待子进程退出
 * 子进程通过信号kill自己，也可以在父进程中发送kill信号结束子进程
 */

// 生成子进程
$pid = pcntl_fork();

if ($pid == -1) {
    die("could not fork");
}elseif($pid) {
    $status = 0;
    //阻塞父进程，直到子进程结束，不适合需要长时间运行的脚本
    //可使用pcntl_wait($status, WNOHANG)实现非阻塞式
    echo "阻塞父进程\n";
    pcntl_wait($status);
    exit;
}else{
    if(function_exists('posix_kill')) {
        echo "使用posix_kill子进程\n";
        posix_kill(getmypid(), SIGTERM);
    } else {
        echo "使用命令行Kill子进程\n";
        system('kill -9 ' .getmypid());
    }
    exit;
}
