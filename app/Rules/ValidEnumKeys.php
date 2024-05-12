<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEnumKeys implements ValidationRule
{
    private string $enumClass;

    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validKeys = array_map(fn($case) => $case->value, $this->enumClass::cases());

        foreach (array_keys($value) as $key) {
            if (!in_array($key, $validKeys)) {
                $fail("The $attribute key '$key' is not valid. It must be one of the valid enum keys.");
                return;
            }
        }
    }

    public function message(): string
    {
        return 'The :attribute has invalid keys based on the specified enum.';
    }
}
