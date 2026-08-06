<?php

namespace App\Reader;

enum ReadersStatus: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case INACTIVE = 'inactive';
}
