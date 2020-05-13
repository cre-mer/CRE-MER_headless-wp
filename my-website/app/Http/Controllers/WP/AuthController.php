<?php

namespace App\Http\Controllers\WP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Get a token
    public function getToken()
    {
        $url = config('services.wp_api.url').'/oauth/authorize/?client_id='.config('services.wp_api.client_id').'&response_type=code';
        return redirect()->away($url);
    }

    // Process token
    public function processToken(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $url = config('services.wp_api.url').'/oauth/token';

        $data = [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'client_id' => config('services.wp_api.client_id'),
            'client_secret' => config('services.wp_api.client_secret')
        ];

        $params = [
            'form_params' => $data,
            'headers' => [
                'Accept' => 'application/json'
        ]
    ];

        try {
            $response = $client->request('POST', $url, $params);
            $decodedBody = json_decode($response->getBody()->getContents(), true);

            $accessToken = $decodedBody['access_token'];

            if ($accessToken) {
                DB::table('WpAuth')->truncate();
                DB::table('WpAuth')->insert([
                'access_token' => $accessToken,
                'updated_at' => Carbon::now()
            ]);
            }

            return redirect('dashboard')->with('message', 'Access token has been updated');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errors = $e->getResponse()->getBody();
            return response($errors, $e->getCode());
        }
    }
}
