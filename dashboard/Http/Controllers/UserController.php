<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Dashboard tasting list page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function users()
    {
        $users = User::latest()->get();
        return view('dashboard::pages.user.list', [
            'users' => $users,
        ]);
    }

    /**
     * Dashboard tasting item page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function user($id)
    {
        $user = User::findOrNew($id);
        $offices = Office::all();

        return view('dashboard::pages.user.item', [
            'user' => $user,
            'offices' => $offices,
        ]);
    }

    /**
     * Save user
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function postUser(Request $request)
    {
        // $payload = $request->validated();
        // $tasting = Tasting::updateOrCreate(['id' => $request->get('id')], $payload);
        // return redirect(route('dashboard.tasting', ['id' => $request->get('id')]));
    }

    /**
     * Delete tasting user
     *
     * @return array
     */
    // public function deleteTastingUser(Request $request)
    // {
    //     $this->validate($request, [
    //         'tasting_id' => ['required', 'integer', 'exists:tastings,id'],
    //         'user_id' => ['required', 'integer', 'exists:users,id'],
    //     ]);
    //     $tasting = Tasting::findOrFail($request->get('tasting_id'));
    //     $tasting->userToTasting()->detach($request->get('user_id'));
    //     return redirect(route('dashboard.tasting', ['id' => $request->get('tasting_id')]));
    // }
}
