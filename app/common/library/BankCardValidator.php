<?php

namespace App\Common\Library;


use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;

class BankCardValidator extends Validator implements ValidatorInterface
{
    // 计算身份证校验码，根据国家标准GB 11643-1999
    function idcard_verify_number($idcard_base){
        if(strlen($idcard_base)!=17){
            return false;
        }
        //加权因子
        $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        //校验码对应值
        $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
        $checksum=0;
        for($i=0;$i<strlen($idcard_base);$i++){
            $checksum += substr($idcard_base,$i,1) * $factor[$i];
        }
        $mod=$checksum % 11;
        $verify_number=$verify_number_list[$mod];
        return $verify_number;
    }


    function idcard_checksum18($idcard){
        if(strlen($idcard)!=18){
            return false;
        }
        $idcard_base=substr($idcard,0,17);
        if($this->idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))){
            return false;
        }else{
            return true;
        }
    }


    function checkBankCard($value) {
        $len = strlen($value);
        if ($len != 16 && $len != 19) return false;

        if (preg_match("/(\d{4})(\d{0,})(\d{4})/", $value, $match)) {
            return true;
        } else {
            return false;
        }
    }

    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        $value = $model->$field;

        if (! $this->checkBankCard($value)) {
            $message = $this->getOption('message');
            if (!$message) {
                $message = '银行卡号格式错误';
            }
            $this->appendMessage(
                $message,
                $field,
                "InvalidValue"
            );

            return false;
        }

        return true;
    }
}
