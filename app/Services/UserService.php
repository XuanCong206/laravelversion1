<?php

namespace App\Services;


use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as  UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;



/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {   
        $this->userRepository = $userRepository;   
    }

    // trả ra tất cả bản ghi trong csdl
    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
      
        $perPage = $request->integer('perpage');
        $users = $this->userRepository->pagination(
            $this->paginateSelect(), 
            $condition, 
            [],
            ['path' => 'user/index'], 
            $perPage,
        );
        
        // dd($users);

        
        return $users;
    }



    public function create($request){
        DB::beginTransaction();
        try{

            $payload = $request->except(['_token','send','re_password']);
    
            
            $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);

            // $payload['password'] = Hash::make($payload['password']);
            
            // dd($payload);
            $user = $this->userRepository->create($payload);


            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id , $request){
        DB::beginTransaction();
        try{

            $payload = $request->except(['_token','send','re_password']);
            
            $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            $user = $this->userRepository->update($id,$payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    private function convertBirthdayDate($birthday = '')
    {
        $carbonDate = Carbon::createFromFormat('Y-m-d', $birthday);
        $payload['birthday'] = $carbonDate->format('Y-m-d H:i:s');

        return $birthday;
    }


    public function destroy($id ){
        DB::beginTransaction();
        try{
            $user = $this->userRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
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
