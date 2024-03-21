<?php

/*
 * wdirect-api | CategoryDetailsService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 1/1/2024 2:38 PM
*/

namespace Modules\Tenants\App\Contracts;

use Exception;

/**
 * The CategoryDetailsService interface defines methods for getting, creating, updating, and deleting category details.
 */
interface CrudMicroService
{
    /**
     * Create a new record based on the provided data.
     *
     * @param array $data The data for the new record.
     *
     * @return void
     * @throws Exception If an error occurs while creating the record.
     *
     */
    public function create(array $data);

    /**
     * Updates the given data.
     *
     * @param array $data The data to be updated.
     *
     * @return void
     */
    public function update(array $data);

    /**
     * Deletes the given data.
     *
     * @param array $data The data to be deleted.
     */
    public function delete(array $data);
}
