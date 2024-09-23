<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService
 * @package App\Services
 */

class OrderRepository implements OrderRepositoryInterface
{
  protected $order;

  public function __construct(
    Order $order
  ){
    $this->order = $order;
  }

  public function create($validatedData){
   return $this->order->create($validatedData);

   
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
