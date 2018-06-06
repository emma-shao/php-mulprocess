<?php

$childs = [];

// Fork10个子进程
for ($i = 0; $i < 10; $i++) {
    $pid = pcntl_fork();
    if ($pid == -1) {
        die('Could not fork');
    }

    if ($pid) {
        echo "父进程生成子进程({$pid}) \n";
        $childs[] = $pid;
    } else {
        $pid = posix_getpid();
        echo "子进程({$pid}) sleep {$i}秒后退出\n";
        sleep($i + 1);
        // 子进程需要exit，防止子进程也进入for循环
        exit();
    }
}

while(count($childs) > 0) {
    foreach($childs as $key => $pid) {
        $res = pcntl_waitpid($pid, $status, WNOHANG);

        // -1代表error,大于0代表子进程已退出，返回的是子进程的pid
        if ($res == -1 || $res > 0){
            unset($childs[$key]);
        }
    }
    sleep(1);
}