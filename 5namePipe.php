<?php
// 定义管道路径与创建管道
$pipe_path = '/tmp/test.pipe';

if (!file_exists($pipe_path)) {
    if (!posix_mkfifo($pipe_path, 0664)) {
        exit("create pipe error!");
    }
}

$pid = pcntl_fork();
if ($pid == 0) {
    // 子进程，向管道写数据
    $file = fopen($pipe_path, 'w');
    while (true) {
        fwrite($file, 'Hello world!');
        $rand = rand(1, 3);
        sleep($rand);
    }
    exit("child end");
} else {
    // 从管道读数据
    $file = fopen($pipe_path, 'r');
    while (true) {
        $rel = fread($file, 20);
        echo "{$rel}\n";
        $rand = rand(1, 2);
        sleep($rand);
    }
}