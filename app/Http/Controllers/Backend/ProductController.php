<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Services\Interfaces\ProductServiceInterface;

use App\Repositories\Interfaces\ProductRepositoryInterface;



class ProductController extends Controller
{
    protected $productService; 
    protected $productRepository; 

    public function __construct(
        ProductServiceInterface $productService, // dependency injection 
        ProductRepositoryInterface $productRepository, // dependency injection 


    ){
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    // Ở đây sẽ vào dashboard của product
    public function index(){

        // Lấy tất cả thông tin từ bảng Product trong CSDL
       $products = Product::all();

       // Lấy breadcrumbs
       $config['seo'] = config('apps.user');

        // Lấy giao diện index của product trong view
       $template = 'backend.product.index';

        // Trả về view
       return view('backend.dashboard.layout', compact(
        'config',
        'template',
        'products'
        ));

    }

    // Hiển thị form thêm sản phẩm.(PHƯƠNG THỨC GET)
    public function create(){
        // Lấy tất cả thông tin từ bảng Product trong CSDL
       $products = Product::all();
        
         // Lấy breadcrumbs
       $config['seo'] = config('apps.user');
       $config['method'] = 'create';

       // Lấy giao diện index của product trong view
      $template = 'backend.product.store';

       // Trả về view
      return view('backend.dashboard.layout', compact(
       'config',
       'template',
       'products'
   
       ));
    }


    // Xủ lý thêm sản phẩm ( PHƯƠNG THỨC POST)
    public function store(StoreProductRequest $request)
    {
        // Xử lý ảnh đại diện và thư viện ảnh
        $imagesData = $this->productService->handleImages($request);

        // Kiểm tra và sinh slug nếu chưa có
        $slug = $request->input('slug') ?: Product::generateSlug($request->input('name'));

        // Tạo dữ liệu sản phẩm với thông tin ảnh
        $productData = array_merge($request->validated(), $imagesData, ['slug' => $slug]);

        if ($this->productService->create($productData)) {
            toastr()->success('Thêm mới sản phẩm thành công');
            return redirect()->route('product.index');
        } else {
            toastr()->error('Thêm mới sản phẩm không thành công. Hãy thử lại');
            return redirect()->route('product.index');
        }
    }


    // Hiển thị form sửa sản phẩm ( PHƯƠNG THỨC GET)
    public function edit($id){

        // Lấy product id
        $product = $this->productRepository->findById($id);
        
        // Lấy tất cả thông tin từ bảng Product trong CSDL
       $products = Product::all();

        // Lấy breadcrumbs
       $config['seo'] = config('apps.user');
       $config['method'] = 'edit';

       // Lấy giao diện index của product trong view
      $template = 'backend.product.store';

       // Trả về view
      return view('backend.dashboard.layout', compact(
       'config',
       'template',
       'product',
       'products',
       ));
    }


    // Xử lý sửa sản phẩm ( PHƯƠNG THỨC POST)
    public function update($id, UpdateProductRequest $request)
    {
        // Lấy thông tin sản phẩm hiện tại từ CSDL
        $product = $this->productRepository->findById($id);

        // Xử lý ảnh đại diện và thư viện ảnh
        $imagesData = $this->productService->handleImages($request, json_decode($product->galery, true), $product->feature_image);
        
         // Tạo slug từ tên sản phẩm, kiểm tra tính duy nhất
          $slug = Product::generateSlug($request->input('name'));

        // Tạo dữ liệu sản phẩm với thông tin ảnh
        $productData = array_merge($request->validated(), $imagesData,['slug' => $slug]);

        if ($this->productService->update($id, $productData)) {
            toastr()->success('Cập nhật sản phẩm thành công');
            return redirect()->route('product.index');
        } else {
            toastr()->error('Cập nhật sản phẩm không thành công. Hãy thử lại');
            return redirect()->route('product.index');
        }
    }

    
    

    //XỬ LÝ XÓA SẢN PHẨM ( PHƯƠNG THỨC DELETE)
    public function delete($id){
        // Lấy product id
        $product = $this->productRepository->findById($id);
        
        // Lấy breadcrumbs
       $config['seo'] = config('apps.user');

       // Lấy giao diện index của product trong view
      $template = 'backend.product.delete';

       // Trả về view
      return view('backend.dashboard.layout', compact(
       'config',
       'template',
       'product'
       ));
    }

    public function destroy($id){

        
        if($this->productService->destroy($id)){
            toastr()->success('Xóa sản phẩm thành công');
            return redirect()->route('product.index');
        }else{
            toastr()->error('Xóa sản phẩm không thành công. Hãy thử lại');
            return redirect()->route('product.index');

        }
    }

    // Hiển thị chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Lấy giao diện chi tiết sản phẩm của product trong view
        // $template = 'backend.product.show';
        return view('backend.product.show', compact(
  
            'product'
            ));
    }

}


