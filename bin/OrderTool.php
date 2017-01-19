<?php


class OrderTool {

    private static function getConnection($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            'host'      => $config->db->host,
            'username'  => $config->db->username,
            'password'  => $config->db->password,
            'dbname'    => $config->db->dbname,
            'charset'   => $config->db->charset,
        ));
    }

    public static function processOrders($config) {
        $db = OrderTool::getConnection($config);

        $startCount = 0;
        $cycledCount = 0;
        $endingCount = 0;

        try {
            $db->begin();

            //已审核待生效订单 进入 STATE_STARTED 周期中, 第一周
            //$sql = "UPDATE orders SET curCycles = 1, state = 4 WHERE state = 3 AND startTime < NOW()";
            //$success = $db->execute($sql);
            //if (!$success) throw new \Exception("start orders error");

            //$startCount = $db->affectedRows();

            //刷新周期中订单的周期数
            $sql = "UPDATE orders SET curCycles = floor((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(startTime)) / (7*86400)) + 1 WHERE state = 4";
            $success = $db->execute($sql);
            if (!$success) throw new \Exception("cycle orders error");
            $cycledCount = $db->affectedRows();

            //周期数超界时进入 STATE_ENDING，提货状态进入已过期
            $sql = "UPDATE orders SET state = 5, takeState = 4 WHERE state = 4 AND curCycles > maxCycles";
            $success = $db->execute($sql);
            if (!$success) throw new \Exception("ending orders error");
            $endingCount = $db->affectedRows();

            $db->commit();
            $errmsg = null;
        } catch (\Exception $ex) {
            $db->rollback();
            $errmsg = $ex->getMessage();
        }
        return array(
            "errmsg" => $errmsg,
            "startCount" => $startCount,
            "cycledCount" => $cycledCount,
            "endingCount" => $endingCount
        );
    }

    /**
     * 生效订单，每月10日凌晨0:00 自动计算，使已审核的订单生效
     */
    public static function X_startOrders($config) {
        $db = OrderTool::getConnection($config);

        $sql = "UPDATE orders SET curCycles = 1, takeState = 1, state = 4, startTime = ? WHERE state = 3";
        $success = $db->execute($sql, array(date("Y-m-d H:i:s")));
        $startCount = $db->affectedRows();
        $db->close();

        return $success ? $startCount: -1;
    }

    /**
     * 刷新周期, 以付款时间为计算基点
     */
    public static function X_refreshCycles($config) {
        $db = OrderTool::getConnection($config);

        $cycledCount = 0;
        $endingCount = 0;
        $errmsg = null;
        try {
            $db->begin();
            $sql = "UPDATE orders SET curCycles = floor((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(payTime)) / (7*86400)) + 1 WHERE state = 4";
            $success = $db->execute($sql);
            if ($success) {
                $cycledCount = $db->affectedRows();
            } else {
                $errmsg = "cycle error";
                throw new \Exception();
            }
            // TAKE_STATE_EXPIRED = 4
            $sql = "UPDATE orders SET state = 5 WHERE state = 4 AND curCycles > maxCycles";
            $success = $db->execute($sql);
            if ($success) {
                $endingCount = $db->affectedRows();
            } else {
                $errmsg = "ending error";
                throw new \Exception();
            }
            $db->commit();
            $db->close();
        } catch (\Exception $e) {
            $db->rollback();
        }

        return array("errmsg" => $errmsg, "cycledCount" => $cycledCount, "endingCount" => $endingCount);
    }
}