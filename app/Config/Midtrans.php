<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = '';

    public $clientKey = '';

    public $isProduction = false;

    public $isSanitized = true;

    public $is3ds = true;
}