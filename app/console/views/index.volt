<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <title>某管理系统</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/css/fullcalendar.css" />
    <link rel="stylesheet" href="/css/matrix-style.css" />
    <link rel="stylesheet" href="/css/matrix-media.css" />
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/jquery.gritter.css" />
    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>-->
</head>
<body ng-controller="OsController">

<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.html"><img src="/img/logo.png"> 某管理系统</a></h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li  class="dropdown" id="profile-messages" ><a title="" href="" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">欢迎 Admin</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href=""><i class="icon-user"></i> 个人简介 </a></li>
                <li class="divider"></li>
                <li><a href=""><i class="icon-check"></i> 我的任务 </a></li>
                <li class="divider"></li>
                <li><a href="login.html"><i class="icon-key"></i> 注销 </a></li>
            </ul>
        </li>
        <li class="dropdown" id="menu-messages"><a href="" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">信息</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href=""><i class="icon-plus"></i> 最新消息</a></li>
                <li class="divider"></li>
                <li><a class="sInbox" title="" href=""><i class="icon-envelope"></i> 收件箱</a></li>
                <li class="divider"></li>
                <li><a class="sOutbox" title="" href=""><i class="icon-arrow-up"></i> 发件箱</a></li>
                <li class="divider"></li>
                <li><a class="sTrash" title="" href=""><i class="icon-trash"></i> 垃圾箱</a></li>
            </ul>
        </li>
        <li class=""><a title="" href=""><i class="icon icon-cog"></i> <span class="text"> 设置</span></a></li>
        <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text"> 注销</span></a></li>
    </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
    <input type="text" placeholder="Search here..."/>
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar">
    <a href="#" class="visible-phone"><i class="icon icon-home"></i></a>
    <ul>
        <li class="active"><a href="#/dashboard"><i class="icon icon-home"></i> <span>仪表板</span></a> </li>
        <li> <a href="#/chart"><i class="icon icon-signal"></i> <span>图表</span></a> </li>
        <li> <a href="#/widgets"><i class="icon icon-inbox"></i> <span>窗口小部件</span></a> </li>
        <li><a href="#/table"><i class="icon icon-th"></i> <span>表格</span></a></li>
        <li><a href="#/grid"><i class="icon icon-fullscreen"></i> <span>全宽度</span></a></li>
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>形式</span> <span class="label label-important">3</span></a>
            <ul>
                <li><a href="#/basicform">基本表单</a></li>
                <li><a href="#/form-validation">表单验证</a></li>
                <li><a href="#/form-wizard.html">表单向导</a></li>
            </ul>
        </li>
        <li><a href="#/buttons"><i class="icon icon-tint"></i> <span>按钮 &amp; 图标</span></a></li>
        <li><a href="#/interface"><i class="icon icon-pencil"></i> <span>元素</span></a></li>
        <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>插件</span> <span class="label label-important">5</span></a>
            <ul>
                <li><a href="#/dashboard2">仪表板2</a></li>
                <li><a href="#/gallery">画廊</a></li>
                <li><a href="#/calendar">日历</a></li>
                <li><a href="#/invoice">发票联</a></li>
                <li><a href="#/chat">聊天选项</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
            <ul>
                <li><a href="#/error403.html">Error 403</a></li>
                <li><a href="#/error404.html">Error 404</a></li>
                <li><a href="#/error405.html">Error 405</a></li>
                <li><a href="#/error500.html">Error 500</a></li>
            </ul>
        </li>
        <li class="content"> <span>每月带宽传输</span>
            <div class="progress progress-mini progress-danger active progress-striped">
                <div style="width: 77%;" class="bar"></div>
            </div>
            <span class="percent">77%</span>
            <div class="stat">21419.94 / 14000 MB</div>
        </li>
        <li class="content"> <span>Disk Space Usage</span>
            <div class="progress progress-mini active progress-striped">
                <div style="width: 87%;" class="bar"></div>
            </div>
            <span class="percent">87%</span>
            <div class="stat">604.44 / 4000 MB</div>
        </li>
    </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content1" ng-repeat="app in appManager.apps" ng-include="app.templateUrl" ng-show="app.active">
</div>

<div>
    <div ng-repeat="app in appManager.apps" ng-include="app.templateUrl" ng-show="app.active"></div>
</div>

<!--<div id="content">-->
    <!--&lt;!&ndash;breadcrumbs&ndash;&gt;-->
    <!--<div id="content-header">-->
        <!--<div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>-->
    <!--</div>-->
    <!--&lt;!&ndash;End-breadcrumbs&ndash;&gt;-->

    <!--<div ng-repeat="app in appManager.apps" ng-include="app.templateUrl" ng-show="app.active">-->

    <!--</div>-->
<!--</div>-->

{#
{{ content() }}
#}

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 2013 &copy; Matrix Admin. Brought to you by <a href="http://themedesigner.in/">Themedesigner.in</a> </div>
</div>

<script src="/js/excanvas.min.js"></script>
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.ui.custom.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.flot.min.js"></script>
<script src="/js/jquery.flot.resize.min.js"></script>
<script src="/js/jquery.peity.min.js"></script>

<script src="/lib/angular/1.4.8/angular.min.js"></script>
<script src="/lib/angular/1.4.8/angular-route.min.js"></script>
<script src="/lib/ocLazyLoad/1.0.9/ocLazyLoad.min.js"></script>

<script src="/console/os/app.js"></script>
<script src="/console/os/service.js"></script>
<script src="/console/os/os.js"></script>

<script src="/js/fullcalendar.min.js"></script>
<script src="/js/matrix.js"></script>
<script src="/js/matrix.dashboard.js"></script>
<script src="/js/jquery.gritter.min.js"></script>
<script src="/js/matrix.interface.js"></script>
<script src="/js/matrix.chat.js"></script>
<script src="/js/jquery.validate.js"></script>
<script src="/js/matrix.form_validation.js"></script>
<script src="/js/jquery.wizard.js"></script>
<script src="/js/jquery.uniform.js"></script>
<script src="/js/select2.min.js"></script>
<script src="/js/matrix.popover.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/matrix.tables.js"></script>

<!--end-Footer-part-->


<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage (newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-" ) {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>
</body>
</html>
