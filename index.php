<?php
//function get_client_ip(){
//if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
//$ip = getenv("HTTP_CLIENT_IP");
//else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
//$ip = getenv("HTTP_X_FORWARDED_FOR");
//else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
//$ip = getenv("REMOTE_ADDR");
//else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
//$ip = $_SERVER['REMOTE_ADDR'];
//else
//$ip = "unknown";
//return($ip);
//}
//
//function db()
//{
//
//    define('DB_NAME','record');
//    define('DB_USER','root');
//    define('DB_PASSWD','980167048');
//    define('DB_HOST','23.83.226.12');
//    define('DB_TYPE','mysql');
//    $dbh = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWD);
//
//$ip=get_client_ip();
//
//$time=time();
//$sql="insert into record  (ip,create_time) values ('$ip',$time)";
//
////echo $sql;
//
// $dbh->query($sql) ;
//}
//db();
//?>

<!--table表格样式-->
<meta charset="utf-8"/>
<meta name="keywords" content="swoole+php多人在线在线贪吃蛇"/>
<meta name="description" content="swoole+php多人在线在线贪吃蛇"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>swoole+php多人在线在线贪吃蛇
</title>
<!--<script src="http://instantclick.io/v3.1.0/instantclick.min.js" data-no-instant></script>-->
<!--<script data-no-instant>InstantClick.init();</script>-->
<!--<style>-->
<!--    #instantclick-bar {-->
<!--        background: blue;-->
<!--    }-->
<!--</style>-->
<head><meta charset="UTF-8"/>
    </head>

<style>
    body{
        margin: 0px;
    }
    table{
        position: relative;
        float: left;
        margin: auto;
        width: 100%;
        height: 100%;
        border-collapse: collapse;
        background-image: url("./1.jpg");
        background-size: 100% 100%;
    }
    td{
        border: 0px solid red;
    }

    /*生成实物*/
    .black{
        /*//background: green;*/

        /*display: block;*/
        background-size: 30px 30px;
        background-image: url(0.jpg);
    }
    /*蛇的样式*/
    .red{
        background-size: 30px 30px;
        background-color: red;
        /*background-image: url(1.jpg);*/
    }
    .yellow{
        background-size: 30px 30px;
        background-color: yellow;
        /*background-image: url(1.jpg);*/
    }
    .r{
        /*width: 60px;*/
        /*height: 60px;*/
        /*background-size: 60px 60px;*/
        /*background-image: url(3.jpg);*/
        background-color: black;
        border-radius: 40px;
    }
    #load{
        position: absolute;
        float: left;
        height: 500px;
        width: 100px;
        border-right: 1px solid brown;
        color: white;
        overflow:auto;
        z-index: 1000;
    }
    #load1{
        position: absolute;
        margin-left: 150px;
        color: red;
         float: left;
        background-color: black;
         height: auto;
         width: 300px;
         /*border: 1px solid #433444;*/
         /*overflow:auto;*/
        z-index: 1000;
     }
    #content{
        color: black;
        font-size: 30px;

        width: 600px;
        height: 40px;
        border: 2px solid lawngreen;
        background-color:transparent;
    }
    #se{

        position: absolute;
        display: block;
        margin-top: 460px;
        margin-left: 460px;

        float: left;
        z-index: 200000;
    }
    #a{
        position: absolute;
        z-index: 1001;
    }
    #load2{
        position: absolute;
        margin-top: 400px;
        float: left;
        height: auto;
        width: 150px;
        z-index: 1000;
        /*border: 1px solid #433444;*/
        /*overflow:auto;*/
    }
</style>
<body style="position: relative">

<MARQUEE id=a onmouseover=a.stop() style="FONT-SIZE: 9pt; COLOR: white"
         onmouseout=a.start() scrollAmount=2 direction=up width=150 bgColor=#6699ff
         height=auto>
    <div id="sendContent" style="display: none">

    </div></MARQUEE>
<!--<div id="load"></div>-->
<div id="text"></div>

    <div id="load1">
        <div id="load2">

        </div>

    </div>
<p id="se"><input  type="text" id="content" style="color: white" placeholder="请输入要说的话" onkeypress="CheckInfo()" >
 </p>


<script type="text/javascript" src='http://apps.bdimg.com/libs/jquery/1.6.4/jquery.js'></script>
<script>

    function CheckInfo()
    {
        if (event.keyCode==13)
        {
            t1();
            //alert(textbox1.text);
        }
    }

function t1(){
var e=document.getElementById('content').value;
var a={"code":200,"message":e};

    exampleSocket.send(JSON.stringify(a));
    document.getElementById('content').value='';
}

</script>
<table></table>
</body>


<!--地图初始化-->
<script type="text/javascript">
    //动态创建20个td
    var tds=50; //定义td生成数
    var trs=30; //定义tr生成数

    function td(){
        for(var i=0,html='';i<tds;i++){
            html=html+'<td></td>';
        }
        return html;
    }
    //动态创建20个tr并把20td塞入
    function table(){
        for(var i=0;i<trs;i++){
            $('table:eq(0)').append('<tr></tr>'); //生成tr
            $('tr:eq('+i+')').append("'"+td()+"'"); //塞入20个td
        }
    }
    table();//创建地图
</script>

<!--随机食物-->
<script type="text/javascript">
    //蛇的初始位置
    var bs=Math.floor(Math.random()*999);
    var r=[bs,bs-1];
    var a=null;
    var Key=null; //获取按键
    var step=1; //左右按键走一步
    var top=100; //上下走20步



    //生成随机食物
    function foodRand(){
        var b=Math.floor(Math.random()*99);
        console.log($.inArray(b,r));
        //判断是否随机蛇的身上存在继续随机食物
        if($.inArray(b,r)>=0){
            foodRand();
        }
        $('td:eq('+b+')').addClass('black');
    }
    var json={};
//    记录蛇走的线路
    function addR1(n){
        a=r[0]-n; //新走的步数
        r.unshift(a);//塞数组
        r.pop();//删除最后一个
        exampleSocket.send(r);
      //  return r;
    }

    function addR2(n){
        a=r[0]+n;
        r.unshift(a);
        r.pop();

        exampleSocket.send(r);
        //return r;
    }
    function caler(rssss,s)
    {
        for(var i=0;i<rssss.length;i++){
            $('td:eq('+rssss[i]+')').removeClass();
            console.info(rssss[i]);
            console.info('----');
        }
        sun(rssss,s);
    }
    //获取按键执行蛇
    function createSnake(an){
        //删除蛇走的路
//        for(var i=0;i<r.length;i++){
//            $('td:eq('+r[i]+')').removeClass();
//        }
        //获取按键重新生成蛇的长度
        switch (an)
        {
            case 37:
                addR1(1);

                break;
            case 38:
                addR1(50);
                break;
            case 39:
                addR2(1);
                break;
            case 40:
                addR2(50);
                break;
        }
       // console.info(r);
        //sun(r,goods);
        //创建蛇的长度第一个为蛇头

    }
    var getRandomColor = function(){

        return  '#' +
                (function(color){
                    return (color +=  '0123456789abcdef'[Math.floor(Math.random()*16)])
                    && (color.length == 6) ?  color : arguments.callee(color);
                })('');
    }
    is=0;
    //    初始化
    function sun(r,s)
    {
        for(var i=0;i<r.length;i++){
            if (i==0) {
                $('td:eq('+r[i]+')').addClass('r');
                console.info(r[i]);
            }else{
                //alert(getRandomColor());


                    if(s%2==0){
                        $('td:eq('+r[i]+')').addClass('yellow');
                    }else{
                        $('td:eq('+r[i]+')').addClass('red');
                    }

                console.info(r[i]);
            }
        }
        sw[data.fq]=res;
    }
    var goods=1;
    var exampleSocket = new WebSocket("ws://23.83.226.12:9502");
    exampleSocket.onopen = function (event) {
//        exampleSocket.send("连接服务器成功");
        exampleSocket.send(r);
    };

    var an=null;//获取按键值
    var aa=null;//自动走
    var time=100;//时间
    function Run(){


        $('body').keydown(function(ev){
            Key=ev.which;//获取按键
            console.info(Key);
            createSnake(Key);
            if(Key==39){
                clearInterval(aa);
                aa=setInterval('tt('+Key+')',time);
            }else if(Key==37){
                clearInterval(aa);
                aa=setInterval('tt('+Key+')',time);
            }else if(Key==38){
                clearInterval(aa);
                aa=setInterval('tt('+Key+')',time);
            }else if(Key==40){
                clearInterval(aa);
                aa=setInterval('tt('+Key+')',time);
            }
        });

    }

    //执行
    function tt(an){
//        for(var i=0;i<r.length;i++){
//
//            $('td:eq('+r[i]+')').removeClass();
//        }
        console.log(an);
        if(an==37){
            addR1(1);
            //pan();

        }else if(an==39){

            addR2(1);
           // pan();

        }else if(an==38){

            addR1(50);
           // pan();
        }else if(an==40){

            addR2(50);
            //pan();

        }

        for(var i=0;i<r.length;i++){
            if (i==0) {
                $('td:eq('+r[i]+')').addClass('r');
            }else{

                $('td:eq('+r[i]+')').addClass('red');
            }
        }
    }

    //foodRand();//随机食物

    Run(); //
    var data;
    var sw=[];//本地用户存档
    var html;
    var res;
    function settime()
    {
        document.getElementById("sendContent").style.display='none';
    }
    exampleSocket.onmessage = function (event) {

        data=$.parseJSON(event.data);
        console.info(data.code);
        if(data.code==0 ||data.code==4003 ||data.code==4002){
            html = document.getElementById("sendContent").innerHTML;
            document.getElementById("sendContent").innerHTML= html + data.message+"<br>";
            document.getElementById("sendContent").style.display='block';
            setTimeout(settime,10000);
        }
        if(data.code==4007){
            html = document.getElementById("load1").innerHTML;
            document.getElementById("load1").innerHTML= html + data.message+"<br>";
        }
        if(data.code==4006){
//            html = document.getElementById("load").innerHTML;
//            document.getElementById("load").innerHTML= html + data.message+"<br>";
//            $("#load").scrollTop(1000000);


                //存在存起来sun初始化一条蛇;
//            console.log(data.message);
//            console.log(1111);
            res= data.message.split(',');
            console.info(sw);
            if(sw[data.fq]==null){

                sun(res,data.fq);


            }else{
                console.info(22222);
                red=sw[data.fq];
                console.info(red);
                caler(red,data.fq);
                console.info(11111);

            }
            console.info(data.message.split(','));
            console.info(sw[data.fq]);

                //console.info(s[data.fq]);
                // 生成本次记录哭


            //s[data.fq]=data.message.split(',');

            //console.info(s[data.fq]);
        }

    };
//    多条蛇创建
    //sun(r); //创建默认蛇
</script>


<!--服务器同步-->
<script type="text/javascript">

</script>


