<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $fillable = [
        'event_id',
        'photo_path',
        'description',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}