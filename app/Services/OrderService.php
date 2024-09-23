<?php

namespace App\Services;


use App\Services\Interfaces\OrderServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface ;
use App\Repositories\Interfaces\OrderProductRepositoryInterface ;
use App\Repositories\Interfaces\UserRepositoryInterface ;
use App\Repositories\Interfaces\ProductRepositoryInterface ;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;

/**
 * Class UserService
 * @package App\Services
 */

//  Hiện tại, phương thức create trong OrderService chỉ tạo đơn hàng mà
// không lưu thông tin sản phẩm vào bảng order_product. 
// Để thêm tính năng này, bạn cần cập nhật cả OrderRepository và OrderService
// để xử lý việc lưu thông tin sản phẩm vào bảng order_product sau khi tạo đơn hàng

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;
    protected $orderProductRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderProductRepositoryInterface $orderProductRepository,
        ProductRepositoryInterface $productRepository
    ){
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->productRepository = $productRepository;

    }

    public function create($validatedData){
        DB::beginTransaction();
        try{

            // Tạo đơn hàng
            $order = $this->orderRepository->create($validatedData);


            // Lưu thông tin sản phẩm vào bảng order_product
            foreach($validatedData['products'] as $productData){
                // $product = Product::find($productData['id']);
                $product = $this->productRepository->findById($productData['id']);

                if($product){
                    $this->orderProductRepository->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'price_at_order_time' => $productData['price_motion'] ?? $product->price,
                        'quantity' => $productData['quantity'],
                        'product_name' => $product->name,
                        'short_desc' => $product->short_desc,
                        'desc' => $product->desc,
                    ]);
                }
            }

            DB::commit();
            return true;    
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }

    }

    public function update($id, $validatedData){
        DB::beginTransaction();
        try{

            $order = $this->orderRepository->findById($id);
            $order->update($validatedData);

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
                $order = $this->orderRepository->findById($id);

               $order ->delete($id);

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }
}
