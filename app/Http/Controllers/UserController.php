<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Shop;
use App\Office;
use App\UserToTasting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Settings;

class UserController extends Controller
{
    use HelperTrait;
    
    protected $breadcrumbs = [];
    protected $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('/profile/orders');
    }

    public function orders()
    {
        $this->breadcrumbs = ['orders' => 'Заказы'];
        $this->getTastings();
        $this->data['orders'] = Auth::user()->is_admin ? Order::orderBy('id','desc')->get() : Order::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        return $this->showView('orders');
    }

    public function user()
    {
        $this->breadcrumbs = ['user' => 'Профиль пользователя'];
        $this->getTastings();
        $this->data['user'] = Auth::user();
        $this->data['offices'] = Office::all();
        return $this->showView('user');
    }
    
    public function signingTasting()
    {
        $tasting = $this->getNewTasting();
        if ($tasting) {
            UserToTasting::create(['user_id' => Auth::user()->id,'tasting_id' => $tasting->id]);
            $this->sendMessage(Auth::user()->email, 'auth.emails.tasting', ['title' => 'Подписка на дегустацию', 'tasting' => $tasting], $this->getMasterMail());
            return response()->json(['success' => true, 'message' => 'Вы подписались на дегустацию!']);
        } else return response()->json(['success' => false, 'message' => 'Нет активных дегустаций!']);
    }

    public function editUser(Request $request)
    {
        $validationArr = [
            'email' => 'required|email|unique:users,email',
            'phone' => $this->validationPhone,
            'office_id' => $this->validationOffice
        ];
        
        $fields = $this->processingFields(
            $request,
            (Auth::user()->is_admin ? ['active','is_admin'] : null),
            (Auth::user()->is_admin ? 'old_password' : ['old_password', 'active','is_admin'])
        );
        
        $fields['password'] = bcrypt($fields['password']);

        if ($request->has('id')) {
            $validationArr['id'] = $this->validationUser;
            $validationArr['email'] .= ','.$request->input('id');
            if (Auth::user()->is_admin && $request->has('office_id')) $validationArr['office_id'] = $this->validationOffice;

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

        } elseif (Auth::user()->is_admin) {
            $validationArr['password'] = $this->validationPassword;
            $validationArr['office_id'] = $this->validationOffice;
            $this->validate($request, $validationArr);
            User::create($fields);
        }

        $this->saveCompleteMessage();
        if (Auth::user()->is_admin) return redirect('/admin/users');
        else return redirect('/profile/user');
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
        if (Auth::user()->is_admin || (Auth::user()->id == $order->user->id && $order->status == 1)) {
            $this->sendMessage($order->user->email, 'auth.emails.new_order', ['title' => 'Заказ удален', 'order' => $order], (string)Settings::getSettings()->email);
            $order->delete();
            return response()->json(['success' => true]);
        } else return response()->json(['success' => false]);
    }

    protected function showView($view)
    {
        if (!Auth::user()->is_admin) {
            $this->data['products'] = Product::where('active',1)->get();
            if (!isset($this->data['shops'])) $this->data['shops'] = Shop::all();
        }

        $menus = [
            ['href' => '/', 'name' => 'На главную страницу', 'icon' => 'icon-list-unordered'],
            ['href' => 'orders', 'name' => 'Заказы', 'icon' => 'icon-home']
        ];

        if (Auth::user()->is_admin) {
            $addMenus = [
                ['href' => 'seo', 'name' => 'SEO', 'icon' => 'icon-price-tags'],
                ['href' => 'products', 'name' => 'Продукты', 'icon' => 'icon-pie5'],
                ['href' => 'settings', 'name' => 'Настройки', 'icon' => 'icon-gear'],
                ['href' => 'offices', 'name' => 'Офисы', 'icon' => 'icon-office'],
                ['href' => 'shops', 'name' => 'Магазины', 'icon' => 'icon-basket'],
                ['href' => 'tastings', 'name' => 'Дегустации', 'icon' => 'icon-trophy2'],
                ['href' => 'users', 'name' => 'Пользователи', 'icon' => 'icon-users']
            ];
        } else $addMenus = [['href' => 'user', 'name' => 'Профиль пользователя', 'icon' => 'icon-profile']];

        return view('admin.'.$view, [
            'breadcrumbs' => $this->breadcrumbs,
            'data' => $this->data,
            'prefix' => Auth::user()->is_admin ? 'admin' : 'profile',
            'menus' => array_merge($menus, $addMenus)
        ]);
    }
}
