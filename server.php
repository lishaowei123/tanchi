<?php

function get_client_ip(){
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return($ip);
}

function db($fq)
{

    define('DB_NAME','record');
    define('DB_USER','root');
    define('DB_PASSWD','980167048');
    define('DB_HOST','23.83.226.12');
    define('DB_TYPE','mysql');
    $dbh = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWD);

    $ip=uniqid('asdasd');

    $time=time();
    $sql="insert into user  (fq,uid,create_time) values ($fq,'$ip',$time)";

//echo $sql;

    $dbh->query($sql) ;
}

function dbAll()
{

    define('DB_NAME','record');
    define('DB_USER','root');
    define('DB_PASSWD','980167048');
    define('DB_HOST','23.83.226.12');
    define('DB_TYPE','mysql');
    $dbh = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWD);
    $sql="select *from user";
    return $dbh->query($sql) ;
}


header("Content-Type: text/html; charset=UTF-8");
$server = new swoole_websocket_server("0.0.0.0", 9502);
session_start();
$server->set(array(
    //'worker_num'  => 14,
    //'daemonize'   => 1, //是否作为守护进程,此配置一般配合log_file使用
//    'max_request' => 1000,
//    'log_file'    => './swoole.log',
//    'task_worker_num' => 8
));

$server->on('open', function ($server, $request) {
        //插入数据库
        db($request->fd);
        $m = file_get_contents( __DIR__ .'/log.txt');
        $retunr=array(
            'code'=>'0',
            'message'=> $request->fd.'--欢迎进入贪吃蛇大作战'
        );
        $server->push($request->fd,json_encode($retunr));

        //通知所有玩家
        $userinfo=[
            'fq'=>$request->fd,
            'name'=>"玩家".$request->fd
        ];
        $requestFd=json_encode(array(
            'code'=>'4002',
            'message'=>$userinfo['name'].'--进入房间'
        ));
    foreach($_SESSION["users"] as $k=>$i){
        $server->push($i, $requestFd );
    }
//        for ($i=1 ; $i<= $m ; $i++)
//        {
//
//        }
    $_SESSION["users"][$request->fd] = $userinfo;
    echo count($_SESSION['users'])."\n";
        file_put_contents( __DIR__ .'/log.txt' , $request->fd);
});

$server->on('message', function ($server, $frame) {

            $m = file_get_contents( __DIR__ .'/log.txt');
//            $data=explode(',',$frame->data);
            $data=explode(',',$frame->data);
            $array=json_decode($frame->data,true);
//    foreach(){
//        $server->push($i, $requestFd );
//    }
    foreach ($_SESSION["users"] as $i) {
                if($array['code']==200){
                    $requestArray=json_encode(array(
                        'code'=>'4007',
                        'fq'=>$frame->fd,
                        'message'=> '玩家'.$frame->fd.'说:'.$array['message']
                    ));
                    $server->push($i, $requestArray);
                }else{
                    $requestArray=json_encode(array(
                        'code'=>'4006',
                        'fq'=>$frame->fd,
                        'message'=>$frame->data
                    ));

                    $server->push($i, $requestArray);
                    echo 'fd=' . $i . 'm=' . $frame->fd . "\n";
                }
          }
});


$server->on('close', function ($server, $fd) {
   $m = file_get_contents( __DIR__ .'/log.txt');
    unset($_SESSION["user"][$fd]);
    $requestFd=json_encode(array(
        'code'=>'4003',
        'message'=>$_SESSION['users'][$fd]['name'].'---退出房间'
    ));
    foreach ($_SESSION["users"] as $i) {
        $server->push($i,  $requestFd );
    }
    var_dump($requestFd);
});

$server->start();
