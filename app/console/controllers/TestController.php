<?php
namespace App\Console\Controllers;

use App\Common\Controllers\BaseController;
use App\Common\Models\Notice;
use App\Common\Models\Product;

class TestController extends BaseController
{

    public function initialize() {
        parent::initialize();

    }

    public function indexAction() {
        
    }

    public function testAction() {
        $arr = array();
        for ($i=0; $i<20; $i++) {
            $arr[] = array("name"=>'name'.$i, "age"=>$i);
        }
        return $this->toJson2($arr);
    }

    /**
     * 区域树
     *
     * 传入参数：无
     * 返回区域树所需的JSON
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function treeAction() {
        $sql = 'CALL region_select_tree(?, ?)';
        $result = $this->db->query($sql, array(330122000000, 4));
        $result->setFetchMode(\Phalcon\Db::FETCH_OBJ);
        $rows = $result->fetchAll();

        $result = [];
        $preLevel = 0;
        $parents = [];
        //数据过滤
        $filter = $this->authed->regionId;
        foreach ($rows as $row) {
            if ($row->id == $filter || $row->parentId == $filter || $row->id == "330122000000" || $filter == null)
            {
                $row->label = $row->name;
                $row->text = $row->name;

                if ($row->level == 1) {
                    $result[] = $row;
                    $parents = [$row];
                    $preLevel = 0;
                    continue;
                }

                $parent = $parents[$row->level - 2];
                if (!isset($parent->children)) {
                    $parent->children = [];
                }
                $parent->children[] = $row;

                if ($row->level != $preLevel) {
                    $preLevel = $row->level;
                    $parents[$row->level - 1] = $row;
                }
            }
        }
        return $this->toJson($result);
    }

    // 比较三个数最大数
    public function compareAction($a, $b, $c) {
        $a = $a>$b?$a:$b;
        $a = $a>$c?$a:$c;

        return $this->toJson2($a);
    }


}