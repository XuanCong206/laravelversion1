<?php

namespace App\Services\Interfaces;

/**
 * Interface ProductServiceInterface
 * @package App\Services\Interfaces
 */
interface OrderServiceInterface
{
    // public function paginate($request);

    public function create($validatedData);

    public function update($id,$validatedData);

    public function destroy($id);

}


