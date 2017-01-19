<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

  <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <title>500</title>
  <style type="text/css">
    body {
      background:#eee;
      font-size: 20px;
    }
    h1 {
      font-size: 5em;
      color:red;
      margin:0;
    }
    .wrapper {
      margin:5%;
      padding: 5%;
      background:#fff;
      text-align: center;
      border-radius: 14px;
      box-shadow: 0 0 1px rgba(0,0,0,.25);
    }
    .wrapper div {
      line-height: 2;
    }

  </style>
</head>
<body>
<div class="wrapper">
    <h1>500</h1>
    <div>Server Exception</div>
    {% if config.app.debug %}
    <div>{{ from }}</div>
    <div>{% if params is defined %} {{ params }} {% endif %}</div>
    {% endif %}
</div>
</body>
</html>