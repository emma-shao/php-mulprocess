<?php
/**
 * 父子进程是否存在数据共享
 */
// 全局数据
$a = 10;
$pid = pcntl_fork();

if ($pid > 0) { //父进程
    sleep(2);  // 让子进程先改变数据
    echo "父进程(" . posix_getpid() . ") \$a={$a}\n";
} else {
    echo "子进程" . posix_getpid() . "\$a={$a}改变前\n";
    $a = 8;
     echo "子进程" . posix_getpid() . "\$a={$a}改变后\n";
}