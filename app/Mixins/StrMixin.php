<?php

/*
 * API NED CURIER | StrMixin.php
 * https://www.webdirect.ro/
 * Copyright 2022 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/3/2022 8:45 AM
*/

namespace App\Mixins;

class StrMixin
{
    /**
     * @param string $string
     * @return \Closure
     */
    public function toPascalName(): \Closure
    {
        return function ($string) {
            return ucwords(str_replace(
                ' ',
                '',
                ucwords(str_replace('-', ' ', $string))
            ));
        };
    }
}
