<?php

namespace Test;

use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * Class AppTest
 * @package Test
 */
class AppTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     *
     */
    const SERVER = 'http://localhost:8000';

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['http_errors' => false]);
        libxml_use_internal_errors(true);
    }


    /**
     * @param string $url
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatusCode(string $url):int
    {
        return $this->client->request('GET', self::SERVER . $url)->getStatusCode();
    }


    /**
     * @param $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @dataProvider urlOkProvider
     */
    public function testStatusSuccess($url)
    {
        $this->assertEquals(200, $this->getStatusCode($url));
    }


    /**
     * @param $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @dataProvider urlBonusOkProvider
     */
    public function testStatusSuccessBonus($url)
    {
        $this->assertEquals(200, $this->getStatusCode($url));
    }

    /**
     * @return array
     *
     */
    public function urlOkProvider(): array
    {
        $urls = [
            ['Home' => '/'],
            ['Beast index' => '/beast/list'],
            ['Beast details' => '/beast/details/5'],
            ['Beast edit' => '/beast/edit/5'],
        ];
        return $urls;
    }

    /**
     * @return array
     *
     */
    public function urlBonusOkProvider(): array
    {
        $urls = [
            ['Movie index' => '/movie/list'],
            ['Movie details' => '/movie/details/5'],
            ['Movie edit' => '/movie/edit/5'],
            ['Planet index' => '/planet/list'],
            ['Planet details' => '/planet/details/5'],
            ['Planet edit' => '/planet/edit/5'],
        ];
        return $urls;
    }

}
