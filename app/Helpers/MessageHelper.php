<?php

namespace App\Helpers;

class MessageHelper
{
    public static function createdSuccessMessage(string $item): string
    {
        return ucfirst($item) . ' created successfully';

    }

    public static function updatedSuccessMessage(string $item): string
    {
        return ucfirst($item) . ' updated successfully';
    }

    public static function deletedSuccessMessage(string $item): string
    {
        return ucfirst($item) . ' deleted successfully';
    }

}
