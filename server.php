<?php
header("Content-Type: text/html; charset=UTF-8");
$server = new swoole_websocket_server("0.0.0.0", 9502);
session_start();
$server->set(array(
    'worker_num'  => 14,
    'daemonize'   => 1, //是否作为守护进程,此配置一般配合log_file使用
//    'max_request' => 1000,
//    'log_file'    => './swoole.log',
//    'task_worker_num' => 8
));

$server->on('open', function ($server, $request) {

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
        for ($i=1 ; $i<= $m ; $i++)
        {
            $server->push($i, $requestFd );
        }
        echo count($_SESSION['users'])."\n";
        $_SESSION["users"][$request->fd] = $userinfo;
        file_put_contents( __DIR__ .'/log.txt' , $request->fd);
});

$server->on('message', function ($server, $frame) {

            $m = file_get_contents( __DIR__ .'/log.txt');
//            $data=explode(',',$frame->data);
            $data=explode(',',$frame->data);
            $array=json_decode($frame->data,true);

            for ($i=1 ; $i<= $m ; $i++) {
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
    for ($i=1 ; $i<= $m ; $i++) {
        $server->push($i,  $requestFd );
    }
    var_dump($requestFd);
});

$server->start();
