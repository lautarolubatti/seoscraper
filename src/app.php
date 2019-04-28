<?php

namespace SeoScraper;

use League\Container\Container;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container;

$runner = $container->get(Scraper::class);
