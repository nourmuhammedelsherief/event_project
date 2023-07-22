<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;
    protected $table = 'dates';
    protected $fillable = [
        'event_date',
    ];
    protected $casts = ['event_date' => 'datetime'];
    public function periods()
    {
        return $this->hasMany(Period::class , 'date_id');
    }

}
