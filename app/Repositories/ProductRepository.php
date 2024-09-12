<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\BaseRepository;



/**
 * Class UserService
 * @package App\Services
 */

class ProductRepository implements ProductRepositoryInterface
{
    protected $product;

    public function __construct(
        Product $product
    ){
      $this->product = $product;
    }

    public function getAllPaginate()
    {
       return  Product::paginate(15);
    }

    public function create($productData)
    {
       return $this->product->create($productData);
    }

    public function findById(
      int $productId,
      array $column = ['*'],
      array $relation = [],

    ){
      return $this->product->select($column)->with($relation)->findOrFail($productId);
    }

    public function update(int $id=0,$productData){
      $product = $this ->findById($id);
      return $product->update($productData);
    }

    public function delete($id){
      return $this ->findById($id)->delete();
    }
  
    

}
