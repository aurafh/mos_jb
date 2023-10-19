<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'sales_id',
        'inventory_id',
        'qty',
        'price'
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }
    
    public function inventory()
    {
        return $this->belongsTo(Inventories::class);
    }

    
}
