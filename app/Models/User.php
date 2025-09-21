<?php
namespace App\Models;
use App\Exceptions\AuthenticationFailedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public static function registerUser(array $data)
    {
        $user = self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('user');
        return $user;
    }
    public static function attemptLogin(array $credentials)
    {
        if (!\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            throw new AuthenticationFailedException();
        }
        $user = \Illuminate\Support\Facades\Auth::user();
        $role = $user->hasRole('admin') ? 'admin' : 'user';
        $token = $user->createToken($role . '_auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
            'role' => $role,
        ];
    }
    public function logout()
    {
        $this->tokens()->delete();
        return ['message' => 'تم تسجيل الخروج بنجاح'];
    }
}
