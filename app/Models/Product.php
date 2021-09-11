<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function storeFile($productFile, $productId = null)
    {
        $imageName = $productFile->getClientOriginalName();
        $imageExt = $productFile->getClientOriginalExtension();

        if (!in_array(strtolower($imageExt), ["jpg", "jpeg", "png"]))
            throw new \Exception("File must be an image");

        if (!empty($productId)) {
            $product = self::find($productId);
            if (isset($product->image_url))
                Storage::delete(ltrim($product->image_url));
        }

        return $productFile->storeAs('products', $imageName);
    }
}
