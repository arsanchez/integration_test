<?php
namespace App\Util;

use GuzzleHttp\Client;
use MailerLiteApi\MailerLite;
use App\Models\System;
use Illuminate\Support\Facades\Http;

class MailerLiteConnector 
{
    protected $mailerlite_client;

	public function __construct()
	{
        $system = System::firstOrFail();

        $this->mailerlite_client = new \MailerLiteApi\MailerLite($system->key);
        $this->mailerlite_client->subscribers()->get();
	}

    public static function isValidKey($api_key) 
    {
        // Testing the API with a simple call
        $client = new Client(['base_uri' => 'https://api.mailerlite.com/api/v2/']);

        try {
            $response = $client->request('GET', '', [
                'headers'        => ['X-MailerLite-ApiKey'  => $api_key, 'Content-Type' => 'application/json']
            ]);
            $valid = true;
        } catch (\Exception $e) {
            $valid = false;
        }
        
        return $valid;
    }
}