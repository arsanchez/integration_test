<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\MailerLiteConnector;

class MailerLiteController extends Controller
{
    protected $connector;

    public function __construct(MailerLiteConnector $connector)
    {
        $this->connector = $connector;
    }
}
