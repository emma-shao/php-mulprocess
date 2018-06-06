<?php
// 最大的子进程数量
$maxChildPro = 8;

// 当前的子进程数量
$curChildPro = 0;

// 当前子进程退出时，会触发该函数，当前子进程数-1
function sig_handler($sig)
{
    global $curChildPro;
    switch($sig) {
        case SIGCHLD:
            echo 'SIGCHLD', PHP_EOL;
            $curChildPro--;
            break;
    }
}

// 配合pcntl_signal 使用，简单的说
// 是为了让系统产生事件云，让信号捕捉函数能够捕捉到信号量
declare(ticks = 1);

// 注册子进程退出时调用的函数。SIGCHLD: 
// 在一个进程终止或者停止时，将SIGCHLD信号发送给其父进程
pcntl_signal(SIGCHLD, 'sig_handler');
$j = 0;
while ($j < 10) {
    $curChildPro++;
    $pid = pcntl_fork();
    $curr_pid = posix_getpid();
    if ($pid) {
        // 父进程运行代码，达到上限时父进程组色等待任一子进程
        // 退出后while循环继续
        echo "主进程({$curr_pid})有子进程({$curChildPro})个\n";
        if ($curChildPro >= $maxChildPro) {
            pcntl_wait($status);
        }
    } else {
        echo "进入子进程:\n";
        // 子进程运行代码
        $s = rand(2, 6);
        sleep($s);
        echo "子进程({$curr_pid}) sleep ({$s})秒后退出\n";
        exit;
    }
    $j++;
}