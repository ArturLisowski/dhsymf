<?php


namespace App\Common;

use Symfony\Component\HttpFoundation\Response;

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

    public static function prepareResponseFromResult($result)
    {
        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }
}
