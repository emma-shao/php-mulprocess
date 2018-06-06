<?php
/**
 * 父进程结束了，子进程并未结束，看此时子进程打印的父进程id
 */

if (pcntl_fork()) {
    echo sprintf("I am %d \n", posix_getpid());
} else {
    echo sprintf("I am %d, my father: %d\n", posix_getpid(), posix_getppid());
    while(1) {
        sleep(1);
    }
}