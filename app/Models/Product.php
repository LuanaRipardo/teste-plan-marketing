<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'category', 'image_url'];

 
    public static function searchByCategory($category)
    {
        return self::where('category', 'like', "%$category%")->get();
    }

    public static function searchByImage($hasImage)
    {
        if ($hasImage) {
            return self::where('image_url', '!=', '')->get();
        } else {
            return self::where('image_url', '')->get();
        }
    }    

    public static function searchById($id)
    {
        return self::find($id);
    }



}
