<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSkuAndBarcode
{
    protected static function bootHasSkuAndBarcode()
    {
        static::creating(function ($product) {

            // Auto SKU
            if (!$product->sku) {
                $product->sku = static::generateSku($product->name);
            }

            // Auto Barcode
            if (!$product->barcode) {
                $product->barcode = static::generateBarcode();
            }
        });
    }

    //Generate SKU (safe unique)
    public static function generateSku($name)
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));

        do {
            $number = random_int(1, 9999);
            $sku = $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        } while (static::where('sku', $sku)->exists());

        return $sku;
    }

    //Generate Barcode (12-digit unique)
    public static function generateBarcode()
    {
        do {
            $barcode = (string) random_int(100000000000, 999999999999);
        } while (static::where('barcode', $barcode)->exists());

        return $barcode;
    }
}