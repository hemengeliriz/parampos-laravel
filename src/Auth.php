<?php

namespace Hemengeliriz\ParamposLaravel;

class Auth extends BaseType
{
    public function __construct()
    {
        $this->setProperty(Parameter::CLIENT_CODE, config('parampos-laravel.client_code'));
        $this->setProperty(Parameter::CLIENT_USERNAME, config('parampos-laravel.client_username'));
        $this->setProperty(Parameter::CLIENT_PASSWORD, config('parampos-laravel.client_password'));
        $this->setProperty(Parameter::GUID, config('parampos-laravel.guid'));
    }
}
