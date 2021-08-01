<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $system = System::first();
        $accounts = [];
        if ($system) {
            dd($system->key);
            $accounts = [];
        }
        // $types = json_encode(Type::select('id','title')->get()->toArray());
        return view('home', ['accounts' => $accounts]);
    }

    public function addKey(Request $request) {
        $this->validate($request, [
            'api_key' => ['required'],
        ]);

        return System::Create(['key' => $request->api_key]);
    }
}
