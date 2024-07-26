<?php

namespace App\Settings;

use Spatie\LaravelSettings\SettingsCasts\SettingsCast;

class JsonArraySeo implements SettingsCast
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
        foreach ($payload as $key => $value) {
            if ($value == 'false') {
                $payload[$key] = false;
            }
        }
        //  dump($payload);
        return json_encode($payload);
    }
}
