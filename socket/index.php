<?php
/*
 +-------------------------------
 *    @socket连接整个过程
 +-------------------------------
 *    @socket_create
 *    @socket_connect
 *    @socket_write
 *    @socket_read
 *    @socket_close
 +--------------------------------
 */

error_reporting(E_ALL);
set_time_limit(0);

$addressIp = '127.0.0.1'; //ip
$port = 10000; //端口
//创建套接字链接
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if ($socket === false) {
    echo 'socket_create()失败，错误为'.socket_strerror(socket_last_error());
    exit;
}
//链接套接字
if (socket_connect($socket,$addressIp,$port) === false) {
    echo 'socket_connect()失败，错误为'.socket_strerror(socket_last_error());
    exit;
} else {
    echo "连接成功！\n";
}
$message = "就是这样，测试成功了!\n";
//将信息写入buf缓存，传递到服务端
if (socket_write($socket,$message,strlen($message)) === false) {
    echo 'socket_write()失败，错误为'.socket_strerror(socket_last_error());
    exit;
} else {
    //接收服务端返回信息
    $out = '';
    while ($out = socket_read($socket,8192)) {
        echo $out;
    }
}
echo "关闭套接字\n";
socket_close($socket);
echo "已关闭套接字";






