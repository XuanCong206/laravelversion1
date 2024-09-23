<?php

namespace App\Services;


use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as  UserRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Storage;


/**
 * Class UserService
 * @package App\Services
 */
class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    )
    {   
        $this->productRepository = $productRepository;   
    }

    // trả ra tất cả bản ghi trong csdl
    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
      
        $perPage = $request->integer('perpage');
        $users = $this->productRepository->pagination(
            $this->paginateSelect(), 
            $condition, 
            [],
            ['path' => 'user/index'], 
            $perPage,
        );
        
        // dd($users);

        
        return $users;
    }



    public function create($productData){

        DB::beginTransaction();
        try{

            $product = $this->productRepository->create($productData);

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id , $productData){
        DB::beginTransaction();
        try{
         
            $product = $this->productRepository->findById($id);
            $product->update($productData);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }


    public function destroy($id ){
        DB::beginTransaction();
        try{
                // Lấy thông tin sản phẩm cần xóa từ CSDL
                $product = $this->productRepository->findById($id);

                if (!$product) {
                    return redirect()->route('product.index')->with('error', 'Sản phẩm không tồn tại.');
                }

                // Xóa ảnh đại diện nếu có
                if ($product->feature_image) {
                    Storage::disk('public')->delete($product->feature_image); // Xóa ảnh đại diện
                }

                // Xóa tất cả các ảnh trong thư viện (nếu có)
                if ($product->galery) {
                    $galleryImages = json_decode($product->galery, true);
                    foreach ($galleryImages as $image) {
                        Storage::disk('public')->delete($image); // Xóa từng ảnh trong thư viện
                    }
                }
                
            $product = $this->productRepository->delete($id);

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    // xử lý ảnh rồi COntroller sử dụng.
    public function handleImages($request, $existingGallery = [], $existingFeatureImage = null)
    {
        // Xử lý ảnh đại diện
        $imagePath = $existingFeatureImage; // Giữ ảnh hiện tại nếu không có ảnh mới
        if ($request->hasFile('image')) {

            // Xóa ảnh đại diện cũ nếu có ảnh mới được tải lên.
            if($existingFeatureImage){
                Storage::disk('public')->delete($existingFeatureImage); // xóa ảnh cũ
            }

            // Lưu ảnh dại diện mới vào thư mục 'public/images/'
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Lưu ảnh vào thư mục 'public/images'
        }

        // Xử lý thư viện ảnh
        $galleryPaths = $existingGallery; // Bắt đầu với các ảnh hiện có
        if ($request->hasFile('images')) {

            // Xóa tất cả ảnh cũ trong thư viện nếu có ảnh mới được tải lên.
            if (!empty($existingGallery)){
                foreach ($existingGallery as $oldImage){
                    Storage::disk('public')->delete($oldImage); // Xóa ảnh cũ
                }
            }

            // Lưu các ảnh mới vào thư mục 'public/images'
            $galleryPaths = []; // Xóa mảng ảnh cũ nếu có ảnh mới
            foreach ($request->file('images') as $file) {
                $galleryPaths[] = $file->store('images', 'public'); // Lưu ảnh vào thư mục 'public/images'
            }
        }

        return [
            'feature_image' => $imagePath ,
            'galery' => json_encode($galleryPaths) // Chuyển mảng đường dẫn ảnh thành JSON
        ];
    }



    private function paginateSelect(){
        return [
            'id', 
            'email', 
            'phone',
            'address', 
            'name',
        ];
    }
}
