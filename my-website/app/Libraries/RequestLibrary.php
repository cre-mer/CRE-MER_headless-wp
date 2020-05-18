<?php namespace App\Libraries;

use GuzzleHttp\Client;
use DB;
use Cache;

class RequestLibrary
{
    public function __construct()
    {
        // $this->token = config('services.wp_api.client_secret');
        $this->token = '';
        $this->client = new Client();
        $this->params = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Accept' => 'application/json'
            ],
            'verify' => env('APP_ENV') == 'production' ? true : false // set to true to check for ssl
        ];
    }

    public function getData($url, $type = null)
    {
        $url = config('services.wp_api.url').'/wp-json/wp/v2/'.$type.'?slug='.$url;
        $cacheKey = md5($url);

        return Cache::remember($cacheKey, 86400, function () use ($url, $type) {
            try {
                $response = $this->client->request('GET', $url, $this->params);
                $body = $response->getBody()->getContents();

                $data = [
                   'body' => json_decode($body, true),
                   'headers' => $response->getHeaders()
                ];

                return $this->reformatContent($type, $data);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function reformatContent($type, $data)
    {
        if ($type == 'posts') {
            return (new BlogLibrary)->reformatBlogList($data);
        } elseif ($type == 'page') {
            return (new PageLibrary)->reformatPage($data);
        }

        return $data;
    }

    /**
     * Get wp post
     * @param  string $slug post slug
     * @return object|null
     */
    public function getPost($slug) {
        if ($this->getData($slug, 'posts')['data']) {
            return [
                'posts',
                $this->getData($slug, 'posts')['data']
            ];
        } elseif (! empty($this->getData($slug, 'pages')['body'])) {
            return [
                'pages',
                $this->getData($slug, 'pages')['body']
            ];
        }

        return null;
    }
}
