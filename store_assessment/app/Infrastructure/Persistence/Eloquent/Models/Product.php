<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'price'];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
