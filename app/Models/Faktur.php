<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur extends Model
{
    use SoftDeletes;

    protected $table = "faktur";
    protected $guarded = [];

    /**
     * Get the customer that owns the Faktur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get all of the detail for the Faktur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail(): HasMany
    {
        return $this->hasMany(DetailFaktur::class, 'faktur_id', 'id');
    }

    /**
     * Get all of the penjualan for the Faktur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'faktur_id', 'id');
    }
}
