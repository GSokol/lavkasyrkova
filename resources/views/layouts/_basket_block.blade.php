@if (Auth::guest() || !Auth::user()->is_admin)
    <div class="basket total-cost-basket {{ $className }}">
        <span class="sum">{{ Session::has('basket') ? Session::get('basket')['total'] : '0' }}р.</span><i class="icon-cart5"></i>
        <ul class="dropdown-menu">
            <li><a {{ Auth::guest() ? '' : 'data-toggle=modal' }} href="{{ Auth::guest() ? url('/login') : '#checkout-modal' }}">Оформить заказ</a></li>
            <li><a id="empty-basket" href="#">Очистить корзину</a></li>
        </ul>
    </div>
@endif