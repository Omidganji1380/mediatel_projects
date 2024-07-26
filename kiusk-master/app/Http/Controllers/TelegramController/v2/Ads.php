<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Http\Controllers\TelegramController\v2\Ads\AcceptTheRules;
use App\Http\Controllers\TelegramController\v2\Ads\Create;
use App\Http\Controllers\TelegramController\v2\Ads\Edit;
use App\Http\Controllers\TelegramController\v2\Ads\Index;
use App\Http\Controllers\TelegramController\v2\Ads\Preview;

trait Ads
{
    use Index;
    use Create;
    use Preview;
    use Edit;
    use AcceptTheRules;
}
