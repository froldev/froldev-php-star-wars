<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use App\Service\Yodalizer;

/**
 * Class YodalizerTest
 * @package Test
 */
final class YodalizerTest extends TestCase
{
    /**
     * @param string $sample
     * @param string $expected
     * @dataProvider yodaStringProvider
     */
    public function testYodalization(string $sample, string $expected): void
    {
        $this->assertSame($expected, Yodalizer::yodalizeIt($sample));
    }


    /**
     * @return array
     */
    public function yodaStringProvider()
    {
        return [
          'One letter string'  => ['W', 'W'],
          'One word string'  => ['Wilder', 'Wilder'],
          'Two letters string'  => ['W C', 'C W'],
          'Two words string'  => ['Wilder forever', 'Forever Wilder'],
          'Many words string'  => ['You are a Wilder forever', 'Forever Wilder a are You'],
          'Another string with many words'  => ['I love PHP forever', 'Forever PHP love I'],
        ];
    }
}
