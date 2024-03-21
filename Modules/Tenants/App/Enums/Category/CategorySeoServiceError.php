<?php

/*
 * wdirect-api | CategorySeoServiceError.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/4/2024 6:19 PM
*/

namespace Modules\Tenants\App\Enums\Category;

enum CategorySeoServiceError: string
{
    case CreateError = '[Category Seo Service][Create] - ';
    case CreateInvalidData = '[Category Seo Service][Create-InvalidData]';
    case UpdateInvalidData = '[Category Seo Service][Update-InvalidData]';
    case UpdateNotFound = '[Category Seo Service][Update-NotFound]';
    case UpdateError = '[Category Seo Service][Update] - ';
    case DeleteNotFound = '[Category Seo Service][Delete-NotFound]';
    case DeleteError = '[Category Seo Service][Delete] - ';
}
