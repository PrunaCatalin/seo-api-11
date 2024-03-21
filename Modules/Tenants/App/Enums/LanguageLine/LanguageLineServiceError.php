<?php

namespace Modules\Tenants\App\Enums\LanguageLine;

enum LanguageLineServiceError: string
{
    case CreationError = 'Error occurred during LanguageLine creation: ';
    case UpdateFailed = 'Error occurred during LanguageLine update';
    case LanguageLineNotFound = 'LanguageLine not found: ';
    case NotFoundForDeletion = 'LanguageLine record not found for deletion';
    case DeletionError = 'Error occurred during LanguageLine deletion: ';
    case DuplicateError = 'Duplicate LanguageLine record found';
    case DeleteAllError = 'You must select a proper element to delete.';
    // Add additional error cases as needed
}
