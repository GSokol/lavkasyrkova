<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Office;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tasting;
use App\Models\UserToTasting;
use App\Models\User;
use Auth;
use Session;
use Settings;

class AdminController extends UserController
{
    public function users(Request $request, $slug=null)
    {
        $this->breadcrumbs = ['users' => 'Пользователи'];
        $this->data['offices'] = Office::all();
        if ($request->has('id')) {
            $this->data['user'] = User::find($request->input('id'));
            $this->data['product_parts'] = $this->productParts;
            if (!$this->data['user']) return $this->notExist('Пользователя');
            $this->breadcrumbs['users?id='.$this->data['user']->id] = $this->data['user']->email;
            return $this->showView('user');
        } else if ($slug && $slug == 'add') {
            $this->breadcrumbs['users/add'] = 'Добавление пользователя';
            return $this->showView('user');
        }
    }

    public function tastings(Request $request, $slug = null)
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
        }
    }

    public function editTasting(Request $request)
    {
        $validationArr = [
            'time' => 'required',
            'office_id' => 'required|integer|exists:offices,id'
        ];
        $fields = $this->processingFields($request, 'active', null, 'time');

        if ($request->has('id')) {
            $validationArr['id'] = 'required|integer|exists:tastings,id';
            $this->validate($request, $validationArr);
            $tasting = Tasting::find($request->input('id'));
            $tasting->update($fields);
        } else {
            $this->validate($request, $validationArr);
            $fields['informed'] = 0;
            Tasting::create($fields);
        }
        $this->saveCompleteMessage();
        return redirect('/dashboard/tastings');
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
        return redirect('/dashboard/tastings');
    }

    public function editShops(Request $request)
    {
        return $this->editPlace($request, new Store(), 'shops');
    }

    public function deleteUser(Request $request)
    {
        return $this->deleteSomething($request, new User());
    }

    public function deleteProduct(Request $request)
    {
        return $this->deleteSomething($request, new Product(), 'image');
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
            if ($request->input('latitude') || $request->input('longitude')) {
                $validationArr['latitude'] = 'regex:/^(\d{2}\.\d{5,6})$/';
                $validationArr['longitude'] = 'regex:/^(\d{2}\.\d{5,6})$/';
            }
            $validationArr['address'] = 'required|max:255';
        }

        $places = $model->all();
        foreach ($places as $place) {
            if ($request->input('latitude') || $request->input('longitude')) {
                $validationArr['latitude_' . $place->id] = 'regex:/^(\d{2}\.\d{5,6})$/';
                $validationArr['latitude_' . $place->id] = 'regex:/^(\d{2}\.\d{5,6})$/';
            }
            $validationArr['address_'.$place->id] = 'required|max:255';
        }

        $this->validate($request, $validationArr);

        foreach ($places as $place) {
            $place->update([
                'latitude' => $request->input('latitude_'.$place->id),
                'longitude' => $request->input('longitude_'.$place->id),
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
        return redirect('/dashboard/'.$redirect);
    }
}
