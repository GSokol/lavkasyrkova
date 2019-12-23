<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\ProductToOrder;
use Session;
use Settings;
use Helper;

class BasketController extends Controller
{
    use HelperTrait;
    
    public function editBasket(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:products,id',
            'value' => 'required|integer'
        ]);
        $product = Product::find($request->input('id'));

        $basket = Session::has('basket') ? Session::get('basket') : [];
        $value = $request->input('value');
        $price = Helper::productPrice($product);
        $cost = Helper::productCost($product,$value);

        if ($value) {
            $basket[$request->input('id')] = [
                'value' => $value,
                'price' => $price,
                'parts' => $product->parts,
                'cost' => $cost
            ];
        } else {
            unset($basket[$request->input('id')]);
        }

        $totalCost = 0;
        foreach ($basket as $key => $item) {
            if ($key != 'total') $totalCost += $item['cost'];
        }

        if (!$totalCost) Session::forget('basket');
        else {
            $basket['total'] = $totalCost;
            Session::put('basket',$basket);
        }

        return response()->json([
            'success' => true,
            'product' => $value ? view('_basket_product_block', [
                'product' => $product,
                'value' => $value,
                'price' => $price,
                'productParts' => $this->productParts
            ])->render() : false, 
            'total' => $totalCost,
            'cost' => $cost
        ]);
    }
    
    public function emptyBasket()
    {
        Session::forget('basket');
        return response()->json(['success' => true]);
    }
    
    public function checkoutOrder(Request $request, $usingAjax = true)
    {
        $validationArr = [
            'delivery' => 'required|integer|min:1|max:3',
            'shop_id' => $this->validationShop
        ];

        if ($request->has('tasting_id') && $request->input('tasting_id')) $validationArr['tasting_id'] = $this->validationTasting;
        $this->validate($request, $validationArr);

        $errors = [];
        if (Auth::guest()) $errors[] = 'Вам необходимо авторизоваться!';
        if (!Session::has('basket')) $errors[] = 'Ваша корзина пуста!';
        elseif ($request->input('delivery') == 3) {
            if (Session::get('basket')['total'] < (int)Settings::getSettings()->delivery_limit) $errors[] = 'Доставка по адресу возможна только при заказе от '.((string)Settings::getSettings()->delivery_limit).'р.!';
            elseif (!Auth::user()->address && !$request->input('address')) $errors[] = 'Вы должны указать адрес!';
            elseif (!Auth::user()->address && $request->input('address')) User::where('id',Auth::user()->id)->update(['address' => $request->input('address')]);
        }

        if (count($errors)) {
            $result = ['success' => false, 'errors' => $errors];
            if ($usingAjax) return response()->json($result);
            else return $result;
        }

        $order = Order::create([
            'status' => 1,
            'user_id' => Auth::user()->id,
            'shop_id' => $request->input('delivery') == 2 ? $request->input('shop_id') : null,
            'tasting_id' => $request->has('tasting_id') && $request->input('tasting_id') ? $request->input('tasting_id') : null,
            'delivery' => $request->input('delivery') == 3
        ]);

        foreach (Session::get('basket') as $id => $item) {
            if ($id != 'total') {
                ProductToOrder::create([
                    'whole_value' => $item['parts'] ? null : $item['value'],
                    'part_value' => $item['parts'] ? $item['value'] : null,
                    'product_id' => $id,
                    'order_id' => $order->id,
                ]);
            }
        }
        Session::forget('basket');

        $this->sendMessage($order->user->email, 'auth.emails.new_order', ['title' => 'Новый заказ', 'order' => $order], (string)Settings::getSettings()->email);
//        $this->sendMessage('romis.nesmelov@gmail.com', 'auth.emails.new_order', ['title' => 'Новый заказ', 'order' => $order]);

        $result = ['success' => true, 'message' => 'Ваш заказ оформлен!'];
        if ($usingAjax) return response()->json($result);
        else return $result;
    }
}
