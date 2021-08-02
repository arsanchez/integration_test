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
	}

    public function getSubscribers($limit, $offsset, $search)
    {
        $subscribers_api = $this->mailerlite_client->subscribers();

        $filters = [];
        if ($search) {
            $data = $subscribers_api->search($search);
        } else {
            $data = $subscribers_api->limit($limit)->offset($offsset)->get();
        }

        $subscribers = [];
        foreach ($data as $s) {
            $subscribe_date = '';
            $subscribe_time = '';
            $country_key = array_search('country', array_column($s->fields, 'key'));
            $country = $s->fields[$country_key]->value;

            if ($s->date_created) {
                $subscribe_date = date("d/m/Y", strtotime($s->date_created));
                $subscribe_time = date("H:i:s", strtotime($s->date_created));
            }

            $subscribers[] = ['email' => $s->email, 'name' => $s->name, 'country' => $country, 'subscribe_date' => $subscribe_date,
            'subscribe_time' => $subscribe_time, 'id' => strval($s->id)];
        }

        return $subscribers;
    }

    public function deleteSubscriber($id) {
        $subscribers_api = $this->mailerlite_client->subscribers();

        return $subscribers_api->delete($id);
    }

    public function findSubscriber($id) {
        $subscribers_api = $this->mailerlite_client->subscribers();
        $subscriber =  $subscribers_api->find($id);
        $key = array_search('country', array_column($subscriber->fields, 'key'));
        $subscriber->country = $subscriber->fields[$key]->value;
        return $subscriber;
    }

    public function addSubscriber($subscriber) {
        $subscribers_api = $this->mailerlite_client->subscribers();
        return $subscribers_api->create($subscriber);
    }

    public function getAPIStats()
    {
        return $this->mailerlite_client->stats()->get();
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
