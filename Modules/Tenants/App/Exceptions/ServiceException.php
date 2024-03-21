<?php

namespace Modules\Tenants\App\Exceptions;

use Exception;

class ServiceException extends Exception
{
    protected array $data;

    public function __construct($message, $data = [])
    {
        parent::__construct($message);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getDataAsString(): ?string
    {
        return var_export($this->data, true);
    }
}
