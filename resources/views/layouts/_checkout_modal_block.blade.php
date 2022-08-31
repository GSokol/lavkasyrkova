<?php ob_start(); ?>
<div class="modal-body">
    <div id="order-content">
        @if (Session::has('basket'))
            @foreach (Session::get('basket') as $id => $item)
                @foreach ($data['products'] as $product)
                    @if (!in_array($id, ['total', 'delivery']) && isset($item['value']) && $item['value'] && $id == $product->id)
                        <div id="basket-product-{{ $product->id }}" class="product-basket">
                            @include('_basket_product_block', [
                                'product' => $product,
                                'value' => $item['value'],
                                'price' => $item['price'],
                                'productParts' => Helper::getProductParts()
                            ])
                        </div>
                        @break
                    @endif
                @endforeach
            @endforeach
        @endif
    </div>
    <hr>
    <p class="mb-15">
        <strong>Доставка: </strong>
        <span>{{ Session::has('basket') ? Session::get('basket')['delivery'] : 0 }} руб.</span>
    </p>
    <p class="total-cost-basket">
        <b>Итоговая сумма: </b>
        <span>{{ Session::has('basket') ? Session::get('basket')['total'] : '0' }} руб</span>
    </p>

    <?php $displayAddress = Session::has('basket') && Session::get('basket')['total'] > (int)Settings::getSettings()->delivery_limit || !count($tastings); ?>
    <div class="error"></div>

    @foreach(
        [
            ((Auth::user()->office && (Auth::user()->office->id == 1 || Auth::user()->office->id == 2)) || count($tastings) ? Auth::user()->office->address : (count($tastings) ? 'Доставка в офис ('.Auth::user()->office->address.')' : null)),
            'Доставка в магазин',
            'Доставка по адресу <span class="error">(при заказе свыше '.Settings::getSettings()->delivery_limit.' руб!)</span>'
        ] as $d => $delivery)

        @if ($delivery)
            @include('_radio_simple_block',[
                'name' => 'delivery',
                'value' => $d+1,
                'label' => $delivery,
                'checked' => (!$displayAddress && !$d) || ($displayAddress && $d == 2)
            ])
        @endif

        @if (!$d && count($tastings))
            <div class="times-block">
                <h6>Дата доставки</h6>
                @foreach($tastings as $k => $tasting)
                    @include('_radio_simple_block',[
                        'name' => 'tasting_id',
                        'value' => $tasting->id,
                        'label' => date('d.m.Y',$tasting->time),
                        'checked' => !$k
                    ])
                @endforeach
            </div>
        @elseif ($d == 1)
            <div class="shops-block" style="display:none;">
                @foreach($stores as $k => $store)
                    @include('_radio_simple_block', [
                        'name' => 'shop_id',
                        'value' => $store->id,
                        'label' => $store->address,
                        'checked' => !$k,
                    ])
                @endforeach
            </div>
        @endif
    @endforeach

    <div class="address-block" {{ !$displayAddress ? 'style=display:none' : '' }}>
        @include('_input_block', [
            'label' => 'Адрес доставки:',
            'name' => 'address',
            'type' => 'text',
            'placeholder' => 'Напишите ваш адрес',
            'value' => !Auth::guest() && Auth::user()->address ? Auth::user()->address : ''
        ])
    </div>

    <div class="description-block">
        @include('_textarea_block', [
            'label' => 'Примечание:',
            'name' => 'description',
            'placeholder' => 'Укажите примечание к заказу',
            'rows' => 3,
            'value' => '',
        ])
    </div>

    <div class="">
        <label>Способ оплаты:</label>
        @include('_radio_simple_block',[
            'name' => 'payment_type',
            'value' => 'card',
            'label' => 'Оплата картой',
            'checked' => true,
        ])
        @include('_radio_simple_block',[
            'name' => 'payment_type',
            'value' => 'cash',
            'label' => 'Оплата наличными курьеру',
            'checked' => false,
        ])
    </div>
</div>
<div class="modal-footer">
    @include('_button_block', ['addAttr' => $usingAjax ? ['id' => 'checkout'] : null, 'type' => $usingAjax ? 'button' : 'submit', 'text' => 'Оформить заказ', 'icon' => 'icon-mail5'])
</div>

<?php $content = ob_get_clean(); ?>
@include('layouts._modal_block', ['id' => 'checkout-modal', 'title' => 'Оформление заказа', 'content' => $content, 'addClass' => isset($addClass) ? $addClass : null])

@if (Session::has('basket') && Session::get('basket')['total'] && Request::has('basket') && Request::input('basket'))
    <script>
        $(window).ready(function () {
            setTimeout(function () {
                $('#checkout-modal').modal('show');
            }, 1000);
        });
    </script>
@endif
