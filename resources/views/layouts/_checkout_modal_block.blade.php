<?php ob_start(); ?>
<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/profile/checkout-order') }}" method="post">
    {{ csrf_field() }}
    <div class="modal-body">
        <div id="order-content">
            @if (Session::has('basket'))
                @foreach (Session::get('basket') as $id => $item)
                    @foreach ($data['products'] as $product)
                        @if ($id != 'total' && isset($item['value']) && $item['value'] && $id == $product->id)
                            <div id="basket-product-{{ $product->id }}" class="product-basket">
                                @include('_basket_product_block', [
                                    'product' => $product,
                                    'value' => $item['value'],
                                    'price' => $item['price'],
                                    'productParts' => $data['product_parts']
                                ])
                            </div>
                            @break
                        @endif
                    @endforeach
                @endforeach
            @endif
        </div>
        <hr>
        <p id="total-cost"><b>На сумму: </b>{{ Session::has('basket') ? Session::get('basket')['total'] : '0' }}р.</p>

        <h3>Доставка</h3>
        <?php $displayAddress = Session::has('basket') && Session::get('basket')['total'] > 10000; ?>
        <div class="error"></div>

        @foreach(['Доставка в офис ('.Auth::user()->office->address.')','Доставка в магазин','Доставка по адресу <span class="error">(при заказе свыше 10 000р.!)</span>'] as $k => $delivery)
            @include('_radio_simple_block',[
                'name' => 'delivery',
                'value' => $k+1,
                'label' => $delivery,
                'checked' => (!$displayAddress && !$k) || ($displayAddress && $k == 2)
            ])
        @endforeach

        <div class="shops-block" style="display:none;">
            @foreach($data['shops'] as $k => $shop)
                @include('_radio_simple_block',[
                    'name' => 'shop_id',
                    'value' => $shop->id,
                    'label' => $shop->address,
                    'checked' => !$k
                ])
            @endforeach
        </div>

        <div class="address-block" {{ !$displayAddress ? 'style=display:none' : '' }}>
            @include('_input_block', [
                'label' => 'Адрес доставки:',
                'name' => 'address',
                'type' => 'text',
                'placeholder' => 'Напишите ваш адрес',
                'value' => !Auth::guest() && Auth::user()->address ? Auth::user()->address : ''
            ])
        </div>
    </div>
    <div class="modal-footer">
        @include('_button_block', ['addAttr' => $usingAjax ? ['id' => 'checkout'] : null, 'type' => $usingAjax ? 'button' : 'submit', 'text' => 'Оформить заказ', 'icon' => 'icon-mail5'])
    </div>
</form>

<?php $content = ob_get_clean(); ?>
@include('layouts._modal_block',['id' => 'checkout-modal', 'title' => 'Оформление заказа', 'content' => $content, 'addClass' => isset($addClass) ? $addClass : null])