<?php
/*
 +-------------------------------
 *    @socket通信整个过程
 +-------------------------------
 *    @socket_create
 *    @socket_bind
 *    @socket_listen
 *    @socket_accept
 *    @socket_read
 *    @socket_write
 *    @socket_close
 +--------------------------------
 */

//error_reporting(E_ALL);
//header("Content-Type:text/html;charset=utf-8");
set_time_limit(0);
$addressIp = '127.0.0.1'; //ip地址
$port = 10000;  //端口

try{
    do{
        //创建套接字
        $sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
        if ($sock === false) {
            //echo '创建套接字错误';
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);
            die("Couldn't create socket: [$errorcode] $errormsg");
            exit;
        }
        //循环接收套接字

        //绑定套接字
        if (socket_bind($sock,$addressIp,$port) === false) {
            echo '绑定套接字错误'.socket_strerror(socket_last_error($sock));
            exit;
        }
        //监听套接字
        if (socket_listen($sock) === false) {
            echo '监听套接字错误';
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);
            var_dump($errormsg);
            die("[$errorcode]");
            exit;
        }
        $msgsock = socket_accept($sock);
        if ($msgsock === false) {
            echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
            break;
        } else {
            //发送客户端
            $msg = "测试成功! \n";
            if (socket_write($msgsock,$msg,strlen($msg)) === false) {
                echo "socket_write() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
                break;
            } else {
                echo "测试成功了啊\n";
                $buf = socket_read($msgsock,8192);
                $talkback = "收到的信息:".$buf;
                echo $talkback;
            }
        }
        //关闭套接字
        socket_close($msgsock);
    } while (true);

} catch (\Exception $e) {
     print_r([
         'file' => $e->getFile(),
         'line' => $e->getLine(),
         'error' => $e->getMessage(),
     ]);
}






