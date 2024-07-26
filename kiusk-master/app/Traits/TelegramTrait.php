<?php

namespace App\Traits;

use Telegram\Bot\Api;

trait TelegramTrait
{
    protected $telegram;
    protected $update;
    protected $message;

    public function __construct() {

    }

    /**
     * Send Message to user
     *
     * @param int $chatId
     * @param string $message
     * @return void
     */
    public function sendMessage($chatId, $message)
    {
        $t = new Api(st()->botApiToken);
        $u = $t->getWebhookUpdate();
        $m = $u->getMessage();
        $t->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);
    }
}
