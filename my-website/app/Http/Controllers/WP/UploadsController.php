<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    /**
    * Show WP Image
    * @param  array $rawBlogs
    * @return array
    */
    public function showWpImage($year, $month, $filename)
    {
        $slug = '/wp-content/uploads/'.$year.'/'.$month.'/'.$filename;
        $imageUrl = config('services.wp_api.url').$slug;

        $args = $this->setFileGetContentsArgs();
        $file = file_get_contents($imageUrl, false, stream_context_create($args));
        $mimeType = $this->getMimeType($file); // this method is beyond the scope of this post

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'public')
            ->header('expires', \Carbon\Carbon::now()->addDays(10));
    }

    /**
     * Get mime type
     * @method getMimeType
     * @param  string      $file
     * @return string
     */
    public function getMimeType(string $file)
    {
        $finfo = new \finfo(FILEINFO_MIME);
        return $finfo->buffer($file) . PHP_EOL;
    }

    /**
     * Set args depending on wether to get images from valid ssl or not
     * @method setFileGetContentsArgs
     */
    public function setFileGetContentsArgs()
    {
        return env('APP_ENV') == 'production' ? null :
            [
                "ssl"=> [
                    "verify_peer"      => false,
                    "verify_peer_name" => false
            ],
                "http"=> [
                    'timeout'    => 60,
                    'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/3.0.0.1'
            ]
        ];
    }
}
