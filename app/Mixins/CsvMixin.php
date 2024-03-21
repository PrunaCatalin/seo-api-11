<?php

namespace App\Mixins;

use Illuminate\Support\Facades\Storage;

class CsvMixin
{
    public function readCSVWithHeaders()
    {
        return function ($file = null) {
            $all_rows = ["headers" => [], "rows" => []];
            if ($file) {
                $disk = Storage::disk('local');
                $fileParse = $disk->readStream($file);
                $all_rows['headers'] = fgetcsv($fileParse);
                while ($row = fgetcsv($fileParse)) {
                    if (sizeof($row) == sizeof($all_rows['headers'])) {
                        $all_rows['rows'][] = array_combine($all_rows['headers'], $row);
                    }
                }
            }
            return $all_rows;
        };
    }
}
