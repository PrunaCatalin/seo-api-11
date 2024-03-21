<?php

/*
 * wdirect-api | FilterServiceSuccess.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/10/2024 12:58 PM
*/

namespace Modules\Tenants\App\Enums\Filter;

enum FilterServiceSuccess: string
{
    case FilterCreationSuccess = 'Filter created successfully';
    case FilterUpdateSuccess = 'Filter is update successfully';
    case FilterValueCreationSuccess = 'Filter value created successfully';
    case FilterValueUpdatedSuccess = 'Filter value updated successfully';
    case FilterValueDeleteSuccess = 'Filter value deleted successfully';
    case FilterDeleteSuccess = 'Filter deleted successfully.';
    case FilterSelectedDeleteSuccess = 'Selected filters deleted successfully';
}
