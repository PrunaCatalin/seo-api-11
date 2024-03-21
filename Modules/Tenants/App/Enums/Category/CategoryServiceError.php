<?php

/*
 * wdirect-api | EnumCategoryServiceError.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/4/2024 6:16 PM
*/

namespace Modules\Tenants\App\Enums\Category;

enum CategoryServiceError: string
{
    case CreationError = 'Error occurred during Category creation: ';
    case NotFoundForDeletion = 'Category record not found for deletion';
    case DeletionError = 'Error occurred during Category deletion: ';

    case NotFound = 'Category not found';
}
