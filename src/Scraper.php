<?php

namespace SeoScraper;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use SeoScraper\Common\HTMLTags;
use SeoScraper\Common\HttpCodes;
use SeoScraper\Common\HttpHeaders;
use SeoScraper\Http\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class Scraper
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var Crawler
     */
    private $parser;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }

        $this->url = $url;
        $this->parser = new Crawler();
        $this->httpClient = new HttpClient();

        $this->response = $this->httpClient->doGet($this->url);
        $this->parser->addHtmlContent($this->response->getBody());

    }


    public function assertContainsTag(string $tag, string $tagContent)
    {
        if (!in_array($tag, HTMLTags::all())) {
            throw new InvalidArgumentException('Invalid / not supported HTML tag');
        }

        $this->parser->filter($tag)->text();
    }

    public function assertReturnsRedirection(string $redirectedTo = null)
    {
        $httpStatusMatch = in_array($this->response->getStatusCode(), HttpCodes::redirectionCodes());

        $header = $this->response->getHeader(HttpHeaders::LOCATION);

        if ($redirectedTo && $header && $header[0]) {
            $redirectionMatch = $redirectedTo === $header[0];

            return $httpStatusMatch && $redirectionMatch;
        }

        return $httpStatusMatch;
    }

    public function assertIsCanonicalPage()
    {
        // find the rel canonical,
        // compare with current url
    }
}
