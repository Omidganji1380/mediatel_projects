<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad\Ad;

class CkeditorController extends Controller
{
 public function upload()
 {
  $str = request()->model_type;
   $model = (new $str())->find(request()->model_id);
     if(!$model)
        $model = (new $str())->find(1);
  /**
   * @var Ad $model
   * */
  $url = $model->addMediaFromRequest('upload')
               ->toMediaCollection('content')
               ->getUrl();
  return response()->json([
                           'url' => $url,
                          ]);
 }
}
