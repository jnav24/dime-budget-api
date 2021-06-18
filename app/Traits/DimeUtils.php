<?php

namespace App\Traits;

trait DimeUtils
{
    /**
     * Checks if id is temp id or not
     *
     * @param $id
     * @return bool
     */
    protected function isNotTempId($id): bool
    {
        return (stripos($id, 'temp_') === false);
    }

    protected function convertSlugToSnakeCase(string $string): string
    {
        return str_replace('-', '_', $string);
    }
}
