<?php

namespace App\Http\Controllers;

class HelperController extends Controller
{
    use HelperTrait;

    public function orderItemCost($item)
    {
        return $item->whole_value ? $item->whole_value*($item->product->action ? $item->product->action_whole_price : $item->product->whole_price) : ceil($item->part_value/$this->productParts[0]*($item->product->action ? $item->product->action_part_price : $item->product->part_price));
    }

    public function productPrice($product,$useAction=false)
    {
        if ($useAction) return $product->parts ? $product->part_price : $product->whole_price;
        else return $product->parts ? ($product->action ? $product->action_part_price : $product->part_price) : ($product->action ? $product->action_whole_price : $product->whole_price);
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

    public function productValue($value) {
//        return str_replace('.',',',(string)$value);
        return $value;
    }

    public function productMinVal($product)
    {
        return $product->parts ? $this->productValue($this->productParts[0]).$this->getPartsName() : '1 шт/'.$product->whole_weight.' г';
    }

    public function getProductParts()
    {
        return $this->productParts;
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
