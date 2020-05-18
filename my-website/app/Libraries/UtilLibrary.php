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
        $url = config('services.wp_api.short_url');
        $search = [
            'https://' . $url,
            'http://' . $url
        ];
        return str_replace($search, '', $content);
    }
}
