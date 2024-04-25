<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'productCode',
        'productName',
        'price',
        'ProductCategoryId'
    ];

    public function Products () : HasMany {
        return $this->HasMany(Product::class);
    }

    public function ProductCategory () :BelongsTo {
        return $this->BelognsTo(ProductCategory::class,'foreign_key');
    }
}
