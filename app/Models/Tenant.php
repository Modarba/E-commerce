<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasFactory;
    protected $fillable = [
        'id',
      'name',
        'domain',
        'database_name',
        'database_username',
        'database_password',
    ];
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
