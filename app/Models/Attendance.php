<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attendance extends Model
{
    protected $guarded = [];

    /**
     * Get the user that owns the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setPhotoAttribute($value)
    {
        if (str_starts_with($value, 'data:image')) {
            $image = str_replace('data:image/jpeg;base64,', '', $value);
            $image = str_replace(' ', '+', $image);
            $filePath = 'attendance_photos/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filePath, base64_decode($image));
            $this->attributes['photo'] = $filePath;
        } else {
            $this->attributes['photo'] = $value;
        }
    }
}
