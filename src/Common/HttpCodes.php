<?php

namespace SeoScraper\Common;

/**
 * List of HTTP status codes
 */
class HttpCodes extends Enum
{
    const OK = 200;

    const MOVED_PERMANENTLY = 301;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;

    const INTERNAL_ERROR = 500;

    public static function redirectionCodes()
    {
        return [
            HttpCodes::MOVED_PERMANENTLY,
        ];
    }
}