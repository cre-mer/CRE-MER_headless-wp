<?php namespace App\Libraries;

use Jenssegers\Date\Date;
use stdClass;

class UtilLibrary
{
    /**
    * Rewrite links from api.domain.com to domain.com
    * @param  string $content
    * @return string
    */
    public function reformatContent($content)
    {
        return str_replace(config('services.wp_api.url'), '', $content);
    }
}
