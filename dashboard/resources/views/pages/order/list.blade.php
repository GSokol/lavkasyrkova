@extends('dashboard::layouts.default')

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <h3 class="panel-title">История заказов</h3>
    </div>
    <div class="panel-body">
        @if (count($orders))
            <table class="table table-items">
                <tr>
                    <th class="text-center">Номер заказа</th>
                    <th class="text-center">Время создания</th>
                    <th class="text-center">Доставка</th>
                    <!-- <th class="text-center">Дата дегустации</th> -->
                    <th class="text-center">Примечание</th>
                    <th class="text-center col-md-3">Состав</th>
                    <th class="text-center">Статус заказа</th>
                    <th class="text-center">Стоимость</th>
                </tr>
                @foreach ($orders as $order)
                    <tr role="row" id="{{ 'order_'.$order->id }}">
                        <td class="text-center id">{{ $order->id }}</td>
                        <td class="text-center"><a href="{{ route('dashboard.order', ['id' => $order->id]) }}">{{ $order->created_at }}</a></td>
                        <td class="text-center">{{ $order->delivery_info }}</td>
                        <!-- <td class="text-center">
                            if ($order->user->office_id > 2 && !$order->delivery && !$order->shop_id)
                                foreach($order->user->office->tastings as $tasting)
                                    if ($tasting->time > $order->created_at->timestamp)
                                        date('d.m.Y', tasting->time) }}
                                        break
                                    endif
                                endforeach
                            endif
                        </td> -->
                        <td class="text-left">{{ $order->description }}</td>
                        <td class="text-left">@include('admin._order_content_block', ['order' => $order])</td>
                        <td class="text-center">
                            <span class="label label-{{ $order->status->class_name }}">{{ $order->status->name }}</span>
                        </td>
                        <td class="text-center">{{ $order->total_amount }} руб.</td>
                    </tr>
                @endforeach
            </table>
        @else
            <h1 class="text-center">История заказов пуста</h1>
        @endif
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/dashboard/order.js') }}"></script>
@endsection
