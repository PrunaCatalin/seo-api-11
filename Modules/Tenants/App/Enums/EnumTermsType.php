<?php
/*
 * wdirect-api | EnumTermsType.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 10:39
*/

namespace Modules\Tenants\App\Enums;

enum EnumTermsType: string
{
    case SMS = 'sms';
    case EMAIL = 'email';
    case TERMS_AND_CONDITIONS = 'terms';


}
