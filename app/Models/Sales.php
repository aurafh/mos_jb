<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'number',
        'date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class);
    }
}
