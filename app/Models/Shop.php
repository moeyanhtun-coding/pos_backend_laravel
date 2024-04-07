<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['shop_code', 'shop_name', 'shop_no', 'mobile_no', 'address'];

    public static function generateShopCode()
    {
        // Generate a random string for the shop code
        $code = str::random(8);

        // Check if the generated code already exists in the database
        while (self::where('code', $code)->exists()) {
            $code = Str::random(8);
        }

        return $code;
    }
}