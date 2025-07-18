<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];
    protected $hidden = ['id'];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class,'store_product')
                    ->withPivot('quantity');
    }

    public static function newFactory()
    {
        return \Database\Factories\ProductFactory::new();
    }
}
