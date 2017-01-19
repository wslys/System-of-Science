<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<?php echo $this->tag->getTitle(); ?>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $libpath; ?>/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $libpath; ?>/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/res/common.css">
<?php echo $this->assets->outputCss(); ?>
<?php echo $this->assets->outputInlineCss(); ?>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-app">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/favicon.ico" height="100%">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li style="visibility: hidden"><a href="/">首页</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($authed->isGuest()) { ?>
                    <li><a href="/auth/signin">登录</a></li>
                    <?php } else { ?>
                    <li><a href="/console"><?php echo $authed->username; ?></a></li>
                    <li><a href="/auth/signout">注销</a></li>
                    <?php } ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <?php echo $this->getContent(); ?>

    <script type="text/javascript" src="<?php echo $libpath; ?>/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $libpath; ?>/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <?php echo $this->assets->outputJs(); ?>
</body>
</html>