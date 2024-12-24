<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailFaktur extends Model
{
    protected $table = 'detail';
    protected $guarded = [];

    /**
     * Get the barang that owns the DetailFaktur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    /**
     * Get the faktur that owns the DetailFaktur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faktur(): BelongsTo
    {
        return $this->belongsTo(Faktur::class, 'faktur_id', 'id');
    }
}
