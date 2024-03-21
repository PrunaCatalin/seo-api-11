<?php

/*
 * wdirect-api | DomainServiceSuccess.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/21/2024 12:04 PM
*/

namespace Modules\Tenants\App\Enums\Domain;

enum DomainServiceSuccess: string
{
    case DomainCreationSuccess = 'Domain created successfully';
    case DomainUpdateSuccess = 'Domain updated successfully';
    case DomainValueCreationSuccess = 'Domain value created successfully';
    case DomainValueUpdatedSuccess = 'Domain value updated successfully';
    case DomainValueDeleteSuccess = 'Domain value deleted successfully';
    case DomainDeleteSuccess = 'Domain deleted successfully';
    case DomainSelectedDeleteSuccess = 'Selected domains deleted successfully';
}
