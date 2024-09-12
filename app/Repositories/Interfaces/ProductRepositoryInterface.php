<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface ProductRepositoryInterface
{
    public function getAllPaginate();

    public function create($productData);

    public function findById(int $productId,
         array $column = ['*'],
        array $relation = []
    );
    public function update(int $id=0,$productData);
    public function delete($id);
    

}
