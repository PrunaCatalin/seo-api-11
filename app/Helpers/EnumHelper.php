<?php

namespace App\Helpers;

class EnumHelper
{
    /**
     * Convert an Enum class to an array of its values.
     *
     * @param string $enumName
     * @return array
     */
    public static function getEnumValues(string $enumName): array
    {
        return array_map(fn($case) => $case->value, $enumName::cases());
    }

    /**
     * Get a mapping of enum values to their names.
     *
     * @param string $enumName
     * @return array
     */
    public static function getEnumValueNameMapping(string $enumName): array
    {
        return array_combine(
            array_map(fn($case) => $case->value, $enumName::cases()),
            array_map(fn($case) => $case->name, $enumName::cases())
        );
    }
}
