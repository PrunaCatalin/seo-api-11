<?php

/*
 * wdirect-api | DomainServiceError.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 1/21/2024 12:03 PM
*/

namespace Modules\Tenants\App\Enums\Domain;

enum DomainServiceError: string
{
    case NotFoundOrCreationError = 'Error occurred during Domain creation or find: ';
    case DomainNotFound = 'Domain not found: ';
    case NotFoundOrUpdateError = 'Error occurred during Domain update or find: ';
    case NotFoundForDeletion = 'Domain record not found for deletion';
    case NotFoundValueForDeletion = 'Value record not found for deletion';
    case CreationError = 'Error occurred during Domain creation: ';
    case UpdateFailed = 'Error occurred during Domain updates';
    case DomainErrorDuplicate = 'There is other domain with this domain name , please choose a unique one';
    case DeletionError = 'Error occurred during Domain deletion: ';
    case DomainAlreadyExists = 'A domain with the given domain name already exists.';
    case DeleteAllError = 'You must select a proper element to delete.';
}
