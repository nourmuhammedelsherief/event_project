<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPeriod extends Model
{
    use HasFactory;
    protected $table = 'user_periods';
    protected $fillable = [
        'user_id',
        'period_id',
        'status',
        'admin_id',
        'attendance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class , 'admin_id');
    }
    public function period()
    {
        return $this->belongsTo(Period::class , 'period_id');
    }
}
