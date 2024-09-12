<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        
        if(Auth::id() >0 ){
            return redirect()->route('dashboard.index');
        }

        return view('backend.auth.login');

    }

    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($credentials))
        {
            // nếu thông tin đúng thì sẽ làm gì ở đây
            // khi đăng nhập thành công.
            toastr()->success('Đăng nhập thành công');
            return redirect()->route('user.index');
           
        }else{
            toastr()->error('Đăng nhập không thành công. Hãy thử lại');
            return redirect()->route('auth.admin');
        }
        // nếu thông tin sai thì sẽ làm gì ở đây
        
        
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session() -> invalidate();
        $request->session() -> regenerateToken();

        return redirect()->route('auth.admin');

    }


}
