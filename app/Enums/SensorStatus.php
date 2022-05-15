<?php

namespace App\Enums;

enum SensorStatus : string
{
    case OK = 'OK';
    case WARN = 'WARN';
    case ALERT = 'ALERT';
}
