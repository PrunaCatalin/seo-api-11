<?php

/*
 * wdirect-api | FilterServiceError.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/4/2024 7:45 PM
*/

namespace Modules\Tenants\App\Enums\Filter;

enum FilterServiceError: string
{
    case CreationError = 'Error occurred during Filter creation: ';
    case UpdateFailed = 'Error occurred during Filter updates';
    case FilterErrorDuplicate = 'There is other filter with this name , please choose a unique one';
    case NotFoundOrCreationError = 'Error occurred during Filter creation or find: ';
    case FilterNotFound = 'Filter not found: ';
    case NotFoundOrUpdateError = 'Error occurred during Filter update or find: ';
    case NotFoundForDeletion = 'Filter record not found for deletion';
    case NotFoundValueForDeletion = 'Value record not found for deletion';
    case DeletionError = 'Error occurred during Filter deletion: ';
    case FilterAlreadyExists = 'A filter with the given name already exists.';
    case DeleteAllError = 'You must select a proper element to delete.';
}
