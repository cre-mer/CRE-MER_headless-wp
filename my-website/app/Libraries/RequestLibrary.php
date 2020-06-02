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
            'verify' => config('services.app.env') == 'production' ? true : false // set to true to check for ssl
        ];

        // set api auth variables
        $client_id = config('services.wp_api.client_id');
        $client_secret = config('services.wp_api.client_secret');
        $this->client_auth = '?client_id='.$client_id.'&client_secret='.$client_secret;
    }

    /**
     * Generate unique cache key with md5 for
     * wp api data based on the request's url
     * @param  string $url url to cache
     * @return string      unique encrypted key
     */
    public function generateCacheKey($url) {
        return md5($url);
    }

    public function getData($url, $type = null)
    {
        $url = config('services.wp_api.url').'/wp-json/wp/v2/'.$type.$this->client_auth.'&slug='.$url;
        $cacheKey = $this->generateCacheKey($url);

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
            return (new PostLibrary)->reformatBlogList($data);
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
        $url = config('services.wp_api.url').'/wp-json/wp/v2/posts'.$this->client_auth.'&slug='.$type;
        $cacheKey = $this->generateCacheKey($url);

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
            $url = config('services.wp_api.url').'/wp-json/wp/v2/users/'.$id.$this->client_auth;
        }
        $cacheKey = $this->generateCacheKey($url);

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
