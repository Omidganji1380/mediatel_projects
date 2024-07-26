<?php

namespace App\Settings;

use Spatie\LaravelSettings\SettingsCasts\SettingsCast;

class JsonArray implements SettingsCast
{
    public function get($payload)
    {
        //  dump($payload, json_decode($payload), 4444);
        //  return $payload;
        return json_decode($payload, true);
    }

    public function set($payload)
    {
        //  return $payload;
        return json_encode($payload);
    }
}
