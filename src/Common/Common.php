<?php


namespace App\Common;


class Common
{
    public static function parseExceptionToResponseArray(\Exception $_e)
    {
        return [
            'result' => ['message' => $_e->getMessage()],
            'code' => 400,
            'headers' => []
        ];
    }
}
