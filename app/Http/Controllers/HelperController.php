<?php

namespace App\Http\Controllers;

class HelperController extends Controller
{
    use HelperTrait;

    public function productPrice($product, $useAction = false)
    {
        if ($useAction) {
            return $product->parts ? $product->part_price : $product->whole_price;
        }
        if ($product->parts) {
            return $product->action ? $product->action_part_price : $product->part_price;
        } else {
            return $product->action ? $product->action_whole_price : $product->whole_price;
        }
    }

    public function productCostSting($product)
    {
        return $this->productPrice($product).' руб <span> — '.$this->productMinVal($product).'</span>';
    }

    public function productCost($product, $value)
    {
        return ceil( $this->productPrice($product)*($product->parts ? $value/$this->productParts[0] : $value));
    }

    public function productUnit($product)
    {
        return $product->parts ? $this->getPartsName() : 'шт';
    }

    public function productMinVal($product)
    {
        return $product->parts ? $this->productParts[0].$this->getPartsName() : '1 шт/'.$product->whole_weight.' г';
    }

    public function getPartsName()
    {
        return ' г';
    }

    public function randHash()
    {
        return '?'.md5(rand(0,100));
    }
}
