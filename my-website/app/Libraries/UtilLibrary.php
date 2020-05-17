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
        $search = [
            'https://' . config('services.wp_api.url'),
            'http://' . config('services.wp_api.url')
        ];
        return str_replace($search, '', $content);
    }
}
