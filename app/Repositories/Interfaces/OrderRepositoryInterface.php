<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface OrderRepositoryInterface
{
    // public function getAllPaginate();

    public function create($validatedData);

    public function findById(int $orderId,
         array $column = ['*'],
        array $relation = []
    );

    public function update(int $id=0,$validatedData);
    public function delete($id);
    

}
