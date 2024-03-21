<?php

/*
 * wdirect-api | FilterValuesServiceError.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/4/2024 7:45 PM
*/

namespace Modules\Tenants\App\Enums\Filter;

enum FilterValuesServiceError: string
{
    case CreationError = 'Error occurred during Filter Values creation: ';
    case NotFoundForDeletion = 'Filter Values record not found for deletion';
    case DeletionError = 'Error occurred during Filter Values deletion: ';
    case UpdateInvalidData = 'Error occurred during Filter Values UpdateInvalidData: ';
    case UpdateNotFound = 'Value not found: ';
    case UpdateError = 'Error occurred during Filter Values updates: ';
    case FilterValueAlreadyExists = 'Value already exist for this filter.';
    case DeleteAllError = 'You must select a proper element to delete.';
}
