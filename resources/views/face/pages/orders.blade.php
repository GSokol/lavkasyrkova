@extends('admin.layouts.default')

@section('content')

@include('admin._modal_delete_block', ['modalId' => 'delete-modal', 'function' => 'delete-order', 'head' => 'Вы действительно хотите удалить этот заказ?'])
{{ csrf_field() }}

<div class="panel panel-flat">
    <div class="panel-heading">
        <h3 class="panel-title">История заказов</h3>
    </div>
    <div class="panel-body">
        @if (count($orders))
            <table class="table table-items">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Время создания</th>
                        <th class="text-center col-md-2">Доставка</th>
                        <th class="text-center">Примечание</th>
                        <th class="text-center col-md-2">Состав</th>
                        <th class="text-center">Статус заказа</th>
                        <th class="text-center">Стоимость</th>
                        <th class="text-center"></th>
                        <th class="text-center">Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="{warning: order.isNew}" v-for="(order, index) in collection" :key="order.id">
                        <td class="text-center id" v-text="order.id"></td>
                        <td class="text-center" v-text="order.created_at"></td>
                        <td class="text-center"><span v-text="order.delivery_info"></span></td>
                        <td class="text-left"><span v-text="order.description"></span></td>
                        <td class="text-left">
                            <template v-if="order.order_to_products.length">
                                <div class="" v-for="orderProduct in order.order_to_products">
                                    <strong v-text="orderProduct.product.name"></strong> — <span v-text="orderProduct.quantity_unit + ' ' + (orderProduct.actual_value ? '[реальный вес ' + orderProduct.actual_value +' г.]' : '')"></span> <i v-text="'(' + orderProduct.amount + 'руб.)'"></i>
                                </div>
                            </template>
                        </td>
                        <td class="text-center">
                            <span class="label" :class="'label-' + order.status.class_name" v-text="order.status.name"></span>
                        </td>
                        <td class="text-center" v-text="order.total_amount + ' руб.'"></td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-icon btn-rounded" data-popup="tooltip" title="Повторить заказ" data-placement="top" @click="onRepeatOrder(order)"><i class="icon-reset"></i></button>
                        </td>
                        <td class="delete">
                            <span class="glyphicon glyphicon-remove-circle" v-if="order.status.id === 1" @click="onDeleteOrder(order, index)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <h1 class="text-center">История заказов пуста</h1>
        @endif
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/face/profile-order.js') }}"></script>
@endsection
