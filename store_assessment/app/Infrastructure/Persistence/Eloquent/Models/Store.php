<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden=['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'store_product')
                    ->withPivot('quantity');
    }
}
