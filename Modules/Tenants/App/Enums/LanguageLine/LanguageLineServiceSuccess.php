<?php

namespace Modules\Tenants\App\Enums\LanguageLine;

enum LanguageLineServiceSuccess: string
{
    case LanguageLineCreationSuccess = 'LanguageLine created successfully';
    case LanguageLineUpdateSuccess = 'LanguageLine updated successfully';
    case LanguageLineDeleteSuccess = 'LanguageLine deleted successfully';
    case LanguageLineSelectedDeleteSuccess = 'Selected LanguageLine deleted successfully';

    // Add additional success cases as needed
}
