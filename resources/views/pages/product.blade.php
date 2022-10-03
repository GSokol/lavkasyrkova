@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="{{ mix('style/face/product.css') }}">
@endsection

@section('content')
    <div class="container" style="padding-bottom: 100px;">
        <h1>
            {{ $product->name }}
            @if ($product->addCategory)
                <img src="{{ asset('images/' . $product->addCategory->image) }}" alt="{{ $product->addCategory->name }}" title="{{ $product->addCategory->name }}" style="margin-left: 20px;">
            @endif
        </h1>
        <h6>
            <a href="{{ route('face.category', ['slug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
        </h6>
        <div class="row el-flex@sm el-flex-column@sm">
            <!-- slider -->
            <div class="col-md-6 mb-20 el-flex-overfirst image">
                <in-carousel ref="mainCarousel" :wrap-around="true">
                    <in-slide v-for="(media, index) in slides" :key="index">
                        <div class="carousel__item">
                            <img :src="media.path" alt="" onerror="this.src='/images/default.jpg'">
                        </div>
                    </in-slide>
                    <template #addons v-if="slides.length > 1">
                        <in-navigation />
                        <in-pagination />
                    </template>
                </in-carousel>

                <in-carousel class="carousel-thumbnails" :settings="thumbnailSettings" :breakpoints="thumbnailBreakpoints" v-if="slides.length > 1">
                    <in-slide v-for="(media, index) in slides" :key="index">
                        <div class="carousel__item" @mouseover="onThumbnailClick(index)">
                            <img :src="media.path" alt="" onerror="this.src='/images/default.jpg'">
                        </div>
                    </in-slide>
                    <template #addons>
                        <in-navigation />
                        <in-pagination />
                    </template>
                </in-carousel>
            </div>
            <!-- delivery info -->
            <div class="col-md-6 el-flex-overfirst">
                <span class="info-block">Бесплатная доставка при заказе от 3000 руб.</span>
            </div>
            <!-- price -->
            <div class="col-md-6 el-flex-overfirst">
                <span class="price-block">{!! Helper::productCostSting($product) !!}</span>
                @if ($product->active)
                    @include('_input_value_block', [
                        'name' => 'product_'.$product->id,
                        'min' => 0,
                        'max' => $product->parts ? Helper::getProductParts()[count(Helper::getProductParts())-1] : 100,
                        'class' => 'narrow',
                        'unit' => Helper::productUnit($product),
                        'differentially' => $product->parts,
                        'price' => Helper::productPrice($product),
                        'increment' => $product->parts ? json_encode(Helper::getProductParts()) : 1,
                        'value' => Session::has('basket') ? Session::get('basket')[$product->id]['value'] : 0,
                    ])
                @else
                    <h5>Товара нет в наличии</h5>
                @endif
            </div>
            <!-- params -->
            <div class="col-md-6 el-flex-last@sm">
                <div class="mb-20">
                    <img class="iconograph" src="/images/icon-time.svg" alt="Выдержка">
                    <span class="param-title width">Выдержка</span> {{ $product->aging ?: '-' }}
                </div>

                <div class="mb-10">
                    <img class="iconograph" src="/images/icon-cheese.svg" alt="Сычужный тип">
                    <span class="param-title width">Сычужный тип</span> {{ $product->rennet_type ?: '-' }}
                </div>

                <div class="mb-10">
                    <img class="iconograph" src="/images/icon-shelf-life.svg" alt="Срок хранения">
                    <span class="param-title width">Срок хранения</span> {{ $product->shelf_life ?: '-' }}
                </div>

                <div class="mb-20">
                    <img class="iconograph" src="/images/icon-drop.svg" alt="Питательные вещества">
                    <span class="param-title width">Питательные вещества</span>
                    <div class="" style="display: inline-block; vertical-align: top;">{!! nl2br($product->nutrients) ?: '-' !!}</div>
                </div>
            </div>

            <div class="col-md-6 float-md-right">
                <div class="mb-20 alcohol-combination-block">
                    <img class="iconograph" src="/images/icon-dish.svg" alt="Гастрономическое сочетание">
                    <span class="param-title">Гастрономическое сочетание</span>
                    <div class="description">{{ $product->gastro_combination ?: '-' }}</div>
                </div>
            </div>

            <!-- Фантазийное описание -->
            <div class="col-md-6 el-flex-first@sm">
                <div class="mb-20">{{ $product->art_description }}</div>
            </div>
            <!-- Алкоголь -->
            <div class="col-md-6 float-md-right">
                <div class="mb-20 alcohol-combination-block">
                    <img class="iconograph" src="/images/icon-wine.svg" alt="Белое и красное сухое вино">
                    <span class="param-title">Алкоголь к сыру</span>
                    <div class="description">{{ $product->alcohol_combination ?: '-' }}</div>
                </div>
            </div>
            <!-- Полное описание -->
            <div class="col-md-6 el-flex-first@sm">
                <div class="mb-20">{{ $product->description }}</div>
            </div>

            <div class="col-md-6">
                <div class="mt-20">{{ $product->additionally }}</div>
            </div>
        </div>

        @if (count($product->related))
            <h3>Рекомендуем</h3>
            <div class="row">
                @foreach($product->related as $product)
                    <?php $value = 0; ?>

                    @if (isset($data['order']))
                        @foreach($data['order']->orderToProducts as $item)
                            @if ($item->product->id == $product->id)
                                @if ($item->whole_value)
                                    <?php $value = $item->whole_value; ?>
                                @elseif ($item->part_value)
                                    <?php $value = $item->part_value; ?>
                                @endif
                                @break
                            @endif
                        @endforeach
                    @elseif (Session::has('basket'))
                        @foreach(Session::get('basket') as $id => $item)
                            @if ($id == $product->id)
                                <?php $value = $item['value']; ?>
                                @break
                            @endif
                        @endforeach
                    @endif

                    @include('_product_block', [
                        'product' => $product,
                        'value' => $value,
                        'useCost' => true,
                    ])
                @endforeach
            </div>
        @endif
    </div>

    <!-- @ include('components.tasting') -->
    @include('components.info')
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/face/product-item.js') }}"></script>
@endsection
