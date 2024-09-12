<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\BaseRepository;



use App\Services\Interfaces\UserServiceInterface as UserService;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;

use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;




class UserController extends Controller
{
    protected $userService; // khai báo biến
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        /* Dependency injection là kiểu 
        * Là một kỹ thuật khi mà một Object phụ thuộc vào 1 Object khác.
        * 1 class A tác dụng với phương thức bên trong class B.
        * Object đó sẽ gọi 1 service khác,
	    * service đó có nhiệm vụ khởi tạo các Object phụ thuộc.
        * --
        * UserService: LÀ lớp cụ thể( hoặc đối tượng  - như ở đây là UserServiceInterface) sẽ được truyền vào khi lớp hiện  tại được khởi tạo
        * Laravel tự động cung cấp đối tượng UserService vào constructor của lớp nếu đã đăng ký UserService trong container của laravel.
        * Lớp hiện tại ( ví dụ là 1 controller) phụ thuộc vào userService ( Dependency Injection). 
        * -> kiểu userService là 1 class . trong controller mà ở 1 phương thức. là nhuư v .
        * Và bạn sử dụng Dependency Injection để đưa UserService vào lớp đó.
        */
        UserService $userService,



        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,

    ){
        /*
        * Đoạn $this->userService = $userService; gán giá trị cho thuộc tính $userService của lớp
        * bằng đối tượng UserService được truyền vào từ DJ.
        * thằng $userService có dữ liệu thằng UserService. nó sẽ gán cho thằng $this->userService
        *
        * lúc này ở các phương thức khác trong UserController.
        * ta có thể sử dụng  $this->userService -> 1 cái phương thức nào đó của UserServiceInterface as UserService. 
        * -----
        * Có thể hiểu như sau. 
        * $this->userService là 1 phương thức của 1 class. nó phụ thuộc vào 1 class khác. kiểu nó sẽ tác động đến 1 phương thức cả class đó. 
        * như phương thức AA của class A - muốn dùng ( phụ thuộc với ) phương thuức BB của class B thì nó phải dùng Dependency Injection
        */
        $this->userService = $userService;


        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;

    }
    // $userService : gọi là dependency injection.
    // Biến $userService đại diện cho UserService
    // bây giờ mà muốn gọi bất kì phuương thức nào trong này thì dùng
    // $this->userService
    

    public function index(Request $request)
    {   
        // Dùng trực tiếp Eloquent. - phân trang đến 15
        // $users = User::paginate(15); 
      
        // Dùng MVC - service
        $users = $this->userService->paginate($request);
       
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js'
            ],  
            'css' =>[
                'backend/css/plugins/switchery/switchery.css'
            ]   
        ];
        $config['seo'] = config('apps.user');
      

        $template = 'backend.user.index';
        return view('backend.dashboard.layout', compact (
            'template',
            'config',
            'users',
        ));
    }

    public function create()
    { 

        $provinces = $this->provinceRepository->all();

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
        $config['method']= 'create';
        $template = 'backend.user.store';
        return view('backend.dashboard.layout', compact (
            'template',
            'config',
            'provinces'

        ));
    }

    // Gửi thông tin để đăng kí người dùng
    public function store(StoreUserRequest $request){
        if($this->userService->create($request)){
            toastr()->success('Thêm mới bản ghi thành công');
            return redirect()->route('user.index');
        }else{
            toastr()->error('Thêm mới bản ghi không thành công. Hãy thử lại');
            return redirect()->route('user.index');

        }
    }


    public function edit($id){
        $user = $this->userRepository->findById($id);
       

        $provinces = $this->provinceRepository->all();

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
            'provinces',
            'user'

        ));
    }

    public function update($id, UpdateUserRequest $request){
        if($this->userService->update($id, $request)){
            toastr()->success('Cập nhật bản ghi thành công');
            return redirect()->route('user.index');
        }else{
            toastr()->error('Có lỗi xảy ra khi cập nhật bản ghi');
            return redirect()->route('user.index');
        }
    }

    public function delete($id){
        $user = $this->userRepository->findById($id);
        $config['seo'] = config('apps.user');

        $template = 'backend.user.delete';
        return view('backend.dashboard.layout', compact (
            'template',
            'user',
            'config'

        ));
    }

    // }
    public function destroy($id){
        if($this->userService->destroy($id)){
            toastr()->success('Xóa bản ghi thành công');
            return redirect()->route('user.index');
        } else {
            toastr()->error('Có lỗi xảy ra khi xóa bản ghi');
            return redirect()->route('user.index');
        }
    }
    



}
