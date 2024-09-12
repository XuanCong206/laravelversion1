<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function __construct()
    {
        
    }

    public function order(){
        /* Eager Loading:
            Khi bạn sử dụng with('user'), Laravel sẽ thực hiện một truy vấn để lấy tất cả các bản ghi từ bảng orders 
            và đồng thời thực hiện một truy vấn khác để lấy tất cả các bản ghi liên quan từ bảng users 
            trong cùng một thao tác.

           Dữ liệu người dùng (user) sẽ được tải trước và đính kèm vào từng đối tượng Order. 
           Điều này có nghĩa là khi bạn truy cập vào mối quan hệ user trong vòng lặp hoặc ở bất kỳ đâu, 
           nó sẽ không thực hiện thêm truy vấn nào nữa, vì dữ liệu đã được tải trước.
        */
        $orders = Order::with('user')->get();
        // $orders = Order::all();

        $config['seo'] = config('apps.user');
        $template = 'backend.order.index';

        return view('backend.dashboard.layout', compact (
            'template',
            'config',
            'orders',
        ));
    }




    public function index()
    {
        $orders = Order::all(); // Lấy tất cả các đơn hàng
        $config['seo'] = config('apps.user');
        $template = 'backend.order.index';

        return view('backend.dashboard.layout', compact('template', 'orders', 'config'));
    }

    public function create()
    {
        $users = User::all();
        $config['seo'] = config('apps.user');
        $template = 'backend.order.store';
       
        return view('backend.dashboard.layout', compact('template', 'users', 'config'));
    }

    public function edit($id){
        $user = $this->userRepository->findById($id);

        $config = [
            'css'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],

            'js'=> [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/location.js',
                'backend/plugin/ckfinder/ckfinder.js',
                'backend/library/finder.js',

            ],

        ];
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';
        $template = 'backend.user.store';
        return view('backend.dashboard.layout', compact (
            'template',
            'config',
          
            'user'

        ));
    }


    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'total_amount' => 'required|numeric',
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->total_amount = $request->total_amount;
        $order->status = $request->status;
        $order->save();

        toastr()->success('Đơn hàng đã được lưu thành công');
        return redirect()->route('user.order');
    }
}
