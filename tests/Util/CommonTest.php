<?php

namespace App\Tests\Util;

use App\Common\Common;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Exception;

class CommonTest extends TestCase
{
    public function parseExceptionToResponseArrayPositiveDataProvider()
    {
        $_e = new Exception('test', 400);
        return [
            [
                $_e,
                [
                    'result' => ['message' => 'test'],
                    'code' => 400,
                    'headers' => []
                ]
            ]
        ];
    }

    /**
     * @param /Exception $_e
     * @param $expectedResponse
     * @dataProvider parseExceptionToResponseArrayPositiveDataProvider
     */
    public function testParseExceptionToResponseArrayPositive($_e, $expectedResponse)
    {
        $this->assertEquals(Common::parseExceptionToResponseArray($_e), $expectedResponse);
    }

}