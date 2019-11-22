<?php

namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Office;
use App\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Category;
use App\AddCategory;
use App\Tasting;
use App\UserToTasting;
use Config;
use Session;
use Settings;

class AdminController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.admin');
    }

    public function index()
    {
        return redirect('/admin/orders');
    }

    public function seo()
    {
        $this->breadcrumbs = ['seo' => 'SEO'];
        $this->data['metas'] = $this->metas;
        $this->data['seo'] = Settings::getSeoTags();
        return $this->showView('seo');
    }

    public function users(Request $request, $slug=null)
    {
        $this->breadcrumbs = ['users' => 'Пользователи'];
        $this->data['offices'] = Office::all();
        if ($request->has('id')) {
            $this->data['user'] = User::find($request->input('id'));
            $this->data['product_parts'] = $this->productParts;
            if (!$this->data['user']) return $this->notExist('Пользователя');
            $this->breadcrumbs = ['users?id='.$this->data['user']->id => $this->data['user']->email];
            return $this->showView('user');
        } else if ($slug && $slug == 'add') {
            $this->breadcrumbs['users/add'] = 'Добавление пользователя';
            return $this->showView('user');
        } else {
            $this->data['users'] = User::orderBy('id','desc')->get();
            return $this->showView('users');
        }
    }
    
    public function products(Request $request, $slug=null)
    {
        $this->breadcrumbs = ['products' => 'Продукты'];
        $this->data['product_parts'] = $this->productParts;
        $this->data['categories'] = Category::all();
        $this->data['add_categories'] = AddCategory::all();
        if ($request->has('id')) {
            $this->data['product'] = Product::find($request->input('id'));
            if (!$this->data['product']) return $this->notExist('Продукта');
            $this->breadcrumbs = ['products?id='.$this->data['product']->id => $this->data['product']->name];
            return $this->showView('product');
        } else if ($slug && $slug == 'add') {
            $this->breadcrumbs['products/add'] = 'Добавление продукта';
            return $this->showView('product');
        } else {
            return $this->showView('products');
        }
    }
    
    public function settings()
    {
        $this->breadcrumbs = ['settings' => 'Настройки'];
        return $this->showView('settings');
    }

    public function offices()
    {
        $this->breadcrumbs = ['offices' => 'Офисы'];
        $this->data['offices'] = Office::all();
        return $this->showView('offices');
    }

    public function shops()
    {
        $this->breadcrumbs = ['shops' => 'Магазины'];
        $this->data['shops'] = Shop::all();
        return $this->showView('shops');
    }
    
    public function tastings(Request $request, $slug=null)
    {
        $this->breadcrumbs = ['tastings' => 'Дегустации'];
        if ($request->has('id')) {
            $this->data['offices'] = Office::where('id','!=',1)->where('id','!=',2)->get();
            $this->data['tasting'] = Tasting::find($request->input('id'));
            if (!$this->data['tasting']) return $this->notExist('Продукта');
            $this->breadcrumbs['tastings?id='.$this->data['tasting']->id] = $this->data['tasting']->name;
            return $this->showView('tasting');
        } else if ($slug && $slug == 'add') {
            $this->data['offices'] = Office::where('id','!=',1)->where('id','!=',2)->get();
            $this->breadcrumbs['tastings/add'] = 'Добавление дегустации';
            return $this->showView('tasting');
        } else {
            $this->data['tastings'] = Tasting::orderBy('time','desc')->get();;
            return $this->showView('tastings');
        }
    }

    public function editSeo(Request $request)
    {
        $this->validate($request, [
            'title' => 'max:255',
            'meta_description' => 'max:4000',
            'meta_keywords' => 'max:4000',
            'meta_twitter_card' => 'max:255',
            'meta_twitter_size' => 'max:255',
            'meta_twitter_creator' => 'max:255',
            'meta_og_url' => 'max:255',
            'meta_og_type' => 'max:255',
            'meta_og_title' => 'max:255',
            'meta_og_description' => 'max:4000',
            'meta_og_image' => 'max:255',
            'meta_robots' => 'max:255',
            'meta_googlebot' => 'max:255',
            'meta_google_site_verification' => 'max:255',
        ]);
        Settings::saveSeoTags($request);
        $this->saveCompleteMessage();
        return redirect('/admin/seo');
    }

    public function editSettings(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        Settings::saveSettings($this->processingFields($request));
        $this->saveCompleteMessage();
        return redirect()->back();
    }

    public function editProduct(Request $request)
    {
        $validationArr = [
            'name' => 'required|unique:products,name',
            'description' => 'required|min:3|max:500',
            'whole_price' => $this->validationPrice,
            'whole_weight' => 'required|integer|min:1|max:5000',
            'part_price' => $this->validationPrice,
            'action_whole_price' => $this->validationPrice,
            'action_part_price' => $this->validationPrice,
            'image' => $this->validationImage,
            'big_image' => $this->validationImage,
            'category_id' => $this->validationCategory,
            'add_category_id' => $this->validationAddCategory
        ];
        $fields = $this->processingFields(
            $request,
            ['action','active','parts'],
            ['image','big_image'],
            null,
            ['whole_price','part_price','action_whole_price','action_part_price']
        );

        if ($request->has('id')) {
            $validationArr['id'] = 'required|integer|exists:products,id';
            $validationArr['name'] .= ','.$request->input('id');

            $this->validate($request, $validationArr);
            $product = Product::find($request->input('id'));

            if ($request->hasFile('image')) 
                $fields = array_merge($fields, $this->processingImage($request, $product, 'image'));
            if ($request->hasFile('big_image'))
                $fields = array_merge($fields, $this->processingImage($request, $product, 'big_image'));
                
            $product->update($fields);

        } else {
            $validationArr['image'] = 'required|'.$this->validationImage;
            $validationArr['big_image'] = 'required|'.$this->validationImage;
            
            $this->validate($request, $validationArr);
            $fields = array_merge(
                $fields,
                $this->processingImage($request, null, 'image', str_slug($fields['name']), 'images/products'),
                $this->processingImage($request, null, 'big_image', str_slug($fields['name']).'_big', 'images/products')
            );
            
            Product::create($fields);
        }

        $this->saveCompleteMessage();
        return redirect('/admin/products');
    }
    
    public function editTasting(Request $request)
    {
        $validationArr = [
            'time' => 'required',
            'office_id' => $this->validationOffice
        ];

        if ($request->has('id')) {
            $validationArr['id'] = $this->validationTasting;
            $this->validate($request, $validationArr);
            $tasting = Tasting::find($request->input('id'));

            $fields = $this->processingFields($request, 'active', null, 'time');
            $tasting->update($fields);
        } else {
            $this->validate($request, $validationArr);
            $fields = $this->processingFields($request, 'active', null, 'time');
            Tasting::create($fields);
        }
        $this->saveCompleteMessage();
        return redirect('/admin/tastings');
    }
    
    public function editTastingsImages(Request $request)
    {
        $validationArr = [];
        $imageFields = [];
        for ($i=1;$i<=3;$i++) {
            $field = 'image'.$i;
            if ($request->hasFile($field)) {
                $validationArr[$field] = 'min:5|max:2000|mimes:jpeg';
                $imageFields[] = $field;
            }
        }
        $this->validate($request, $validationArr);
        if (count($imageFields)) {
            foreach ($imageFields as $field) {
                $imageName = $field.'.jpg';
                $path = 'images/';
                $fullPath = base_path('public/'.$path.$imageName);
                if (file_exists($fullPath)) unlink($fullPath);
                $request->file($field)->move(base_path('public/'.$path),$imageName);
            }
            $this->saveCompleteMessage();
        }
        return redirect('/admin/tastings');
    }

    public function editOffices(Request $request)
    {
        return $this->editPlace($request, new Office(), 'offices');
    }

    public function editShops(Request $request)
    {
        return $this->editPlace($request, new Shop(), 'shops');
    }

    public function deleteUser(Request $request)
    {
        return $this->deleteSomething($request, new User());
    }

    public function deleteProduct(Request $request)
    {
        return $this->deleteSomething($request, new Product(), 'image');
    }

    public function deleteOffice(Request $request)
    {
        return $this->deleteSomething($request, new Office());
    }

    public function deleteShop(Request $request)
    {
        return $this->deleteSomething($request, new Shop());
    }

    public function deleteTasting(Request $request)
    {
        $this->validate($request, ['id' => $this->validationTasting]);
        $tasting = Tasting::find($request->input('id'));
        if (count($tasting->tastingToUsers)) {
            foreach ($tasting->tastingToUsers as $item) {
                $item->delete();
            }
        }
        $tasting->delete();
        return response()->json(['success' => true]);
    }
    
    public function deleteTastingUser(Request $request)
    {
        return $this->deleteSomething($request, new UserToTasting());
    }

    private function editPlace(Request $request, Model $model, $redirect)
    {
        $validationArr = [];
        $addPlace = $request->has('address');
        if ($addPlace) {
//            $validationArr['latitude'] = $this->validationCoordinates;
//            $validationArr['longitude'] = $this->validationCoordinates;
            $validationArr['address'] = 'required|max:255';
        }

        $places = $model->all();
        foreach ($places as $place) {
//            $validationArr['latitude_'.$place->id] = $this->validationCoordinates;
//            $validationArr['latitude_'.$place->id] = $this->validationCoordinates;
            $validationArr['address_'.$place->id] = 'required|max:255';
        }

        $this->validate($request, $validationArr);

        foreach ($places as $place) {
            $place->update([
//                'latitude' => $request->input('latitude_'.$place->id),
//                'longitude' => $request->input('longitude_'.$place->id),
                'address' => $request->input('address_'.$place->id)
            ]);
        }

        if ($addPlace) {
            $model->create([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'address' => $request->input('address')
            ]);
        }
        $this->saveCompleteMessage();
        return redirect('/admin/'.$redirect);
    }
}