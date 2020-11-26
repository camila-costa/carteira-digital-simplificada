<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ExternalRequest
{
    public function makeExternalRequest($url, $indexMessage, $expectMessage)
    {
        $response = Http::get($url);
        if(isset($response[$indexMessage]) && $response[$indexMessage] == $expectMessage) {
            return true;
        }

        return false;
    }
}
