<?php
/**
 * 父子进程
 */
if (pcntl_fork()) {
    // 父进程晚点结束为等待子进程结束后再执行
    sleep(1);
    echo sprintf("I am %d\n", posix_getpid());
} else {
    echo sprintf("I am %d, my father: %d\n", posix_getpid(), posix_getppid());
}