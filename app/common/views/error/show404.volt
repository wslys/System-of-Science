<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<title>Page Not Found</title>
<style type="text/css">
body {
    background:#ccc;
}
h1 {
    font-size: 5em;
    color:red;
    margin:0;
}
.wrapper {
    margin:5%;
    padding: 5%;
    text-align: center;
    background-color: #fff;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    box-shadow: #999 0 2px 10px;
    -moz-box-shadow: #999 0 2px 10px;
    -webkit-box-shadow: #999 0 2px 10px;
}
.extra {
    font-family: Consolas, Lucida Console, Monaco, Andale Mono, "MS Gothic", monospace;
    font-size: 1.1em;
    line-height: 1.8em;
    border-top: 1px solid red;
    border-bottom: 1px solid red;
    padding: 20px 0;
    margin: 10px 0;
}
.from { color: green;  }
.msg { color: red }
</style>
</head>
<body>
<div class="wrapper">
    <h1><i class="fa fa-times-circle"></i></h1>
    <div>您访问的页面未找到</div>

{% if config.app.debug %}
    <div class="extra">
        <div class="from">{{ from }}</div>
        {% if message is defined %}<div class="msg">{{message}}</div>{% endif %}
    </div>

    <!--<div>本页面由 app/common/controllers/ErrorController 生成</div>-->
    <!--<div>对应视图文件在 app/common/views/error 目录</div>-->
    <!--<div>所有 Module 都使用此页面</div>-->
    <!--<div>但是在每个Module里都有一个ErrorController (继承自Common ErrorController)</div>-->
    <!--<div>多个 Module 之间不能 forward</div>-->

    <div>{% if params is defined %} {{ params }} {% endif %}</div>
{% endif %}
</div>
</body>
</html>

