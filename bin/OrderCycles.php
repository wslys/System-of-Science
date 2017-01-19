<?php

include_once "OrderTool.php";

$config = include_once "../config/config.php";

OrderTool::processOrders($config);