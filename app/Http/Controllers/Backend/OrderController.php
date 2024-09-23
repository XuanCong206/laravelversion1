<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;


use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderProduct;

use App\Services\Interfaces\OrderServiceInterface;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;

    public function __construct(
        OrderServiceInterface $orderService,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }
    public function index()
    {
        $orders = Order::all(); // Lấy tất cả các đơn hàng trong csdl
        $config['seo'] = config('apps.user');
        $template = 'backend.order.index';

        return view('backend.dashboard.layout', compact('template', 'orders', 'config'));
    }

    // Hiển thị bảng .
    public function order(){
        /* Eager Loading:
            Khi bạn sử dụng with('user'), Laravel sẽ thực hiện một truy vấn để lấy tất cả các bản ghi từ bảng orders 
            và đồng thời thực hiện một truy vấn khác để lấy tất cả các bản ghi liên quan từ bảng users 
            trong cùng một thao tác.

           Dữ liệu người dùng (user) sẽ được tải trước và đính kèm vào từng đối tượng Order. 
           Điều này có nghĩa là khi bạn truy cập vào mối quan hệ user trong vòng lặp hoặc ở bất kỳ đâu, 
           nó sẽ không thực hiện thêm truy vấn nào nữa, vì dữ liệu đã được tải trước.
        */
        $orders = Order::with('user','products')->get();
        // $orders = Order::all();
       


        $products = Product::all();

        $order_products = OrderProduct::all();

        $config['seo'] = config('apps.user');
        $template = 'backend.order.index';

        return view('backend.dashboard.layout', compact (
            'template',
            'config',
            'orders',
            'products',
            'order_products',
        ));
    }


    

    // Hiển thị form thêm đơn hàng.(PHƯƠNG THỨC GET)
    public function create()
    {
        $users = User::all();

        $products = Product::all();

        $orders = Order::with('user','products')->get();


        $order_products = OrderProduct::all();

        // Lấy breadrumb
        $config['method'] = 'create';
        $config['seo'] = config('apps.user');
        $template = 'backend.order.store';
       
        return view('backend.dashboard.layout', compact(
            'template',
             'users', 
             'config',
             'products',
             'order_products',
             'orders'
             )
        );
    }

      // Xử lý thêm sản phẩm ( PHƯƠNG THỨC POST)
      public function store(StoreOrderRequest $request)
      {
          $validatedData = $request->validated(); // Lấy dữ liệu đã được xác thực
          
  
          if ($this->orderService->create($validatedData)) {
              toastr()->success('Thêm mới đơn hàng thành công');
              return redirect()->route('user.order');
          } else {
              toastr()->error('Thêm mới đơn hàng không thành công. Hãy thử lại');
              return redirect()->route('user.order');
          }
      }

     // Hiển thị form sửa sản phẩm ( PHƯƠNG THỨC GET)
    public function edit($id){

        // Lấy order id - thao tác với csdl thì dùng repository
        $order = $this->orderRepository->findById($id);
        $products = Product::all();
        
        $orders = Order::with('user','products')->get();


        // $orders = Order::all();

        // Lấy tất cả thông tin từ bảng Users trong CSDL
        $users = User::all();

        $selectedUser = $order->user; // Lấy thông tin người dùng liên quan đến đơn hàng

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

          // Lấy breadcrumbs
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';

        $template = 'backend.order.store';
        return view('backend.dashboard.layout', compact (
            'template',
            'config',
            'order',
            'orders',
            'users',
            'selectedUser',
            'products',

        ));
    }

     // Xử lý sửa sản phẩm ( PHƯƠNG THỨC POST)
        public function update($id , UpdateOrderRequest $request){

            $validatedData = $request->validated();

            if ($this->orderService->update($id, $validatedData)) {
                toastr()->success('Cập nhật đơn hàng thành công');
                return redirect()->route('user.order');
            } else {
                toastr()->error('Cập nhật đơn hàng không thành công. Hãy thử lại');
                return redirect()->route('user.order');
            }
        }

    // xử lý xóa sản phẩm ( Phương thức delete)
    public function delete($id){
           // Lấy product id
           $order = $this->orderRepository->findById($id);
        
           // Lấy breadcrumbs
          $config['seo'] = config('apps.user');
   
          // Lấy giao diện index của product trong view
         $template = 'backend.order.delete';
   
          // Trả về view
         return view('backend.dashboard.layout', compact(
          'config',
          'template',
          'order'
          ));
    }

    public function destroy($id){
        if ($this->orderService->destroy($id)) {
            toastr()->success('Xóa đơn hàng thành công');
            return redirect()->route('user.order');
        } else {
            toastr()->error('Xóa đơn hàng không thành công. Hãy thử lại');
            return redirect()->route('user.order');
        }
    }


  
}



   
