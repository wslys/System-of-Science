<?php

namespace App\Common\Library;


use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;

class PhoneValidator extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        $value = $model->$field;

        if (! preg_match('/^1(3[0-9]|5[012356789]|8[0256789]|7[0678])\d{8}$/', $value)) {
            $message = $this->getOption('message');
            if (!$message) {
                $message = '手机号码格式错误';
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
