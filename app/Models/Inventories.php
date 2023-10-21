<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventories extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'name',
        'price',
        'stock'
    ];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class, 'id');
    }
}
