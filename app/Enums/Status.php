<?php

namespace App\Enums;

enum Status : string
{
    case OK = 'OK';
    case WARN = 'WARN';
    case ALERT = 'ALERT';
}
