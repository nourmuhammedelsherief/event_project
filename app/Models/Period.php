<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $table = 'periods';
    protected $fillable = [
        'name',
        'date_id',
        'start_at',
        'end_at',
        'status',
        'people_count'
    ];
    public function date()
    {
        return $this->belongsTo(Date::class , 'date_id');
    }
}
