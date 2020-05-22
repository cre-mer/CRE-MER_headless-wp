<?php namespace App\Libraries;

use GuzzleHttp\Client;
use DB;
use Cache;

class RequestLibrary
{
    public function __construct()
    {
        $this->token = config('services.wp_api.client_secret') ?? '';
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
        } elseif ($type == 'pages') {
            return (new PageLibrary)->reformatPage($data);
        } elseif ($type == 'post_archive') {
            return (new PostArchiveLibrary)->reformatContent($data);
        }
         elseif ($type == 'author') {
            return (new AuthorLibrary)->reformatContent($data);
        }

        return $data;
    }

    /**
     * Get wp post
     * @param  string $slug post slug
     * @return object|null
     */
    public function getPost($slug)
    {
        if ($this->getData($slug, 'posts')['data']) {
            return [
                'posts',
                $this->getData($slug, 'posts')['data']
            ];
        } elseif (! empty($this->getData($slug, 'pages')['data'])) {
            return [
                'pages',
                $this->getData($slug, 'pages')['data']
            ];
        }

        return null;
    }

    /**
     * Get wp posts
     * @param string $type post type
     * @return object|null
     */
    public function getPosts($type)
    {
        $url = config('services.wp_api.url').'/wp-json/wp/v2/posts?slug='.$type;
        $cacheKey = md5($url);

        return Cache::remember($cacheKey, 86400, function () use ($url, $type) {
            try {
                $response = $this->client->request('GET', $url, $this->params);
                $body = $response->getBody()->getContents();

                $data = [
                   'body' => json_decode($body, true),
                   'headers' => $response->getHeaders()
                ];

                return $this->reformatContent($type = 'post_archive', $data);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function getAuthor(string $url, $id = null)
    {
        if (!$url) {
            $url = config('services.wp_api.url').'/wp-json/wp/v2/users/'.$id;
        }
        $cacheKey = md5($url);

        return Cache::remember($cacheKey, 86400, function () use ($url) {
            try {
                $response = $this->client->request('GET', $url, $this->params);
                $body = $response->getBody()->getContents();

                $data = json_decode($body, true);

                return $data;
                // return $this->reformatContent('author', $data);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
