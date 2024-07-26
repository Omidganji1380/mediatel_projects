<?php

namespace App\Http\Controllers\TelegramController;

use App\Http\Controllers\TelegramController\Ads\AcceptTheRules;
use App\Http\Controllers\TelegramController\Ads\Create;
use App\Http\Controllers\TelegramController\Ads\Edit;
use App\Http\Controllers\TelegramController\Ads\Index;

trait Ads
{
    use Index;
    use Create;
    use Edit;
    use AcceptTheRules;
}
