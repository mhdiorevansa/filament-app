<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $guarded = [];

    /**
     * Get the customer that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the faktur that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faktur(): BelongsTo
    {
        return $this->belongsTo(Faktur::class, 'faktur_id', 'id');
    }
}
