<?php

namespace App\Models;

use App\Observers\CustomerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([CustomerObserver::class])]
class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];
}
