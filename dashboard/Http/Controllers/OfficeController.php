<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Office;

class OfficeController extends Controller
{
    /**
     * Dashboard office list page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $this->breadcrumbs = ['offices' => 'Офисы'];
        $offices = Office::all();

        return view('dashboard::pages.office', [
            'offices' => $offices,
        ]);
    }

    public function editOffices(Request $request)
    {
        return $this->editPlace($request, new Office(), 'offices');
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

    public function deleteOffice(Request $request)
    {
        return $this->deleteSomething($request, new Office());
    }
}
