<?php

namespace App\Http\Controllers;

use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Office;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tasting;
use App\Models\UserToTasting;
use App\Models\User;
use Session;
use Settings;

class UserController extends Controller
{
    use HelperTrait;

    protected $breadcrumbs = [];
    protected $data = [];

    public function index()
    {
        return redirect('/profile/orders');
    }

    public function orders()
    {
        $tastings = Tasting::getUserTasting(Auth::user());
        $this->breadcrumbs = ['orders' => 'Заказы'];
        $orders = Order::with(['status:id,name,class_name', 'orderToProducts.product'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get()
            ->transform(function($order) {
                $order->setAppends(['total_amount', 'delivery_info']);
                return $order;
            });

        SharedData::put([
            'collection' => $orders,
        ]);

        return view('pages.orders', [
            'breadcrumbs' => $this->breadcrumbs,
            'tastings' => $tastings,
            'orders' => $orders,
        ]);
    }

    public function user(Request $request)
    {
        $this->breadcrumbs = ['user' => 'Профиль пользователя'];
        $user = Auth::user();
        $offices = Office::all();
        if ($request->has('unsubscribe') && $request->input('unsubscribe')) {
            $user->send_mail = 0;
            $user->save();
            Session::flash('message', 'Вы отписались от автоматической рассылки!');
        }
        return view('pages.user', [
            'breadcrumbs' => $this->breadcrumbs,
            'offices' => $offices,
            'user' => $user,
        ]);
    }

    public function signingTasting()
    {
        $tasting = $this->getNewTasting();
        if ($tasting) {
            UserToTasting::create(['user_id' => Auth::user()->id,'tasting_id' => $tasting->id]);
            $this->sendMessage(Auth::user()->email, 'emails.tasting', ['title' => 'Подписка на дегустацию', 'tasting' => $tasting], $this->getMasterMail());
            return response()->json(['success' => true, 'message' => 'Вы подписались на дегустацию!']);
        } else return response()->json(['success' => false, 'message' => 'Нет активных дегустаций!']);
    }

    public function editUser(Request $request)
    {
        $validationArr = [
            'email' => 'required|email|unique:users,email',
            'phone' => $this->validationPhone,
            'office_id' => 'required|integer|exists:offices,id',
        ];

        $fields = $this->processingFields(
            $request,
            (Auth::user()->is_admin ? ['active','is_admin','send_mail'] : 'send_mail'),
            (Auth::user()->is_admin ? 'old_password' : ['old_password', 'active','is_admin'])
        );

        $fields['password'] = bcrypt($fields['password']);

        if ($request->filled('id')) {
            $validationArr['id'] = 'required|exists:users,id';
            $validationArr['email'] .= ','.$request->input('id');
            if (Auth::user()->is_admin && $request->has('office_id')) $validationArr['office_id'] = 'required|integer|exists:offices,id';

            if ($request->has('password') && $request->input('password')) {
                if (!Auth::user()->is_admin) $validationArr['old_password'] = 'required|min:3|max:50';
                $validationArr['password'] = $this->validationPassword;
            } else unset($fields['password']);

            $this->validate($request, $validationArr);
            $user = User::find($request->input('id'));

            if ($user->id != Auth::user()->id && !Auth::user()->is_admin)
                return redirect()->back()->withInput()->withErrors(['email' => 'Вы пытаетесь редактировать не своего пользователя!']);

            if ($request->has('old_password') && $request->input('old_password') && !Hash::check($request->input('old_password'),$user->password) && !Auth::user()->is_admin)
                return redirect()->back()->withInput()->withErrors(['old_password' => 'Не верный старый пароль']);

            $user->update($fields);

        } elseif (auth('dashboard')->user()->is_admin) {
            $validationArr['password'] = $this->validationPassword;
            $validationArr['office_id'] = 'required|integer|exists:offices,id';
            $this->validate($request, $validationArr);
            User::create($fields);
        }

        $this->saveCompleteMessage();
        if (Auth::user()->is_admin) {
            return redirect(route('dashboard.users'));
        }
        return redirect(route('face.profile.user'));
    }

    public function checkoutOrder(Request $request)
    {
        $basket = new BasketController();
        $result = $basket->checkoutOrder($request, false);

        if ($result['success']) {
            Session::flash('message',$result['message']);
        } else {
            $message = '';
            foreach ($result['errors'] as $error) {
                $message .= '<div class="error">'.$error.'</div>';
            }
            Session::flash('message',$message);
        }
        return redirect()->back();
    }

    public function deleteOrder(Request $request)
    {
        $this->validate($request, ['id' => 'required|integer|exists:orders,id']);
        $order = Order::find($request->input('id'));
        $statusNew = OrderStatus::code(OrderStatus::ORDER_STATUS_NEW)->first();
        if (Auth::user()->is_admin || (Auth::user()->id == $order->user->id && $order->status_id == $statusNew->id)) {
            $this->sendMessage($order->user->email, 'emails.new_order', ['title' => 'Заказ удален', 'order' => $order], (string)Settings::getSettings()->email);
            $order->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    protected function showView($view)
    {
        // dump(Auth::guard('web'));

        // if (!Auth::user()->is_admin) {
        //     $this->data['products'] = Product::where('active',1)->get();
        //     if (!isset($this->data['shops'])) $this->data['shops'] = Store::all();
        // }

        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('admin.'.$view, [
            'breadcrumbs' => $this->breadcrumbs,
            'data' => $this->data,
            'tastings' => $tastings,
        ]);
    }
}
