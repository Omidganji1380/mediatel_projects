<?php

namespace App\Http\Controllers\TelegramController\Ads\EditFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Attr
{
    public function adsEditAttributeRequest(Api $t, Update $u, Message|Collection|EditedMessage $m, $attributeId): void
    {
        /**
         * @var \App\Models\Ad\Attribute $attributes
         * */
        $attribute = $this->getAttr($attributeId, 'adsEdit');
        // dump($attribute,$attributeId);
        $this->requestEdit($t, $u, $m, 'لطفا ' . $attribute->name . ' را ارسال کنید', 'adsEditAttribute', $attributeId);
    }

    public function adsEditAttributeStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $attributeId): void
    {
        /**
         * @var \App\Models\Ad\Attribute $attribute
         * */
        $attribute = $this->getAttr($attributeId, 'adsEdit');
        $this->store($t, $u, $m, 'adsEditAttribute', 'data', function ($t, $u, $m, $data) use ($attribute) {
            return \Validator::make([$data => $m->text], [
             $data => $attribute->validation,
            ],                      [], [$data => $attribute->name]);
        }, function ($t, $u, $m) use ($attributeId) {
            $this->updateUserExtra(function ($x) use ($m, $attributeId) {
                collect($x->adsEdit->attributes)->map(function ($item) use ($m, $attributeId) {
                    if ($item->id === $attributeId) {
                        $item->value = $m->text;
                    }
                });

                return $x;
            });
            $this->adsEdit($t, $u);
        },           $attributeId);
    }

    public function adsEditAttributeOptionRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        $attributeId
    ): void
    {
        /**
         * @var \App\Models\Ad\Attribute $attributes
         * */
        $attribute = $this->getAttr($attributeId, 'adsEdit');
        $this->requestEditOption(
            $t,
            $u,
            $m,
            'لطفا ' . $attribute->name . ' را ارسال کنید',
            'adsEditAttributeOption',
            $attributeId
        );
    }

    public function adsEditAttributeOptionStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $optionId): void
    {
        $attributeId = auth()->user()->extra->attributeIdTypeSelect;
        /**
         * @var \App\Models\Ad\Attribute $attribute
         * */
        $attribute = $this->getAttr($attributeId, 'adsEdit');
        $this->storeEditOption(
            $t,
            $u,
            $m,
            'adsEditAttributeOption',
            'data',
            function ($t, $u, $m, $data) use ($attribute, $optionId) {
                return \Validator::make([], [], [], []);
            },
            function ($t, $u, $m) use ($attributeId, $optionId, $attribute) {
                $this->updateUserExtra(function ($x) use ($m, $attributeId, $optionId, $attribute) {
                    collect($x->adsEdit->attributes)->map(function ($item) use ($m, $attributeId, $optionId, $attribute) {
                        if ($item->id === $attributeId) {
                            $item->value = $attribute->options[$optionId]->name;
                        }
                    });

                    return $x;
                });
            // dump('stored');
            },
            $attributeId
        );
    }
}
