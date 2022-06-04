@extends('dashboard::layouts.default')

@section('style')
<link rel="stylesheet" type="text/css" media="all" href="{{ mix('style/dashboard/product-item.css') }}">
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $product->name ?: 'Новый продукт' }}</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                {{ csrf_field() }}
                @if ($product->id)
                    <input type="hidden" name="id" value="{{ $product->id }}">
                @endif

                <div class="col-md-3 col-sm-12 col-xs-12">
                    @include('admin._image_block',[
                        'col' => 12,
                        'preview' => $product->id && $product->big_image ? $product->big_image : null,
                        'name' => 'big_image',
                        'label' => 'Большая картинка'
                    ])
                    @include('admin._image_block',[
                        'col' => 12,
                        'preview' => $product->id ? $product->image : null,
                        'name' => 'image',
                        'label' => 'Картинка'
                    ])
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <!-- Категория товара -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Категория товара</label>
								<div class="col-md-9 col-lg-9">
                                    <el-select filterable class="el-width-1-1" v-model="product.category_id">
                                        <el-option v-for="category in categories" :key="category.id" :value="category.id" :label="category.name"></el-option>
                                    </el-select>
								</div>
							</div>
                            <!-- Подкатегория товара -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Подкатегория товара</label>
								<div class="col-md-9 col-lg-9">
                                    <el-select filterable clearable class="el-width-1-1" v-model="product.add_category_id">
                                        <el-option v-for="category in addCategories" :key="category.id" :value="category.id" :label="category.name"></el-option>
                                    </el-select>
								</div>
							</div>
                            <!-- Название -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Название</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input placeholder="Название продукта" class="el-width-1-1" v-model="product.name"></el-input>
								</div>
							</div>
                            <!-- Дополнительно -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Дополнительно</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Дополнительная информация о товаре" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.additionally"></el-input>
								</div>
							</div>
                            <!-- Описание -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Описание</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Описание товара" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.description"></el-input>
								</div>
							</div>
                            <!-- Цена за целое (p) -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Цена за целое (p)</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="number" :min="0" :max="100000" placeholder="Описание товара" class="el-width-1-1" v-model="product.whole_price"></el-input>
								</div>
							</div>
                            <!-- Цена за целое по акции (р) -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Цена за целое по акции (р)</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="number" :min="0" :max="100000" placeholder="Описание товара" class="el-width-1-1" v-model="product.action_whole_price"></el-input>
								</div>
							</div>
                            <!-- Вес целого (г) -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Вес целого (г)</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="number" :min="0" :max="5000" placeholder="Описание товара" class="el-width-1-1" v-model="product.whole_weight"></el-input>
								</div>
							</div>
                            <!-- Цена за 100 г. -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Цена за 100 г. (р)</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="number" :min="0" :max="100000" placeholder="Цена за 100 г." class="el-width-1-1" v-model="product.part_price"></el-input>
								</div>
							</div>
                            <!-- Цена за 100 г. по акции -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Цена за 100 г. по акции (р)</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="number" :min="0" :max="100000" placeholder="Цена за 100 г." class="el-width-1-1" v-model="product.action_part_price"></el-input>
								</div>
							</div>
                            <!-- Параметры -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"></label>
								<div class="col-md-9 col-lg-9">
                                    <el-checkbox v-model="product.parts">Торгуется на развес</el-checkbox>
                                    <el-checkbox v-model="product.active">Продукт активен</el-checkbox>
                                    <el-checkbox v-model="product.new">Новинка</el-checkbox>
                                    <el-checkbox v-model="product.action">Акционный продукт</el-checkbox>
								</div>
							</div>

                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Похожие товары</label>
								<div class="col-md-9 col-lg-9">
                                    <el-select
                                        multiple
                                        filterable
                                        remote
                                        :remote-method="fetchProducts"
                                        :loading="state.isLoading"
                                        v-model="same"
                                        class="el-width-1-1"
                                    >
                                        <el-option v-for="item in recommendedList" :key="item.id" :value="item.id" :label="item.name">
                                            <div class="">

                                            </div>
                                        </el-option>
                                    </el-select>
								</div>
							</div>
                        </div>
                    </div>
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>
    </div>

    @if (isset($data['user']))
        @include('admin._orders_block',['orders' => $data['user']->orders, 'user' => $data['user']])
    @endif

@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/dashboard/product-item.js') }}"></script>
@endsection
