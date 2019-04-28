<?php

namespace SeoScraper\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use SeoScraper\Common\HttpMethods;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    /**
     * How many redirects will we allow to be made in a request
     *
     * @const int
     */
    private const DEFAULT_REDIRECTS_ALLOWED = 0;

    /**
     * @var Client
     */
    private $client;

    public function __construct(array $configuration = [])
    {
        $configuration += [
            'allow_redirects' => [
                'max'             => self::DEFAULT_REDIRECTS_ALLOWED,
                'protocols'       => [
                    'http',
                    'https',
                ],
                'strict'          => false,
                'referer'         => false,
                'track_redirects' => false,
            ],
            'http_errors'     => true,
            'decode_content'  => true,
            'verify'          => true,
            'cookies'         => false
        ];

        $this->client = new Client($configuration);
    }

    /**
     * @param string $url
     *
     * @return null|ResponseInterface
     */
    public function doGet(string $url): ?ResponseInterface
    {
        $response = null;

        try {
            $request = new Request(HttpMethods::GET, $url);
            $response = $this->client->send($request);
        } catch (GuzzleException $e) {
            // todo handle
        }

        return $response;
    }
}
