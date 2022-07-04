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
                    <el-upload
                        drag
                        class="avatar-uploader"
                        list-type="picture"
                        :show-file-list="false"
                        :http-request="postImageUpload"
                        :limit="1"
                    >
                        <div class="" v-if="product.image">
                            <img class="el-upload-list__item-thumbnail" :src="product.image" onerror="this.src='/images/default.jpg'" />
                            <span class="el-upload-list__item-actions">
                                <span class="el-upload-list__item-delete" @click="handleImageRemove(product)">
                                    <el-icon>Удалить</el-icon>
                                </span>
                            </span>
                        </div>
                        <template v-else>
                            <div style="padding: 60px 0;">
                                <i class="el-icon el-icon--upload icon-plus2"></i>
                                <div class="el-upload__text">Перетащите файл или <em>нажмите для загрузки</em></div>
                            </div>
                        </template>
                    </el-upload>
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <!-- Название -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Название*</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input required placeholder="Название продукта" class="el-width-1-1" v-model="product.name"></el-input>
								</div>
							</div>
                            <!-- Категория товара -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Категория товара*</label>
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
                            <!-- Короткое описание -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Короткое описание</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Короткое описание товара" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" maxlength="255" show-word-limit v-model="product.short_description"></el-input>
								</div>
							</div>
                            <!-- Описание -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Описание*</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input required type="textarea" placeholder="Описание товара" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.description"></el-input>
								</div>
							</div>
                            <!-- Цена за целое (p) -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Цена за целое (p)*</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input required type="number" :min="0" :max="100000" placeholder="Описание товара" class="el-width-1-1" v-model="product.whole_price"></el-input>
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
								<label class="col-md-3 col-lg-3 control-label text-semibold">Вес целого (г)*</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input required type="number" :min="0" :max="5000" placeholder="Описание товара" class="el-width-1-1" v-model="product.whole_weight"></el-input>
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
                            <!-- Дополнительно -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Дополнительно</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Дополнительная информация о товаре" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.additionally"></el-input>
								</div>
							</div>
                            <!-- Параметры -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"></label>
								<div class="col-md-9 col-lg-9">
                                    <el-checkbox v-model="product.parts">Торгуется на развес</el-checkbox>
                                    <el-checkbox v-model="product.new">Новинка</el-checkbox>
                                    <el-checkbox v-model="product.action">Акционный продукт</el-checkbox>
								</div>
							</div>
                            <!-- Похожие товары -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold">Похожие товары</label>
								<div class="col-md-9 col-lg-9">
                                    <el-select
                                        multiple
                                        filterable
                                        remote
                                        placeholder="Выберите один или несколько товаров (начните вводить имя товара)"
                                        :disabled="!product.id"
                                        :remote-method="suggestProducts"
                                        :loading="state.isSuggestLoading"
                                        :multiple-limit="3"
                                        v-model="product.related_products"
                                        class="el-width-1-1"
                                    >
                                        <el-option v-for="item in recommendedList" :key="item.id" :value="item.id" :label="item.name">
                                            <div class="">
                                                <span class="el-suggest-item--image"><img loading="lazy" :src="item.image" :alt="item.name" onerror="this.src='/images/default.jpg'"></span>
                                                <div class="el-suggest-item--title" v-text="item.name"></div>
                                                <div class="el-suggest-item--subtitle" v-text="item.category.name"></div>
                                            </div>
                                        </el-option>
                                    </el-select>
								</div>
							</div>
                            <!-- Гастрономическое сочетание -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-store2 mr-10"></i>Гастрономическое сочетание</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Гастрономическое сочетание товара" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.gastro_combination"></el-input>
								</div>
							</div>
                            <!-- Алкогольное сочетание -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-lab mr-10"></i>Алкогольное сочетание</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="Алкогольное сочетание товара" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" maxlength="255" show-word-limit v-model="product.alcohol_combination"></el-input>
								</div>
							</div>
                            <!-- Питательные вещества -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-droplets mr-10"></i>Питательные вещества</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="textarea" placeholder="белки, жири, углеводы" class="el-width-1-1" :rows="2" :autosize="{minRows: 2, maxRows: 4}" v-model="product.nutrients"></el-input>
								</div>
							</div>
                            <!-- Сычужный тип -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-microscope mr-10"></i>Сычужный тип</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="text" placeholder="Ферментного, животного или бактериального происхождения" class="el-width-1-1" maxlength="255" show-word-limit v-model="product.rennet_type"></el-input>
								</div>
							</div>
                            <!-- Выдержка -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-watch2 mr-10"></i>Выдержка</label>
								<div class="col-md-9 col-lg-9">
                                    <el-input type="text" placeholder="Срок выдержки" class="el-width-1-1" maxlength="255" show-word-limit v-model="product.aging"></el-input>
								</div>
							</div>
                            <!-- Активность товара -->
                            <div class="form-group">
								<label class="col-md-3 col-lg-3 control-label text-semibold"><i class="icon-eye mr-10"></i>Активность товара</label>
								<div class="col-md-9 col-lg-9">
                                    <el-switch v-model="product.active"></el-switch>
								</div>
							</div>
                        </div>
                    </div>

                    <div class="text-right">
                        <el-link v-if="product.id" target="_blank" :href="route('face.product', {slug: product.slug})">Перейти на страницу товара</el-link>
                        <el-button class="ml-10" type="danger" text @click="removeProduct">Удалить</el-button>
                        <el-button native-type="submit" type="success" :loading="state.isLoading" :disabled="state.isLoading">Сохранить</el-button>
                    </div>
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
