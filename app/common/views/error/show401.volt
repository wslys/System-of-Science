<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

  <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <title>请求未授权</title>
  <style type="text/css">
    body {
      background:#eee;
      font-size: 20px;
    }
    h1 {
      font-size: 5em;
      margin:0;
    }
    .wrapper {
      margin:5%;
      padding: 5%;
      background:#fff;
      text-align: center;
      border-radius: 4px;
      box-shadow: 0 0 1px rgba(0,0,0,.25);
    }
  </style>
</head>
<body>
<div class="wrapper">
    <h1><i class="fa fa-user-secret"></i></h1>
    <div>请求未授权</div>
    {% if config.app.debug %}<div>{{ module }}:{{ controller }} - {{ action }}</div>{% endif %}
</div>
</body>
</html>