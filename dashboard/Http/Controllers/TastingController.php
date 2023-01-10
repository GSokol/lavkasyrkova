<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Coderello\SharedData\Facades\SharedData;
use Dashboard\Http\Requests\TastingPostRequest;
use App\Models\Office;
use App\Models\Tasting;

class TastingController extends Controller
{
    /**
     * Dashboard tasting list page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $tastings = Tasting::with(['office'])
            ->orderBy('time', 'desc')
            ->get()
            ->map(function($row) {
                $row->time_format = date('d.m.Y', $row->time);
                $row->in_time = $row->time > time();
                return $row;
            });
        SharedData::put([
            'tastings' => $tastings,
        ]);

        return view('dashboard::pages.tasting.list', [
            'tastings' => $tastings,
        ]);
    }

    /**
     * Dashboard tasting item page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function item($id)
    {
        $tasting = Tasting::findOrNew($id);
        $offices = Office::whereNotIn('id', [1, 2])->get();
        $this->breadcrumbs['tastings/'.$tasting->id] = $tasting->name;
        return view('dashboard::pages.tasting.item', [
            'offices' => $offices,
            'tasting' => $tasting,
        ]);
    }

    /**
     * Dashboard tasting item page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function postTasting(TastingPostRequest $request)
    {
        $payload = $request->validated();
        $tasting = Tasting::updateOrCreate(['id' => $request->get('id')], $payload);
        return redirect(route('dashboard.tasting', ['id' => $request->get('id')]));
    }

    /**
     * Delete tasting
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function deleteTasting(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'exists:tastings,id'],
        ]);
        Tasting::destroy($request->get('id'));
        return $this->response([MSG => 'Дегустация успешно удалена']);
    }

    /**
     * Delete tasting user
     *
     * @return array
     */
    public function deleteTastingUser(Request $request)
    {
        $this->validate($request, [
            'tasting_id' => ['required', 'integer', 'exists:tastings,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        $tasting = Tasting::findOrFail($request->get('tasting_id'));
        $tasting->userToTasting()->detach($request->get('user_id'));
        return redirect(route('dashboard.tasting', ['id' => $request->get('tasting_id')]));
    }
}
