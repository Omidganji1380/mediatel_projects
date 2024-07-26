<?php

namespace App\Http\Livewire\Front\Ad\Create\Main;

trait StateCity
{
    /**
     * updated Ad State Id
     *
     * @param [type] $v
     * @return void
     */
    public function updatedAdStateid($v)
    {
        $this->ad->city_id = null;
    }
}
