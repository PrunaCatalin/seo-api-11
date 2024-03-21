<?php

/*
 * wdirect-api | EnumMenuPosition.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/5/2023 12:24 PM
*/

namespace Modules\Tenants\App\Enums;

enum EnumMenuPosition: string
{
    case LEFT = 'left';
    case RIGHT = 'right';
    case TOP = 'top';
    case BOTTOM = 'bottom';

    case TOP_LEFT = 'top-left';
    case TOP_RIGHT = 'top-right';
    case BOTTOM_LEFT = 'bottom-left';
    case BOTTOM_RIGTH = 'bottom-right';
}
