<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    public static function store($file)
    {
        $filename = $file->hashName();

        \Image::make($file->getRealPath())
            ->fit(1200, 800, function ($constraint) {
                $constraint->upsize();
            })
            ->save(Storage::disk('public')->path('') . $filename)
            ->fit(200, 200, function ($constraint) {
                $constraint->upsize();
            })->save(Storage::disk('public')->path('thumbs/') . $filename);

        Image::create([
            'filename' => $filename,
        ]);
    }
}
