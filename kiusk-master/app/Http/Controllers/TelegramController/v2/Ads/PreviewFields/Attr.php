<?php

namespace App\Http\Controllers\TelegramController\v2\Ads\PreviewFields;

use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Attr
{
    public function adsPreviewAttributeRequest(Api $t, Update $u, Message|Collection|EditedMessage $m, $attributeId): void
    {
        /**
         * @var \App\Models\Ad\Attribute $attributes
         * */
        $attribute = $this->getAttr($attributeId);
        $this->request($t, $u, $m, 'لطفا ' . $attribute->name . ' را ارسال کنید', 'adsPreviewAttribute', $attributeId);
    }

    public function adsPreviewAttributeStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $attributeId): void
    {
        /**
         * @var \App\Models\Ad\Attribute $attribute
         * */
        $attribute = $this->getAttr($attributeId);
        $this->store($t, $u, $m, 'adsPreviewAttribute', 'data', function ($t, $u, $m, $data) use ($attribute) {
            return \Validator::make([$data => $m->text], [
                $data => $attribute->validation,
            ],                      [], [$data => $attribute->name]);
        }, function ($t, $u, $m) use ($attributeId) {
            $this->updateUserExtra(function ($x) use ($m, $attributeId) {
                collect($x->adsCreate->attributes)->map(function ($item) use ($m, $attributeId) {
                    if ($item->id === $attributeId) {
                        $item->value = $m->text;
                    }
                });
                return $x;
            });
            $this->adsPreview($t, $u);
        },
        $attributeId);
    }

    public function adsPreviewAttributeOptionRequest(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        $attributeId
    ): void {
        /**
         * @var \App\Models\Ad\Attribute $attributes
         * */
        $attribute = $this->getAttr($attributeId);
        $this->requestOption(
            $t,
            $u,
            $m,
            'لطفا ' . $attribute->name . ' را ارسال کنید',
            'adsCreateAttributeOption',
            $attributeId
        );
    }

    public function adsPreviewAttributeOptionStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $optionId): void
    {
        $attributeId = auth()->user()->extra->attributeIdTypeSelect;
        /**
         * @var \App\Models\Ad\Attribute $attribute
         * */
        $attribute = $this->getAttr($attributeId);
        $this->storeOption(
            $t,
            $u,
            $m,
            'adsPreviewAttributeOption',
            'data',
            function ($t, $u, $m, $data) use ($attribute, $optionId) {
                return \Validator::make([], [], [], []);
            },
            function ($t, $u, $m) use ($attributeId, $optionId, $attribute) {
                $this->updateUserExtra(function ($x) use ($m, $attributeId, $optionId, $attribute) {
                    collect($x->adsCreate->attributes)->map(function ($item) use ($m, $attributeId, $optionId, $attribute) {
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
