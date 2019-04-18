<?php

namespace Test;

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * Class AppTest
 * @package Test
 */
class AppTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     *
     */
    const SERVER = 'http://localhost:8000';

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->client = new \GuzzleHttp\Client();
        libxml_use_internal_errors(true);
    }

    /**
     * @param $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @dataProvider urlOkProvider
     */
    public function testStatusSucces($url)
    {
        $res = $this->client->request('GET', self::SERVER . $url);
        $status = $res->getStatusCode();
        $this->assertEquals(200, $status);
    }

    /**
     * @return array
     *
     */
    public function urlOkProvider()
    {
        $urls = [
            '/movie/lists',
            '/beast/list'
        ];
        return $urls;
    }
}
