<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\Interfaces\OrderProductRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService
 * @package App\Services
 */

class OrderProductRepository  implements OrderProductRepositoryInterface
{
  protected $orderProduct;

  public function __construct(
    OrderProduct  $orderProduct
  ){
    $this->orderProduct = $orderProduct;
  }

  public function create(array $data){
   return $this->orderProduct->create($data);

  }

  public function findById(
    int $orderId,
      array $column = ['*'],
      array $relation = [],
  ){
    return $this->order->select($column)->with($relation)->findOrFail($orderId);
  }

  public function update(int $id=0,$validatedData){
    $order = $this ->findById($id);
    return $order->update($validatedData);
  }
  
  public function delete($id){
    return $this ->findById($id)->delete();
  }
    

}
