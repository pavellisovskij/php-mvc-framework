<?php

namespace app\lib;

use Sirius\Validation\Rule\AbstractRule;

class PasswordRule extends AbstractRule
{
    // Сообщения об ошибках
    const MESSAGE = 'Пароль должен содержать в себе минимум одну букву в верхнем регистре, одну букву в нижнем регистре, одну цифру.';
    const LABELED_MESSAGE = '{label} должно содержать в себе минимум одну букву в верхнем регистре, одну букву в нижнем регистре, одну цифру.';

    function validate($value,string $valueIdentifier = null) :bool
    {
        return (bool) preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,16}$/', $value);
    }
}