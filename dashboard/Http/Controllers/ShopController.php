<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Store;

class ShopController extends Controller
{
    /**
     * Dashboard shops edit page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $this->breadcrumbs = ['shops' => 'Магазины'];
        $shops = Store::all();
        return view('dashboard::pages.shops', [
            'shops' => $shops,
        ]);
    }

    public function editShops(Request $request)
    {
        return $this->editPlace($request, new Store(), 'shops');
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
        return redirect('/dashboard/'.$redirect);
    }

    public function deleteShop(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'exists:shops'],
        ]);
        Store::destroy($request->get('id'));
        return redirect(route('dashboard.shops'));
        // return $this->response([
        //     MSG => 'Store success delete',
        // ]);
    }
}
