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
        $alphabets = Str::random(3, 'abcdefghijklmnopqrstuvwxyz');

        $numbers = Str::random(3, '0123456789');
        $shop_code = $alphabets . $numbers;

        // Check if the generated shop_code already exists in the database
        while (self::where('shop_code', $shop_code)->exists()) {
            $alphabets = Str::random(3, 'abcdefghijklmnopqrstuvwxyz');
            $numbers = Str::random(3, '0123456789');
            $shop_code = $alphabets . $numbers;
        }

        return $shop_code;
    }
}