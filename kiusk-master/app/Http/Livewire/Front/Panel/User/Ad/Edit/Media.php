<?php

namespace App\Http\Livewire\Front\Panel\User\Ad\Edit;

use App\Models\Ad\Ad;
use LaravelIdea\Helper\Spatie\MediaLibrary\MediaCollections\Models\_IH_Media_QB;

trait Media
{
    public $photos = [];
    public $previewPhotos = [];

    public function updatedPhotos($v)
    {
        $this->validate([
            'photos.*' => 'image|max:1024',
            'photos' => 'array|max:10',
        ], [], [
            'photos.*' => 'فایل'
        ]);
        //  dump($this->photos);
        foreach ($this->photos as $key => $photo) {
            if ($key === 0 && !$this->ad->getMedia('SpecialImage')
                ->count()) {
                $this->ad->addMedia($photo)
                    ->toMediaCollection('SpecialImage');
            }
            $this->ad->addMedia($photo)
                ->toMediaCollection('Gallery');
        }
        $this->getPhoto();
    }

    public function mediaDelete(\Spatie\MediaLibrary\MediaCollections\Models\Media $media)
    {
        if ($media->collection_name === 'SpecialImage') {
            $first = $this->ad->media()
                ->orderBy('id')
                ->whereCollectionName('Gallery')
                ->first();
            $first?->move($this->ad, 'SpecialImage');
        }
        $media->delete();
        $this->getPhoto();
    }

    public function getPhoto(): void
    {
        //  $s = \Spatie\MediaLibrary\MediaCollections\Models\Media::
        //  whereModelId($this->ad->id)
        //                                                         ->whereModelType('ad')
        //                                                         ->whereCollectionName('SpecialImage')
        //                                                         ->get();
        //  $g = \Spatie\MediaLibrary\MediaCollections\Models\Media::
        //  whereModelId($this->ad->id)
        //                                                         ->whereModelType('ad')
        //                                                         ->whereCollectionName('Gallery')
        //                                                         ->orderBy('id')
        //                                                         ->get();
        //  dump([
        //        ...$s,
        //        ...$g
        //       ]);
        //  $this->previewPhotos = [
        //   ...$s,
        //   ...$g
        //  ];
        $this->previewPhotos = $this->ad->load([
            'media' => function ($q) {
                $q->orderBy('id');
                //                                             ->whereCollectionName('SpecialImage');
            }
        ])->media;
    }
}
