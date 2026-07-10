<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'quota',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function approvedRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'approved');
    }

    public function galleryPhotos()
    {
        return $this->hasMany(GalleryPhoto::class);
    }

    public function getRemainingQuotaAttribute(): int
    {
        return $this->quota - $this->approvedRegistrations()->count();
    }
}
