@extends('admin.layouts.default')

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <h3 class="panel-title">Заказ #{{ $order->id }}</h3>
    </div>

    <div class="panel-body">
        <form class="form-horizontal" action="#">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset class="content-group">
                        <legend class="text-bold"><i class="icon-truck position-left"></i> Данные заказа</legend>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Дата и время</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">
                                    <span>{{ $order->created_at }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Статус</label>
                            <div class="col-lg-10">
                                <select name="select" class="form-control" :class="statusClassName" v-model="order.status_id">
                                    <option value="" disabled hidden>Укажите статус заказа</option>
                                    <option :value="status.id" v-for="status in orderStatuses" v-text="status.name"></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Сумма</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">111</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Доставка</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">@include('admin._delivery_place_block', ['order' => $order])</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Примечание</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">{{ $order->description ?: '-' }}</div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset class="content-group">
                        <legend class="text-bold"><i class="icon-reading position-left"></i> Данные клиента</legend>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Имя</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">{{ $order->user->name }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Телефон</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">{{ $order->user->phone }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                                <div class="form-control-static">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <fieldset class="content-group">
                <legend class="text-bold">Состав заказа</legend>

                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 20px;">ID</th>
                                <th>Наименование товара</th>
                                <th>Категория товара</th>
                                <th class="">Количество</th>
                                <th class="text-right">Стоимость</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderToProducts as $orderProduct)
                                <tr>
                                    <td><tt>{{ $orderProduct->product_id }}</tt></td>
                                    <td>
                                        <div class="media-left media-middle">
                                            <a href="#"><img src="{{ asset($orderProduct->product->image) }}" class="img-circle img-xs" alt=""></a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a href="#" class="text-default text-semibold">{{ $orderProduct->product->name }}</a></div>
                                            <div class="text-muted text-size-small text-truncate" style="max-width: 300px;">{{ $orderProduct->product->additionally ?: $orderProduct->product->description }}</div>
                                        </div>
                                    </td>
                                    <td><span class="">{{ $orderProduct->product->category->name }}</span></td>
                                    <td><span class="">{{ $orderProduct->quantity_unit }}</span></td>
                                    <td class="text-right"><h6 class="text-semibold">{{ $orderProduct->amount }} руб.</h6></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </fieldset>

            <div class="row invoice-payment">
				<div class="col-sm-7"></div>
				<div class="col-sm-5">
					<div class="content-group">
						<div class="table-responsive no-border">
							<table class="table">
								<tbody>
									<tr>
										<th>Сумма:</th>
										<td class="text-right"><h5 v-text="orderAmount + ' руб.'">0</h5></td>
									</tr>
									<tr>
										<th>
                                            <div class="input-group">
												<span class="input-group-addon">Скидка</span>
												<input type="number" class="form-control" min="0" max="50" placeholder="Введите размер скидки" v-model.number="order.discount_value">
											</div>
                                        </th>
										<td class="text-right"><h5 v-text="discountAmount + ' руб.'">0</h5></td>
									</tr>
									<tr>
										<th>Итого:</th>
										<td class="text-right text-primary"><h5 class="text-semibold" v-text="totalAmount + ' руб.'">0</h5></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="text-right">
							<button type="button" class="btn btn-success btn-labeled"><b><i class="icon-paperplane"></i></b> Сохранить</button>
						</div>
					</div>
				</div>
			</div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/admin/order.js') }}"></script>
@endsection
