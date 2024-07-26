<?php

namespace App\Http\Livewire\Front\Panel\User\Ad\Edit;
trait StateCity
{
 public function updatedAdStateid($v)
 {
  $this->ad->city_id = null;
 }
}