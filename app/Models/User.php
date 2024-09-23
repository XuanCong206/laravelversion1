<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'birthday',
        'image',
        'description',
        'user_agent',
        'ip'
    ];

    /*
    Quan hệ này biểu thị một người dùng (User) có thể thực hiện nhiều đơn đặt hàng (Order),
        User có nhiều Order (One-to-Many):
        Trong model User, bạn sử dụng phương thức orders() với quan hệ hasMany(), 
        điều này nghĩa là một người dùng (User) có thể thực hiện nhiều đơn hàng (Order).
    */
        // mối liên hệ giữa Users và Orders
        public function orders(){
            return $this->hasMany(Order::class);
        }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   
}

/* Hoạt động của quan hệ.
*  Một User có nhiều Orders: khi truy cập vào 1 người dùng và muốn lấy tât
cả các đơn hàng của họ, sử dụng:
    $user = User::find(1);
    $orders = $user->orders; // lấy tất cả các đơn hàng của người dùng.

* Một Order thuộc về một User : khi truy cập vào 1 đơn hàng và muốn lấy người
dùng đã đặt đơn hàng đó,

*/
