<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'price'];
    protected $hidden = ['id'];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class,'store_product')
                    ->withPivot('quantity');
    }
}
