<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;
use App\Util\MailerLiteConnector;

class HomeController extends Controller
{
    public function index()
    {
        $system = System::first();
        $valid_key = false;
        if ($system) {
            $valid_key = true;
        }
        // $types = json_encode(Type::select('id','title')->get()->toArray());
        return view('home', ['valid_key' => $valid_key]);
    }

    public function addKey(Request $request) {
        // Checking if the key is valid
        $this->validate($request, [
            'api_key' => ['required', function ($attribute, $value, $fail) {
                if (!MailerLiteConnector::isValidKey($value)) {
                    $fail('The API key is invalid.');
                }
            }],
        ]);

        // Checking if the key is valid
        return System::Create(['key' => $request->api_key]);

    }
}
