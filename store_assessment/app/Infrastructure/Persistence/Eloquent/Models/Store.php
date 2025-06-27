<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasFactory;

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

    public static function newFactory()
    {
        return \Database\Factories\StoreFactory::new();
    }
}
